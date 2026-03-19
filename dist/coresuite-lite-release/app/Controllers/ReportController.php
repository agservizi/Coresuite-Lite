<?php
use Core\Auth;
use Core\DB;
use Core\Locale;
use Core\RolePermissions;

class ReportController {
    private function authorizeBackoffice() {
        if (Auth::isCustomer() || !RolePermissions::canCurrent('reports_view')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    public function index($params = []) {
        $this->authorizeBackoffice();

        $reportLabels = [
            'it' => [
                'status' => [
                    'open' => 'Aperti',
                    'in_progress' => 'In lavorazione',
                    'resolved' => 'Risolti',
                    'closed' => 'Chiusi',
                ],
                'priority' => [
                    'low' => 'Bassa',
                    'medium' => 'Media',
                    'high' => 'Alta',
                ],
                'category_fallback' => 'Non categorizzati',
                'customer_status' => [
                    'active' => 'Attivo',
                    'suspended' => 'Sospeso',
                    'inactive' => 'Inattivo',
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
                    'open' => 'Open',
                    'in_progress' => 'In progress',
                    'resolved' => 'Resolved',
                    'closed' => 'Closed',
                ],
                'priority' => [
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High',
                ],
                'category_fallback' => 'Uncategorized',
                'customer_status' => [
                    'active' => 'Active',
                    'suspended' => 'Suspended',
                    'inactive' => 'Inactive',
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
                    'open' => 'Ouverts',
                    'in_progress' => 'En cours',
                    'resolved' => 'Resolus',
                    'closed' => 'Fermes',
                ],
                'priority' => [
                    'low' => 'Basse',
                    'medium' => 'Moyenne',
                    'high' => 'Haute',
                ],
                'category_fallback' => 'Non categorises',
                'customer_status' => [
                    'active' => 'Actif',
                    'suspended' => 'Suspendu',
                    'inactive' => 'Inactif',
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
                    'open' => 'Abiertos',
                    'in_progress' => 'En progreso',
                    'resolved' => 'Resueltos',
                    'closed' => 'Cerrados',
                ],
                'priority' => [
                    'low' => 'Baja',
                    'medium' => 'Media',
                    'high' => 'Alta',
                ],
                'category_fallback' => 'Sin categoria',
                'customer_status' => [
                    'active' => 'Activo',
                    'suspended' => 'Suspendido',
                    'inactive' => 'Inactivo',
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

        $rl = $reportLabels[Locale::current()] ?? $reportLabels['it'];

        $summary = [
            'tickets_total' => 0,
            'tickets_open' => 0,
            'tickets_resolved' => 0,
            'documents_total' => 0,
            'documents_recent' => 0,
            'customers_total' => 0,
            'audit_recent' => 0,
        ];
        $ticketStatus = [];
        $ticketPriority = [];
        $ticketCategory = [];
        $topCustomers = [];
        $recentActivity = [];

        try {
            $stmt = DB::prepare("
                SELECT
                    COUNT(*) AS tickets_total,
                    SUM(CASE WHEN status IN ('open', 'in_progress') THEN 1 ELSE 0 END) AS tickets_open,
                    SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) AS tickets_resolved
                FROM tickets
            ");
            $stmt->execute();
            $summary = array_merge($summary, (array)($stmt->fetch() ?: []));

            $stmt = DB::prepare("
                SELECT
                    COUNT(*) AS documents_total,
                    SUM(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) AS documents_recent
                FROM documents
            ");
            $stmt->execute();
            $summary = array_merge($summary, (array)($stmt->fetch() ?: []));

            $stmt = DB::prepare("SELECT COUNT(*) AS customers_total FROM users WHERE role = 'customer'");
            $stmt->execute();
            $summary = array_merge($summary, (array)($stmt->fetch() ?: []));

            $stmt = DB::prepare("SELECT COUNT(*) AS audit_recent FROM audit_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
            $stmt->execute();
            $summary = array_merge($summary, (array)($stmt->fetch() ?: []));

            $stmt = DB::prepare("
                SELECT status AS label, COUNT(*) AS total
                FROM tickets
                GROUP BY status
                ORDER BY total DESC, status ASC
            ");
            $stmt->execute();
            $ticketStatus = $stmt->fetchAll();

            $stmt = DB::prepare("
                SELECT priority AS label, COUNT(*) AS total
                FROM tickets
                GROUP BY priority
                ORDER BY total DESC, priority ASC
            ");
            $stmt->execute();
            $ticketPriority = $stmt->fetchAll();

            $stmt = DB::prepare("
                SELECT COALESCE(category, :fallback) AS label, COUNT(*) AS total
                FROM tickets
                GROUP BY category
                ORDER BY total DESC, label ASC
                LIMIT 6
            ");
            $stmt->bindValue(':fallback', $rl['category_fallback']);
            $stmt->execute();
            $ticketCategory = $stmt->fetchAll();

            $stmt = DB::prepare("
                SELECT
                    u.id,
                    u.name,
                    u.status,
                    COUNT(DISTINCT t.id) AS tickets_total,
                    SUM(CASE WHEN t.status IN ('open', 'in_progress') THEN 1 ELSE 0 END) AS tickets_open,
                    COUNT(DISTINCT d.id) AS documents_total
                FROM users u
                LEFT JOIN tickets t ON t.customer_id = u.id
                LEFT JOIN documents d ON d.customer_id = u.id
                WHERE u.role = 'customer'
                GROUP BY u.id, u.name, u.status
                ORDER BY tickets_open DESC, tickets_total DESC, documents_total DESC, u.name ASC
                LIMIT 5
            ");
            $stmt->execute();
            $topCustomers = $stmt->fetchAll();

            $stmt = DB::prepare("
                SELECT action, entity, entity_id, created_at
                FROM audit_logs
                ORDER BY created_at DESC
                LIMIT 8
            ");
            $stmt->execute();
            $recentActivity = $stmt->fetchAll();

            foreach ($ticketStatus as &$row) {
                $key = (string)($row['label'] ?? '');
                $row['label'] = $rl['status'][$key] ?? $key;
            }
            unset($row);

            foreach ($ticketPriority as &$row) {
                $key = (string)($row['label'] ?? '');
                $row['label'] = $rl['priority'][$key] ?? $key;
            }
            unset($row);

            foreach ($topCustomers as &$customer) {
                $statusKey = (string)($customer['status'] ?? '');
                $customer['status_label'] = $rl['customer_status'][$statusKey] ?? $statusKey;
            }
            unset($customer);

            foreach ($recentActivity as &$item) {
                $actionKey = (string)($item['action'] ?? '');
                $entityKey = (string)($item['entity'] ?? '');
                $item['action_label'] = $rl['activity'][$actionKey] ?? $actionKey;
                $item['entity_label'] = $rl['entity'][$entityKey] ?? $entityKey;
            }
            unset($item);
        } catch (\Throwable $e) {
            $summary = array_map('intval', $summary);
            $ticketStatus = [];
            $ticketPriority = [];
            $ticketCategory = [];
            $topCustomers = [];
            $recentActivity = [];
        }

        include __DIR__ . '/../Views/reports.php';
    }
}
