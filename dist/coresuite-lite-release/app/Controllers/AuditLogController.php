<?php
use Core\Auth;
use Core\DB;
use Core\Locale;
use Core\RolePermissions;

class AuditLogController {
    private function authorizeBackoffice() {
        if (Auth::isCustomer() || !RolePermissions::canCurrent('audit_logs_view')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    public function index($params = []) {
        $this->authorizeBackoffice();

        $auditLabels = [
            'it' => [
                'action' => [
                    'create' => 'Creazione',
                    'update' => 'Aggiornamento',
                    'delete' => 'Eliminazione',
                    'login' => 'Login',
                    'logout' => 'Logout',
                    'upload' => 'Upload',
                    'comment' => 'Commento',
                    'update_status' => 'Aggiornamento stato',
                    'profile_update' => 'Aggiornamento profilo',
                ],
                'entity' => [
                    'user' => 'Utente',
                    'ticket' => 'Ticket',
                    'document' => 'Documento',
                    'customer' => 'Cliente',
                ],
            ],
            'en' => [
                'action' => [
                    'create' => 'Create',
                    'update' => 'Update',
                    'delete' => 'Delete',
                    'login' => 'Login',
                    'logout' => 'Logout',
                    'upload' => 'Upload',
                    'comment' => 'Comment',
                    'update_status' => 'Status update',
                    'profile_update' => 'Profile update',
                ],
                'entity' => [
                    'user' => 'User',
                    'ticket' => 'Ticket',
                    'document' => 'Document',
                    'customer' => 'Customer',
                ],
            ],
            'fr' => [
                'action' => [
                    'create' => 'Creation',
                    'update' => 'Mise a jour',
                    'delete' => 'Suppression',
                    'login' => 'Connexion',
                    'logout' => 'Deconnexion',
                    'upload' => 'Televersement',
                    'comment' => 'Commentaire',
                    'update_status' => 'Mise a jour du statut',
                    'profile_update' => 'Mise a jour du profil',
                ],
                'entity' => [
                    'user' => 'Utilisateur',
                    'ticket' => 'Ticket',
                    'document' => 'Document',
                    'customer' => 'Client',
                ],
            ],
            'es' => [
                'action' => [
                    'create' => 'Creacion',
                    'update' => 'Actualizacion',
                    'delete' => 'Eliminacion',
                    'login' => 'Inicio de sesion',
                    'logout' => 'Cierre de sesion',
                    'upload' => 'Carga',
                    'comment' => 'Comentario',
                    'update_status' => 'Actualizacion de estado',
                    'profile_update' => 'Actualizacion de perfil',
                ],
                'entity' => [
                    'user' => 'Usuario',
                    'ticket' => 'Ticket',
                    'document' => 'Documento',
                    'customer' => 'Cliente',
                ],
            ],
        ];

        $al = $auditLabels[Locale::current()] ?? $auditLabels['it'];

        $search = trim((string)($_GET['q'] ?? ''));
        $actionFilter = trim((string)($_GET['action'] ?? ''));
        $entityFilter = trim((string)($_GET['entity'] ?? ''));
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $allowedActions = ['create', 'update', 'delete', 'login', 'logout'];
        $allowedEntities = ['user', 'ticket', 'document'];
        $filters = [];
        $paramsSql = [];

        if ($search !== '') {
            $filters[] = "(a.action LIKE ? OR a.entity LIKE ? OR CAST(a.entity_id AS CHAR) LIKE ? OR u.name LIKE ? OR u.email LIKE ? OR a.ip LIKE ?)";
            $like = '%' . $search . '%';
            $paramsSql[] = $like;
            $paramsSql[] = $like;
            $paramsSql[] = $like;
            $paramsSql[] = $like;
            $paramsSql[] = $like;
            $paramsSql[] = $like;
        }

        if (in_array($actionFilter, $allowedActions, true)) {
            $filters[] = 'a.action = ?';
            $paramsSql[] = $actionFilter;
        } else {
            $actionFilter = '';
        }

        if (in_array($entityFilter, $allowedEntities, true)) {
            $filters[] = 'a.entity = ?';
            $paramsSql[] = $entityFilter;
        } else {
            $entityFilter = '';
        }

        $whereSql = $filters ? (' WHERE ' . implode(' AND ', $filters)) : '';

        $countStmt = DB::prepare("SELECT COUNT(*) AS total FROM audit_logs a LEFT JOIN users u ON u.id = a.actor_id" . $whereSql);
        $countStmt->execute($paramsSql);
        $total = (int)($countStmt->fetch()['total'] ?? 0);

        $summaryStmt = DB::prepare("
            SELECT
                COUNT(*) AS total_events,
                SUM(CASE WHEN a.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS recent_events,
                COUNT(DISTINCT a.actor_id) AS active_actors
            FROM audit_logs a
            LEFT JOIN users u ON u.id = a.actor_id
            $whereSql
        ");
        $summaryStmt->execute($paramsSql);
        $summary = (array)($summaryStmt->fetch() ?: []);

        $actionMixStmt = DB::prepare("
            SELECT a.action, COUNT(*) AS total
            FROM audit_logs a
            LEFT JOIN users u ON u.id = a.actor_id
            $whereSql
            GROUP BY a.action
            ORDER BY total DESC, a.action ASC
            LIMIT 4
        ");
        $actionMixStmt->execute($paramsSql);
        $actionMix = $actionMixStmt->fetchAll();

        $entityMixStmt = DB::prepare("
            SELECT a.entity, COUNT(*) AS total
            FROM audit_logs a
            LEFT JOIN users u ON u.id = a.actor_id
            $whereSql
            GROUP BY a.entity
            ORDER BY total DESC, a.entity ASC
            LIMIT 4
        ");
        $entityMixStmt->execute($paramsSql);
        $entityMix = $entityMixStmt->fetchAll();

        $listStmt = DB::prepare("
            SELECT
                a.id,
                a.actor_id,
                a.action,
                a.entity,
                a.entity_id,
                a.ip,
                a.user_agent,
                a.created_at,
                u.name AS actor_name,
                u.email AS actor_email
            FROM audit_logs a
            LEFT JOIN users u ON u.id = a.actor_id
            $whereSql
            ORDER BY a.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $listParams = $paramsSql;
        $listParams[] = $perPage;
        $listParams[] = $offset;
        $listStmt->execute($listParams);
        $logs = $listStmt->fetchAll();

        foreach ($actionMix as &$item) {
            $key = (string)($item['action'] ?? '');
            $item['action_label'] = $al['action'][$key] ?? $key;
        }
        unset($item);

        foreach ($entityMix as &$item) {
            $key = (string)($item['entity'] ?? '');
            $item['entity_label'] = $al['entity'][$key] ?? $key;
        }
        unset($item);

        foreach ($logs as &$log) {
            $actionKey = (string)($log['action'] ?? '');
            $entityKey = (string)($log['entity'] ?? '');
            $log['action_label'] = $al['action'][$actionKey] ?? $actionKey;
            $log['entity_label'] = $al['entity'][$entityKey] ?? $entityKey;
        }
        unset($log);

        $totalPages = max(1, (int)ceil($total / $perPage));

        include __DIR__ . '/../Views/audit_logs.php';
    }
}
