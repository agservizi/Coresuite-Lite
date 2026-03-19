<?php
use Core\Auth;
use Core\DB;
use Core\Locale;
use Core\RolePermissions;

class CustomerController {
    private function authorizeBackoffice() {
        if (Auth::isCustomer() || !RolePermissions::canCurrent('customers_view')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    private function customerIndexBaseSql(array $filters): string {
        $whereSql = ' WHERE ' . implode(' AND ', $filters);

        return "
            SELECT
                u.id,
                u.name,
                u.email,
                u.phone,
                u.status,
                u.created_at,
                COUNT(DISTINCT t.id) AS tickets_total,
                SUM(CASE WHEN t.status IN ('open', 'in_progress') THEN 1 ELSE 0 END) AS tickets_open,
                COUNT(DISTINCT d.id) AS documents_total
            FROM users u
            LEFT JOIN tickets t ON t.customer_id = u.id
            LEFT JOIN documents d ON d.customer_id = u.id
            $whereSql
            GROUP BY u.id, u.name, u.email, u.phone, u.status, u.created_at
        ";
    }

    private function customerIndexOrderSql(string $sortBy, string $sortDir): string {
        $direction = $sortDir === 'asc' ? 'ASC' : 'DESC';
        $sortableColumns = [
            'name' => 'name',
            'status' => 'status',
            'tickets_total' => 'tickets_total',
            'tickets_open' => 'tickets_open',
            'documents_total' => 'documents_total',
            'created_at' => 'created_at',
        ];

        $column = $sortableColumns[$sortBy] ?? null;
        if ($column === null) {
            return ' ORDER BY tickets_open DESC, tickets_total DESC, created_at DESC';
        }

        $fallbackDirection = $sortBy === 'name' ? 'ASC' : 'DESC';
        return ' ORDER BY ' . $column . ' ' . $direction . ', name ASC, created_at ' . $fallbackDirection;
    }

    private function exportCustomersCsv(array $customers): void {
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="customers-export.csv"');

        $stream = fopen('php://output', 'w');
        if ($stream === false) {
            http_response_code(500);
            exit;
        }

        fwrite($stream, "\xEF\xBB\xBF");
        fputcsv($stream, ['ID', 'Name', 'Email', 'Phone', 'Status', 'Tickets total', 'Tickets open', 'Documents total', 'Created at']);

        foreach ($customers as $customer) {
            fputcsv($stream, [
                (int)($customer['id'] ?? 0),
                (string)($customer['name'] ?? ''),
                (string)($customer['email'] ?? ''),
                (string)($customer['phone'] ?? ''),
                (string)($customer['status'] ?? ''),
                (int)($customer['tickets_total'] ?? 0),
                (int)($customer['tickets_open'] ?? 0),
                (int)($customer['documents_total'] ?? 0),
                (string)($customer['created_at'] ?? ''),
            ]);
        }

        fclose($stream);
        exit;
    }

    public function list($params = []) {
        $this->authorizeBackoffice();

        $search = trim((string)($_GET['q'] ?? ''));
        $statusFilter = trim((string)($_GET['status'] ?? ''));
        $sortBy = trim((string)($_GET['sort'] ?? ''));
        $sortDir = strtolower(trim((string)($_GET['dir'] ?? 'desc')));
        $exportFormat = trim((string)($_GET['format'] ?? ''));
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        $filters = ["u.role = 'customer'"];
        $paramsSql = [];

        if ($search !== '') {
            $filters[] = "(u.name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?)";
            $like = '%' . $search . '%';
            $paramsSql[] = $like;
            $paramsSql[] = $like;
            $paramsSql[] = $like;
        }

        if (in_array($statusFilter, ['active', 'suspended'], true)) {
            $filters[] = "u.status = ?";
            $paramsSql[] = $statusFilter;
        }

        if (!in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'desc';
        }

        $baseSql = $this->customerIndexBaseSql($filters);
        $orderSql = $this->customerIndexOrderSql($sortBy, $sortDir);

        $countStmt = DB::prepare("SELECT COUNT(*) as total FROM (" . $baseSql . ") customer_index");
        $countStmt->execute($paramsSql);
        $total = (int)($countStmt->fetch()['total'] ?? 0);

        $summaryStmt = DB::prepare("SELECT COUNT(*) AS visible_total, SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS active_total, SUM(CASE WHEN status = 'suspended' THEN 1 ELSE 0 END) AS suspended_total, SUM(tickets_open) AS tickets_open_total, SUM(documents_total) AS documents_total FROM (" . $baseSql . ") customer_index");
        $summaryStmt->execute($paramsSql);
        $customerSummary = $summaryStmt->fetch() ?: [];

        if ($exportFormat === 'csv') {
            $exportStmt = DB::prepare("SELECT * FROM (" . $baseSql . ") customer_index" . $orderSql);
            $exportStmt->execute($paramsSql);
            $this->exportCustomersCsv($exportStmt->fetchAll());
        }

        $sql = "SELECT * FROM (" . $baseSql . ") customer_index" . $orderSql . " LIMIT ? OFFSET ?";
        $stmt = DB::prepare($sql);
        $listParams = $paramsSql;
        $listParams[] = $perPage;
        $listParams[] = $offset;
        $stmt->execute($listParams);
        $customers = $stmt->fetchAll();

        $totalPages = max(1, (int)ceil($total / $perPage));

        include __DIR__ . '/../Views/customers.php';
    }

    public function show($params = []) {
        $this->authorizeBackoffice();

        $customerLabels = [
            'it' => [
                'status' => [
                    'active' => 'Attivo',
                    'suspended' => 'Sospeso',
                    'inactive' => 'Inattivo',
                ],
                'ticket_status' => [
                    'open' => 'Aperto',
                    'in_progress' => 'In lavorazione',
                    'resolved' => 'Risolto',
                    'closed' => 'Chiuso',
                ],
                'ticket_priority' => [
                    'low' => 'Bassa',
                    'medium' => 'Media',
                    'high' => 'Alta',
                ],
                'activity' => [
                    'login' => 'Login eseguito',
                    'logout' => 'Logout eseguito',
                    'create' => 'Nuovo elemento creato',
                    'upload' => 'Documento caricato',
                    'comment' => 'Nuovo commento',
                    'update_status' => 'Stato ticket aggiornato',
                    'profile_update' => 'Profilo aggiornato',
                ],
                'entity' => [
                    'ticket' => 'ticket',
                    'document' => 'documento',
                    'user' => 'utente',
                    'customer' => 'cliente',
                ],
            ],
            'en' => [
                'status' => [
                    'active' => 'Active',
                    'suspended' => 'Suspended',
                    'inactive' => 'Inactive',
                ],
                'ticket_status' => [
                    'open' => 'Open',
                    'in_progress' => 'In progress',
                    'resolved' => 'Resolved',
                    'closed' => 'Closed',
                ],
                'ticket_priority' => [
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High',
                ],
                'activity' => [
                    'login' => 'Login completed',
                    'logout' => 'Logout completed',
                    'create' => 'New item created',
                    'upload' => 'Document uploaded',
                    'comment' => 'New comment',
                    'update_status' => 'Ticket status updated',
                    'profile_update' => 'Profile updated',
                ],
                'entity' => [
                    'ticket' => 'ticket',
                    'document' => 'document',
                    'user' => 'user',
                    'customer' => 'customer',
                ],
            ],
            'fr' => [
                'status' => [
                    'active' => 'Actif',
                    'suspended' => 'Suspendu',
                    'inactive' => 'Inactif',
                ],
                'ticket_status' => [
                    'open' => 'Ouvert',
                    'in_progress' => 'En cours',
                    'resolved' => 'Resolue',
                    'closed' => 'Ferme',
                ],
                'ticket_priority' => [
                    'low' => 'Basse',
                    'medium' => 'Moyenne',
                    'high' => 'Haute',
                ],
                'activity' => [
                    'login' => 'Connexion effectuee',
                    'logout' => 'Deconnexion effectuee',
                    'create' => 'Nouvel element cree',
                    'upload' => 'Document televerse',
                    'comment' => 'Nouveau commentaire',
                    'update_status' => 'Statut du ticket mis a jour',
                    'profile_update' => 'Profil mis a jour',
                ],
                'entity' => [
                    'ticket' => 'ticket',
                    'document' => 'document',
                    'user' => 'utilisateur',
                    'customer' => 'client',
                ],
            ],
            'es' => [
                'status' => [
                    'active' => 'Activo',
                    'suspended' => 'Suspendido',
                    'inactive' => 'Inactivo',
                ],
                'ticket_status' => [
                    'open' => 'Abierto',
                    'in_progress' => 'En progreso',
                    'resolved' => 'Resuelto',
                    'closed' => 'Cerrado',
                ],
                'ticket_priority' => [
                    'low' => 'Baja',
                    'medium' => 'Media',
                    'high' => 'Alta',
                ],
                'activity' => [
                    'login' => 'Inicio de sesion completado',
                    'logout' => 'Cierre de sesion completado',
                    'create' => 'Nuevo elemento creado',
                    'upload' => 'Documento cargado',
                    'comment' => 'Nuevo comentario',
                    'update_status' => 'Estado del ticket actualizado',
                    'profile_update' => 'Perfil actualizado',
                ],
                'entity' => [
                    'ticket' => 'ticket',
                    'document' => 'documento',
                    'user' => 'usuario',
                    'customer' => 'cliente',
                ],
            ],
        ];

        $cl = $customerLabels[Locale::current()] ?? $customerLabels['it'];

        $id = (int)($params['id'] ?? 0);

        $customerStmt = DB::prepare("SELECT id, name, email, phone, status, created_at FROM users WHERE id = ? AND role = 'customer'");
        $customerStmt->execute([$id]);
        $customer = $customerStmt->fetch();

        if (!$customer) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }

        $metricStmt = DB::prepare("
            SELECT
                COUNT(*) AS tickets_total,
                SUM(CASE WHEN status IN ('open', 'in_progress') THEN 1 ELSE 0 END) AS tickets_open,
                SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) AS tickets_resolved
            FROM tickets
            WHERE customer_id = ?
        ");
        $metricStmt->execute([$id]);
        $ticketMetrics = $metricStmt->fetch() ?: [];

        $docMetricStmt = DB::prepare("SELECT COUNT(*) AS documents_total FROM documents WHERE customer_id = ?");
        $docMetricStmt->execute([$id]);
        $documentsTotal = (int)($docMetricStmt->fetch()['documents_total'] ?? 0);

        $recentTicketsStmt = DB::prepare("
            SELECT id, subject, category, status, priority, created_at
            FROM tickets
            WHERE customer_id = ?
            ORDER BY created_at DESC
            LIMIT 6
        ");
        $recentTicketsStmt->execute([$id]);
        $recentTickets = $recentTicketsStmt->fetchAll();

        $recentDocumentsStmt = DB::prepare("
            SELECT id, filename_original, mime, size, created_at
            FROM documents
            WHERE customer_id = ?
            ORDER BY created_at DESC
            LIMIT 6
        ");
        $recentDocumentsStmt->execute([$id]);
        $recentDocuments = $recentDocumentsStmt->fetchAll();

        $activityStmt = DB::prepare("
            SELECT action, entity, entity_id, created_at
            FROM audit_logs
            WHERE
                (entity = 'ticket' AND entity_id IN (SELECT id FROM tickets WHERE customer_id = ?))
                OR (entity = 'document' AND entity_id IN (SELECT id FROM documents WHERE customer_id = ?))
                OR (entity = 'user' AND entity_id = ?)
            ORDER BY created_at DESC
            LIMIT 10
        ");
        $activityStmt->execute([$id, $id, $id]);
        $activity = $activityStmt->fetchAll();

        $customer['status_label'] = $cl['status'][(string)($customer['status'] ?? '')] ?? (string)($customer['status'] ?? '');

        foreach ($recentTickets as &$ticket) {
            $statusKey = (string)($ticket['status'] ?? '');
            $priorityKey = (string)($ticket['priority'] ?? '');
            $ticket['status_label'] = $cl['ticket_status'][$statusKey] ?? $statusKey;
            $ticket['priority_label'] = $cl['ticket_priority'][$priorityKey] ?? $priorityKey;
        }
        unset($ticket);

        foreach ($activity as &$item) {
            $actionKey = (string)($item['action'] ?? '');
            $entityKey = (string)($item['entity'] ?? '');
            $item['action_label'] = $cl['activity'][$actionKey] ?? $actionKey;
            $item['entity_label'] = $cl['entity'][$entityKey] ?? $entityKey;
        }
        unset($item);

        $ticketsTotal = (int)($ticketMetrics['tickets_total'] ?? 0);
        $ticketsOpen = (int)($ticketMetrics['tickets_open'] ?? 0);
        $ticketsResolved = (int)($ticketMetrics['tickets_resolved'] ?? 0);

        include __DIR__ . '/../Views/customer_workspace.php';
    }
}
