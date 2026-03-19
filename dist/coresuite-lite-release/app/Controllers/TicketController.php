<?php
use Core\DB;
use Core\Auth;
use Core\Locale;
use Core\RolePermissions;

// app/Controllers/TicketController.php

class TicketController {
    private function authorizeCreate() {
        if (!RolePermissions::canCurrent('tickets_create')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    private function ticketIndexBaseSql(bool $isCustomer, array $filters): string {
        $whereSql = $filters ? ' AND ' . implode(' AND ', $filters) : '';

        if ($isCustomer) {
            return "
                SELECT
                    t.id,
                    t.customer_id,
                    t.category,
                    t.subject,
                    t.priority,
                    t.status,
                    t.created_at,
                    NULL AS customer_name
                FROM tickets t
                WHERE t.customer_id = ?" . $whereSql;
        }

        return "
            SELECT
                t.id,
                t.customer_id,
                t.category,
                t.subject,
                t.priority,
                t.status,
                t.created_at,
                u.name AS customer_name
            FROM tickets t
            JOIN users u ON t.customer_id = u.id
            WHERE 1=1" . $whereSql;
    }

    private function ticketIndexOrderSql(string $sortBy, string $sortDir): string {
        $direction = $sortDir === 'asc' ? 'ASC' : 'DESC';
        $sortableColumns = [
            'id' => 'id',
            'subject' => 'subject',
            'category' => 'category',
            'priority' => 'priority',
            'status' => 'status',
            'customer_name' => 'customer_name',
            'created_at' => 'created_at',
        ];

        $column = $sortableColumns[$sortBy] ?? null;
        if ($column === null) {
            return ' ORDER BY created_at DESC, id DESC';
        }

        $secondaryOrder = $sortBy === 'created_at' ? 'id DESC' : 'created_at DESC';
        return ' ORDER BY ' . $column . ' ' . $direction . ', ' . $secondaryOrder;
    }

    private function exportTicketsCsv(array $tickets): void {
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="tickets-export.csv"');

        $stream = fopen('php://output', 'w');
        if ($stream === false) {
            http_response_code(500);
            exit;
        }

        fwrite($stream, "\xEF\xBB\xBF");
        fputcsv($stream, ['ID', 'Subject', 'Category', 'Priority', 'Status', 'Customer', 'Created at']);

        foreach ($tickets as $ticket) {
            fputcsv($stream, [
                (int)($ticket['id'] ?? 0),
                (string)($ticket['subject'] ?? ''),
                (string)($ticket['category'] ?? ''),
                (string)($ticket['priority'] ?? ''),
                (string)($ticket['status'] ?? ''),
                (string)($ticket['customer_name'] ?? ''),
                (string)($ticket['created_at'] ?? ''),
            ]);
        }

        fclose($stream);
        exit;
    }

    public function list($params = []) {
        $user = Auth::user();
        $isCustomer = Auth::isCustomer();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;
        $offset = ($page - 1) * $perPage;
        $search = trim($_GET['q'] ?? '');
        $statusFilter = trim($_GET['status'] ?? '');
        $priorityFilter = trim($_GET['priority'] ?? '');
        $sortBy = trim((string)($_GET['sort'] ?? ''));
        $sortDir = strtolower(trim((string)($_GET['dir'] ?? 'desc')));
        $exportFormat = trim((string)($_GET['format'] ?? ''));
        $filters = [];
        $paramsSql = [];
        $validStatuses = ['open', 'in_progress', 'resolved', 'closed'];
        $validPriorities = ['low', 'medium', 'high'];

        if (!in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'desc';
        }

        if ($isCustomer) {
            $paramsSql[] = $user['id'];
            if ($search !== '') {
                $filters[] = "(subject LIKE ? OR category LIKE ?)";
                $like = '%' . $search . '%';
                $paramsSql[] = $like;
                $paramsSql[] = $like;
            }
            if (in_array($statusFilter, $validStatuses, true)) {
                $filters[] = "status = ?";
                $paramsSql[] = $statusFilter;
            }
            if (in_array($priorityFilter, $validPriorities, true)) {
                $filters[] = "priority = ?";
                $paramsSql[] = $priorityFilter;
            }
        } else {
            if ($search !== '') {
                $filters[] = "(t.subject LIKE ? OR t.category LIKE ? OR u.name LIKE ?)";
                $like = '%' . $search . '%';
                $paramsSql[] = $like;
                $paramsSql[] = $like;
                $paramsSql[] = $like;
            }
            if (in_array($statusFilter, $validStatuses, true)) {
                $filters[] = "t.status = ?";
                $paramsSql[] = $statusFilter;
            }
            if (in_array($priorityFilter, $validPriorities, true)) {
                $filters[] = "t.priority = ?";
                $paramsSql[] = $priorityFilter;
            }
        }

        $baseSql = $this->ticketIndexBaseSql($isCustomer, $filters);
        $orderSql = $this->ticketIndexOrderSql($sortBy, $sortDir);

        $countStmt = DB::prepare("SELECT COUNT(*) AS total FROM (" . $baseSql . ") ticket_index");
        $countStmt->execute($paramsSql);
        $total = (int)($countStmt->fetch()['total'] ?? 0);

        $summaryStmt = DB::prepare("SELECT COUNT(*) AS visible_total, SUM(CASE WHEN status = 'open' THEN 1 ELSE 0 END) AS open_total, SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) AS in_progress_total, SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) AS resolved_total, SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) AS closed_total, SUM(CASE WHEN priority = 'high' THEN 1 ELSE 0 END) AS high_priority_total FROM (" . $baseSql . ") ticket_index");
        $summaryStmt->execute($paramsSql);
        $ticketSummary = $summaryStmt->fetch() ?: [];

        if ($exportFormat === 'csv') {
            $exportStmt = DB::prepare("SELECT * FROM (" . $baseSql . ") ticket_index" . $orderSql);
            $exportStmt->execute($paramsSql);
            $this->exportTicketsCsv($exportStmt->fetchAll());
        }

        $stmt = DB::prepare("SELECT * FROM (" . $baseSql . ") ticket_index" . $orderSql . " LIMIT ? OFFSET ?");
        $listParams = $paramsSql;
        $listParams[] = $perPage;
        $listParams[] = $offset;
        $stmt->execute($listParams);
        $tickets = $stmt->fetchAll();
        $totalPages = max(1, ceil($total / $perPage));

        include __DIR__ . '/../Views/tickets.php';
    }

    public function board($params = []) {
        $user = Auth::user();
        $statuses = ['open', 'in_progress', 'resolved', 'closed'];
        $ticketBoard = [];

        foreach ($statuses as $status) {
            if (Auth::isCustomer()) {
                $stmt = DB::prepare("SELECT id, subject, category, priority, status, created_at FROM tickets WHERE customer_id = ? AND status = ? ORDER BY created_at DESC LIMIT 20");
                $stmt->execute([$user['id'], $status]);
            } else {
                $stmt = DB::prepare("SELECT t.id, t.subject, t.category, t.priority, t.status, t.created_at, u.name AS customer_name FROM tickets t JOIN users u ON t.customer_id = u.id WHERE t.status = ? ORDER BY t.created_at DESC LIMIT 20");
                $stmt->execute([$status]);
            }

            $ticketBoard[$status] = $stmt->fetchAll();
        }

        include __DIR__ . '/../Views/tickets_board.php';
    }

    public function create($params = []) {
        $this->authorizeCreate();
        include __DIR__ . '/../Views/ticket_form.php';
    }

    public function store($params = []) {
        $this->authorizeCreate();
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $error = Locale::runtime('csrf_invalid');
            include __DIR__ . '/../Views/ticket_form.php';
            return;
        }

        $user = Auth::user();
        $category = trim($_POST['category'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $body = trim($_POST['body'] ?? '');
        $priority = $_POST['priority'] ?? 'medium';

        // Validazione
        $validation = new Validation();
        if (!$validation->validate(['category' => $category, 'subject' => $subject, 'body' => $body], [
            'category' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ])) {
            $error = implode(', ', $validation->getErrors());
            include __DIR__ . '/../Views/ticket_form.php';
            return;
        }

        // Valida priorità
        $validPriorities = ['low', 'medium', 'high'];
        if (!in_array($priority, $validPriorities)) {
            $priority = 'medium';
        }

        $stmt = DB::prepare("INSERT INTO tickets (customer_id, category, subject, priority) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user['id'], $category, $subject, $priority]);

        $ticketId = DB::lastInsertId();

        // Aggiungi primo commento
        $stmt = DB::prepare("INSERT INTO ticket_comments (ticket_id, author_id, body, visibility) VALUES (?, ?, ?, 'public')");
        $stmt->execute([$ticketId, $user['id'], $body]);

        // Handle optional attachment for ticket creation
        if (!empty($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            try {
                $att = $_FILES['attachment'];
                $ext = strtolower(pathinfo($att['name'], PATHINFO_EXTENSION));
                $storageName = bin2hex(random_bytes(12)) . '.' . $ext;
                $dest = __DIR__ . '/../../storage/tickets/' . $storageName;
                if (!is_dir(dirname($dest))) mkdir(dirname($dest), 0755, true);
                move_uploaded_file($att['tmp_name'], $dest);
                // Save meta JSON
                $meta = [
                    'ticket_id' => $ticketId,
                    'original_name' => $att['name'],
                    'stored_name' => $storageName,
                    'uploaded_by' => $user['id'],
                    'uploaded_at' => date('c')
                ];
                $metaPath = __DIR__ . '/../../storage/tickets/meta/' . $storageName . '.json';
                if (!is_dir(dirname($metaPath))) mkdir(dirname($metaPath), 0755, true);
                file_put_contents($metaPath, json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            } catch (\Throwable $e) {
                // ignore attachment errors
            }
        }

        Auth::logAction('create', 'ticket', $ticketId);
        Auth::flash(Locale::runtime('ticket_created'), 'success');
        header('Location: /tickets');
        exit;
    }

    public function show($params = []) {
        $id = (int)$params['id'];
        $stmt = DB::prepare("SELECT t.*, u.name as customer_name, a.name as assigned_name FROM tickets t JOIN users u ON t.customer_id = u.id LEFT JOIN users a ON t.assigned_to = a.id WHERE t.id = ?");
        $stmt->execute([$id]);
        $ticket = $stmt->fetch();

        if (!$ticket) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }

        // Controlla permessi
        $user = Auth::user();
        if (Auth::isCustomer() && $ticket['customer_id'] != $user['id']) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            return;
        }

        // Filtro visibilità commenti: customer vede solo public
        if (Auth::isCustomer()) {
            $stmt = DB::prepare("SELECT c.*, u.name as author_name FROM ticket_comments c JOIN users u ON c.author_id = u.id WHERE c.ticket_id = ? AND c.visibility = 'public' ORDER BY c.created_at ASC");
        } else {
            $stmt = DB::prepare("SELECT c.*, u.name as author_name FROM ticket_comments c JOIN users u ON c.author_id = u.id WHERE c.ticket_id = ? ORDER BY c.created_at ASC");
        }
        $stmt->execute([$id]);
        $comments = $stmt->fetchAll();

        // Per assegnazione: lista operatori/admin
        $operators = [];
        if (Auth::isOperator() && RolePermissions::canCurrent('tickets_manage')) {
            $stmtOp = DB::prepare("SELECT id, name FROM users WHERE role IN ('admin','operator') AND status = 'active' ORDER BY name");
            $stmtOp->execute();
            $operators = $stmtOp->fetchAll();
        }

        // Carica eventuali allegati da storage/tickets/meta
        $attachments = [];
        try {
            $metaDir = __DIR__ . '/../../storage/tickets/meta';
            if (is_dir($metaDir)) {
                $files = scandir($metaDir);
                foreach ($files as $f) {
                    if (substr($f, -5) !== '.json') continue;
                    $json = @file_get_contents($metaDir . '/' . $f);
                    $m = json_decode($json, true);
                    if ($m && isset($m['ticket_id']) && $m['ticket_id'] == $id) {
                        $attachments[] = $m;
                    }
                }
            }
        } catch (\Throwable $e) {
            $attachments = [];
        }

        include __DIR__ . '/../Views/ticket_detail.php';
    }

    public function addComment($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /tickets/' . (int)$params['id']);
            exit;
        }

        $id = (int)$params['id'];
        $body = trim($_POST['body'] ?? '');
        $visibility = $_POST['visibility'] ?? 'public';

        if (empty($body)) {
            header('Location: /tickets/' . $id);
            exit;
        }

        // Customer può solo scrivere commenti public
        if (Auth::isCustomer()) {
            $visibility = 'public';
        }

        // Valida visibility
        if (!in_array($visibility, ['public', 'internal'])) {
            $visibility = 'public';
        }

        $user = Auth::user();
        $stmt = DB::prepare("INSERT INTO ticket_comments (ticket_id, author_id, body, visibility) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id, $user['id'], $body, $visibility]);

        // Handle optional attachment for comment
        if (!empty($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            try {
                $att = $_FILES['attachment'];
                $ext = strtolower(pathinfo($att['name'], PATHINFO_EXTENSION));
                $storageName = bin2hex(random_bytes(12)) . '.' . $ext;
                $dest = __DIR__ . '/../../storage/tickets/' . $storageName;
                if (!is_dir(dirname($dest))) mkdir(dirname($dest), 0755, true);
                move_uploaded_file($att['tmp_name'], $dest);
                // Save meta JSON linking to ticket and latest comment
                $meta = [
                    'ticket_id' => $id,
                    'comment_by' => $user['id'],
                    'original_name' => $att['name'],
                    'stored_name' => $storageName,
                    'uploaded_at' => date('c')
                ];
                $metaPath = __DIR__ . '/../../storage/tickets/meta/' . $storageName . '.json';
                if (!is_dir(dirname($metaPath))) mkdir(dirname($metaPath), 0755, true);
                file_put_contents($metaPath, json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            } catch (\Throwable $e) {
                // ignore
            }
        }

        Auth::logAction('comment', 'ticket', $id);
        header('Location: /tickets/' . $id);
        exit;
    }

    public function updateStatus($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /tickets/' . (int)$params['id']);
            exit;
        }

        $id = (int)$params['id'];
        $status = $_POST['status'] ?? '';

        // Valida status
        $validStatuses = ['open', 'in_progress', 'resolved', 'closed'];
        if (!in_array($status, $validStatuses)) {
            Auth::flash(Locale::runtime('status_invalid'), 'danger');
            header('Location: /tickets/' . $id);
            exit;
        }

        if (Auth::isOperator() && RolePermissions::canCurrent('tickets_manage')) {
            $stmt = DB::prepare("UPDATE tickets SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            Auth::logAction('update_status', 'ticket', $id);
        }

        header('Location: /tickets/' . $id);
        exit;
    }

    public function assignTicket($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /tickets/' . (int)$params['id']);
            exit;
        }

        $id = (int)$params['id'];
        $assignedTo = $_POST['assigned_to'] ?? '';

        if (!Auth::isOperator() || !RolePermissions::canCurrent('tickets_manage')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            return;
        }

        // Null se vuoto, altrimenti int
        $assignedTo = $assignedTo === '' ? null : (int)$assignedTo;

        $stmt = DB::prepare("UPDATE tickets SET assigned_to = ? WHERE id = ?");
        $stmt->execute([$assignedTo, $id]);

        Auth::logAction('assign', 'ticket', $id);
        Auth::flash(Locale::runtime('ticket_assigned'), 'success');
        header('Location: /tickets/' . $id);
        exit;
    }
}
