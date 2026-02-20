<?php
use Core\DB;
use Core\Auth;

// app/Controllers/TicketController.php

class TicketController {
    public function list($params = []) {
        $user = Auth::user();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        if (Auth::isCustomer()) {
            // Conteggio totale
            $countStmt = DB::prepare("SELECT COUNT(*) as total FROM tickets WHERE customer_id = ?");
            $countStmt->execute([$user['id']]);
            $total = $countStmt->fetch()['total'];

            $stmt = DB::prepare("SELECT * FROM tickets WHERE customer_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
            $stmt->execute([$user['id'], $perPage, $offset]);
        } else {
            // Operator e Admin vedono tutti
            $countStmt = DB::prepare("SELECT COUNT(*) as total FROM tickets");
            $countStmt->execute();
            $total = $countStmt->fetch()['total'];

            $stmt = DB::prepare("SELECT t.*, u.name as customer_name FROM tickets t JOIN users u ON t.customer_id = u.id ORDER BY t.created_at DESC LIMIT ? OFFSET ?");
            $stmt->execute([$perPage, $offset]);
        }
        $tickets = $stmt->fetchAll();
        $totalPages = max(1, ceil($total / $perPage));

        include __DIR__ . '/../Views/tickets.php';
    }

    public function create($params = []) {
        include __DIR__ . '/../Views/ticket_form.php';
    }

    public function store($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $error = 'Token di sicurezza non valido';
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

        Auth::logAction('create', 'ticket', $ticketId);
        Auth::flash('Ticket creato con successo.', 'success');
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
        if (Auth::isOperator()) {
            $stmtOp = DB::prepare("SELECT id, name FROM users WHERE role IN ('admin','operator') AND status = 'active' ORDER BY name");
            $stmtOp->execute();
            $operators = $stmtOp->fetchAll();
        }

        include __DIR__ . '/../Views/ticket_detail.php';
    }

    public function addComment($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash('Token di sicurezza non valido.', 'danger');
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

        Auth::logAction('comment', 'ticket', $id);
        header('Location: /tickets/' . $id);
        exit;
    }

    public function updateStatus($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash('Token di sicurezza non valido.', 'danger');
            header('Location: /tickets/' . (int)$params['id']);
            exit;
        }

        $id = (int)$params['id'];
        $status = $_POST['status'] ?? '';

        // Valida status
        $validStatuses = ['open', 'in_progress', 'resolved', 'closed'];
        if (!in_array($status, $validStatuses)) {
            Auth::flash('Stato non valido.', 'danger');
            header('Location: /tickets/' . $id);
            exit;
        }

        if (Auth::isOperator()) {
            $stmt = DB::prepare("UPDATE tickets SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            Auth::logAction('update_status', 'ticket', $id);
        }

        header('Location: /tickets/' . $id);
        exit;
    }

    public function assignTicket($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash('Token di sicurezza non valido.', 'danger');
            header('Location: /tickets/' . (int)$params['id']);
            exit;
        }

        $id = (int)$params['id'];
        $assignedTo = $_POST['assigned_to'] ?? '';

        if (!Auth::isOperator()) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            return;
        }

        // Null se vuoto, altrimenti int
        $assignedTo = $assignedTo === '' ? null : (int)$assignedTo;

        $stmt = DB::prepare("UPDATE tickets SET assigned_to = ? WHERE id = ?");
        $stmt->execute([$assignedTo, $id]);

        Auth::logAction('assign', 'ticket', $id);
        Auth::flash('Ticket assegnato con successo.', 'success');
        header('Location: /tickets/' . $id);
        exit;
    }
}