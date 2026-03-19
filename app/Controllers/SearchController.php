<?php
use Core\Auth;
use Core\DB;
use Core\RolePermissions;

class SearchController {
    private function ensureProjectsSchema() {
        static $ready = false;
        if ($ready) {
            return;
        }

        DB::query("
            CREATE TABLE IF NOT EXISTS projects (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                customer_id INT UNSIGNED NULL,
                owner_id INT UNSIGNED NULL,
                name VARCHAR(180) NOT NULL,
                code VARCHAR(40) NOT NULL,
                status VARCHAR(32) NOT NULL DEFAULT 'planning',
                priority VARCHAR(24) NOT NULL DEFAULT 'medium',
                health VARCHAR(24) NOT NULL DEFAULT 'on_track',
                progress TINYINT UNSIGNED NOT NULL DEFAULT 0,
                budget DECIMAL(12,2) NULL DEFAULT NULL,
                start_date DATE NULL DEFAULT NULL,
                due_date DATE NULL DEFAULT NULL,
                description TEXT NULL,
                tags VARCHAR(255) NULL DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY uniq_projects_code (code),
                KEY idx_projects_status (status),
                KEY idx_projects_customer (customer_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        $ready = true;
    }

    public function index($params = []) {
        $query = trim((string)($_GET['q'] ?? ''));
        $scope = trim((string)($_GET['scope'] ?? 'all'));
        $searchData = $this->runSearch($query, $scope, 8, true);
        $results = $searchData['results'];
        $counts = $searchData['counts'];
        $totalCount = array_sum($counts);

        include __DIR__ . '/../Views/search.php';
    }

    public function spotlight($params = []) {
        $query = trim((string)($_GET['q'] ?? ''));
        $scope = trim((string)($_GET['scope'] ?? 'all'));

        header('Content-Type: application/json; charset=utf-8');

        if (mb_strlen($query) < 2) {
            echo json_encode([
                'query' => $query,
                'items' => [],
                'counts' => ['projects' => 0, 'tickets' => 0, 'documents' => 0, 'customers' => 0, 'sales' => 0],
                'total' => 0,
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            return;
        }

        $searchData = $this->runSearch($query, $scope, 4, false);
        $items = [];

        foreach ($searchData['results']['projects'] as $project) {
            $items[] = [
                'group' => 'Projects',
                'title' => (string)($project['name'] ?? 'Project'),
                'subtitle' => trim((string)($project['code'] ?? '') . (!empty($project['customer_name']) ? ' • ' . $project['customer_name'] : '')),
                'meta' => trim((string)($project['status'] ?? 'planning') . ' • ' . (int)($project['progress'] ?? 0) . '%'),
                'href' => '/projects/' . (int)$project['id'],
                'icon' => 'fa-diagram-project',
            ];
        }

        foreach ($searchData['results']['tickets'] as $ticket) {
            $items[] = [
                'group' => 'Tickets',
                'title' => (string)($ticket['subject'] ?? 'Ticket'),
                'subtitle' => trim((string)($ticket['category'] ?? '') . (!empty($ticket['customer_name']) ? ' • ' . $ticket['customer_name'] : '')),
                'meta' => trim((string)($ticket['status'] ?? 'open') . ' • ' . (string)($ticket['priority'] ?? 'medium')),
                'href' => '/tickets/' . (int)$ticket['id'],
                'icon' => 'fa-ticket-alt',
            ];
        }

        foreach ($searchData['results']['documents'] as $document) {
            $items[] = [
                'group' => 'Documents',
                'title' => (string)($document['filename_original'] ?? 'Documento'),
                'subtitle' => trim((string)($document['mime'] ?? '') . (!empty($document['customer_name']) ? ' • ' . $document['customer_name'] : '')),
                'meta' => round(((int)($document['size'] ?? 0)) / 1024, 1) . ' KB',
                'href' => '/documents/' . (int)$document['id'] . '/download',
                'icon' => 'fa-file-lines',
            ];
        }

        foreach ($searchData['results']['customers'] as $customer) {
            $items[] = [
                'group' => 'Customers',
                'title' => (string)($customer['name'] ?? 'Cliente'),
                'subtitle' => trim((string)($customer['email'] ?? '') . (!empty($customer['phone']) ? ' • ' . $customer['phone'] : '')),
                'meta' => (string)($customer['status'] ?? 'active'),
                'href' => '/admin/users?' . http_build_query(['q' => (string)($customer['email'] ?? $customer['name'] ?? ''), 'role' => 'customer']),
                'icon' => 'fa-users',
            ];
        }

        foreach ($searchData['results']['sales'] as $item) {
            $items[] = [
                'group' => 'Sales',
                'title' => (string)($item['title'] ?? 'Sales'),
                'subtitle' => trim((string)($item['subtitle'] ?? '')),
                'meta' => trim((string)($item['meta'] ?? '')),
                'href' => (string)($item['href'] ?? '/sales'),
                'icon' => (string)($item['icon'] ?? 'fa-briefcase'),
            ];
        }

        echo json_encode([
            'query' => $query,
            'items' => array_slice($items, 0, 8),
            'counts' => $searchData['counts'],
            'total' => array_sum($searchData['counts']),
            'view_all_url' => '/search?' . http_build_query(['q' => $query, 'scope' => $scope]),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function runSearch($query, $scope, $limit, $includeCounts) {
        $user = Auth::user();
        $scope = $this->sanitizeScope($scope);
        $results = [
            'projects' => [],
            'tickets' => [],
            'documents' => [],
            'customers' => [],
            'sales' => [],
        ];
        $counts = [
            'projects' => 0,
            'tickets' => 0,
            'documents' => 0,
            'customers' => 0,
            'sales' => 0,
        ];

        if ($query === '') {
            return ['results' => $results, 'counts' => $counts, 'scope' => $scope];
        }

        $like = '%' . $query . '%';

        if (RolePermissions::canCurrent('projects_view') && ($scope === 'all' || $scope === 'projects')) {
            $this->ensureProjectsSchema();
            if (Auth::isCustomer()) {
                if ($includeCounts) {
                    $projectCountStmt = DB::prepare("SELECT COUNT(*) as total FROM projects WHERE customer_id = ? AND (name LIKE ? OR code LIKE ? OR COALESCE(tags, '') LIKE ?)");
                    $projectCountStmt->execute([$user['id'], $like, $like, $like]);
                    $counts['projects'] = (int)($projectCountStmt->fetch()['total'] ?? 0);
                }

                $projectStmt = DB::prepare("SELECT id, name, code, status, progress, updated_at FROM projects WHERE customer_id = ? AND (name LIKE ? OR code LIKE ? OR COALESCE(tags, '') LIKE ?) ORDER BY updated_at DESC LIMIT ?");
                $projectStmt->execute([$user['id'], $like, $like, $like, $limit]);
            } else {
                if ($includeCounts) {
                    $projectCountStmt = DB::prepare("SELECT COUNT(*) as total FROM projects p LEFT JOIN users u ON p.customer_id = u.id WHERE p.name LIKE ? OR p.code LIKE ? OR COALESCE(p.tags, '') LIKE ? OR COALESCE(u.name, '') LIKE ?");
                    $projectCountStmt->execute([$like, $like, $like, $like]);
                    $counts['projects'] = (int)($projectCountStmt->fetch()['total'] ?? 0);
                }

                $projectStmt = DB::prepare("SELECT p.id, p.name, p.code, p.status, p.progress, p.updated_at, u.name as customer_name FROM projects p LEFT JOIN users u ON p.customer_id = u.id WHERE p.name LIKE ? OR p.code LIKE ? OR COALESCE(p.tags, '') LIKE ? OR COALESCE(u.name, '') LIKE ? ORDER BY p.updated_at DESC LIMIT ?");
                $projectStmt->execute([$like, $like, $like, $like, $limit]);
            }

            $results['projects'] = $projectStmt->fetchAll();
            if (!$includeCounts) {
                $counts['projects'] = count($results['projects']);
            }
        }

        if ($scope === 'all' || $scope === 'tickets') {
            if (Auth::isCustomer()) {
                if ($includeCounts) {
                    $ticketCountStmt = DB::prepare("SELECT COUNT(*) as total FROM tickets WHERE customer_id = ? AND (subject LIKE ? OR category LIKE ?)");
                    $ticketCountStmt->execute([$user['id'], $like, $like]);
                    $counts['tickets'] = (int)($ticketCountStmt->fetch()['total'] ?? 0);
                }

                $ticketStmt = DB::prepare("SELECT id, subject, category, status, priority, created_at FROM tickets WHERE customer_id = ? AND (subject LIKE ? OR category LIKE ?) ORDER BY created_at DESC LIMIT ?");
                $ticketStmt->execute([$user['id'], $like, $like, $limit]);
            } else {
                if ($includeCounts) {
                    $ticketCountStmt = DB::prepare("SELECT COUNT(*) as total FROM tickets t JOIN users u ON t.customer_id = u.id WHERE t.subject LIKE ? OR t.category LIKE ? OR u.name LIKE ?");
                    $ticketCountStmt->execute([$like, $like, $like]);
                    $counts['tickets'] = (int)($ticketCountStmt->fetch()['total'] ?? 0);
                }

                $ticketStmt = DB::prepare("SELECT t.id, t.subject, t.category, t.status, t.priority, t.created_at, u.name as customer_name FROM tickets t JOIN users u ON t.customer_id = u.id WHERE t.subject LIKE ? OR t.category LIKE ? OR u.name LIKE ? ORDER BY t.created_at DESC LIMIT ?");
                $ticketStmt->execute([$like, $like, $like, $limit]);
            }

            $results['tickets'] = $ticketStmt->fetchAll();
            if (!$includeCounts) {
                $counts['tickets'] = count($results['tickets']);
            }
        }

        if ($scope === 'all' || $scope === 'documents') {
            if (Auth::isCustomer()) {
                if ($includeCounts) {
                    $documentCountStmt = DB::prepare("SELECT COUNT(*) as total FROM documents WHERE customer_id = ? AND (filename_original LIKE ? OR mime LIKE ?)");
                    $documentCountStmt->execute([$user['id'], $like, $like]);
                    $counts['documents'] = (int)($documentCountStmt->fetch()['total'] ?? 0);
                }

                $documentStmt = DB::prepare("SELECT id, filename_original, mime, size, created_at FROM documents WHERE customer_id = ? AND (filename_original LIKE ? OR mime LIKE ?) ORDER BY created_at DESC LIMIT ?");
                $documentStmt->execute([$user['id'], $like, $like, $limit]);
            } else {
                if ($includeCounts) {
                    $documentCountStmt = DB::prepare("SELECT COUNT(*) as total FROM documents d JOIN users u ON d.customer_id = u.id WHERE d.filename_original LIKE ? OR d.mime LIKE ? OR u.name LIKE ?");
                    $documentCountStmt->execute([$like, $like, $like]);
                    $counts['documents'] = (int)($documentCountStmt->fetch()['total'] ?? 0);
                }

                $documentStmt = DB::prepare("SELECT d.id, d.filename_original, d.mime, d.size, d.created_at, u.name as customer_name FROM documents d JOIN users u ON d.customer_id = u.id WHERE d.filename_original LIKE ? OR d.mime LIKE ? OR u.name LIKE ? ORDER BY d.created_at DESC LIMIT ?");
                $documentStmt->execute([$like, $like, $like, $limit]);
            }

            $results['documents'] = $documentStmt->fetchAll();
            if (!$includeCounts) {
                $counts['documents'] = count($results['documents']);
            }
        }

        if ((Auth::isAdmin() || Auth::isOperator()) && RolePermissions::canCurrent('customers_view') && ($scope === 'all' || $scope === 'customers')) {
            if ($includeCounts) {
                $customerCountStmt = DB::prepare("SELECT COUNT(*) as total FROM users WHERE role = 'customer' AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)");
                $customerCountStmt->execute([$like, $like, $like]);
                $counts['customers'] = (int)($customerCountStmt->fetch()['total'] ?? 0);
            }

            $customerStmt = DB::prepare("SELECT id, name, email, phone, status, created_at FROM users WHERE role = 'customer' AND (name LIKE ? OR email LIKE ? OR phone LIKE ?) ORDER BY created_at DESC LIMIT ?");
            $customerStmt->execute([$like, $like, $like, $limit]);
            $results['customers'] = $customerStmt->fetchAll();

            if (!$includeCounts) {
                $counts['customers'] = count($results['customers']);
            }
        }

        if (!Auth::isCustomer() && RolePermissions::canCurrent('sales_view') && ($scope === 'all' || $scope === 'sales')) {
            try {
                $salesWhere = "co.name LIKE ? OR co.email LIKE ? OR co.industry LIKE ? OR ct.name LIKE ? OR ct.email LIKE ? OR l.title LIKE ? OR d.title LIKE ? OR q.quote_number LIKE ? OR i.invoice_number LIKE ?";

                if ($includeCounts) {
                    $salesCountStmt = DB::prepare("SELECT COUNT(DISTINCT CONCAT(src, '-', entity_id)) AS total
                    FROM (
                        SELECT 'company' AS src, co.id AS entity_id, co.name, co.email, co.industry, NULL AS contact_name, NULL AS contact_email, NULL AS lead_title, NULL AS deal_title, NULL AS quote_number, NULL AS invoice_number
                        FROM crm_companies co
                        UNION ALL
                        SELECT 'contact' AS src, ct.id AS entity_id, co.name, co.email, co.industry, ct.name AS contact_name, ct.email AS contact_email, NULL, NULL, NULL, NULL
                        FROM crm_contacts ct
                        LEFT JOIN crm_companies co ON co.id = ct.company_id
                        UNION ALL
                        SELECT 'lead' AS src, l.id AS entity_id, co.name, co.email, co.industry, ct.name, ct.email, l.title AS lead_title, NULL, NULL, NULL
                        FROM crm_leads l
                        LEFT JOIN crm_companies co ON co.id = l.company_id
                        LEFT JOIN crm_contacts ct ON ct.id = l.contact_id
                        UNION ALL
                        SELECT 'deal' AS src, d.id AS entity_id, co.name, co.email, co.industry, ct.name, ct.email, NULL, d.title AS deal_title, NULL, NULL
                        FROM crm_deals d
                        LEFT JOIN crm_companies co ON co.id = d.company_id
                        LEFT JOIN crm_contacts ct ON ct.id = d.contact_id
                        UNION ALL
                        SELECT 'quote' AS src, q.id AS entity_id, co.name, co.email, co.industry, NULL, NULL, NULL, d.title, q.quote_number, NULL
                        FROM crm_quotes q
                        LEFT JOIN crm_companies co ON co.id = q.company_id
                        LEFT JOIN crm_deals d ON d.id = q.deal_id
                        UNION ALL
                        SELECT 'invoice' AS src, i.id AS entity_id, co.name, co.email, co.industry, NULL, NULL, NULL, d.title, NULL, i.invoice_number
                        FROM crm_invoices i
                        LEFT JOIN crm_companies co ON co.id = i.company_id
                        LEFT JOIN crm_deals d ON d.id = i.deal_id
                    ) sales_index
                    WHERE {$salesWhere}");
                    $salesCountStmt->execute([$like, $like, $like, $like, $like, $like, $like, $like, $like]);
                    $counts['sales'] = (int)($salesCountStmt->fetch()['total'] ?? 0);
                }

                $salesStmt = DB::prepare("SELECT * FROM (
                    SELECT 'company' AS entity_type, co.id, co.name AS title, CONCAT(COALESCE(co.industry, ''), CASE WHEN co.email IS NOT NULL AND co.email <> '' THEN CONCAT(' • ', co.email) ELSE '' END) AS subtitle, co.status AS meta, '/sales' AS href, 'fa-building' AS icon, co.created_at AS sort_at
                    FROM crm_companies co
                    UNION ALL
                    SELECT 'contact' AS entity_type, ct.id, ct.name AS title, CONCAT(COALESCE(co.name, ''), CASE WHEN ct.email IS NOT NULL AND ct.email <> '' THEN CONCAT(' • ', ct.email) ELSE '' END) AS subtitle, COALESCE(ct.role_title, 'contact') AS meta, '/sales' AS href, 'fa-address-card' AS icon, ct.created_at AS sort_at
                    FROM crm_contacts ct
                    LEFT JOIN crm_companies co ON co.id = ct.company_id
                    UNION ALL
                    SELECT 'lead' AS entity_type, l.id, l.title AS title, CONCAT(COALESCE(co.name, ''), CASE WHEN ct.name IS NOT NULL AND ct.name <> '' THEN CONCAT(' • ', ct.name) ELSE '' END) AS subtitle, l.status AS meta, '/sales' AS href, 'fa-bullseye' AS icon, l.created_at AS sort_at
                    FROM crm_leads l
                    LEFT JOIN crm_companies co ON co.id = l.company_id
                    LEFT JOIN crm_contacts ct ON ct.id = l.contact_id
                    UNION ALL
                    SELECT 'deal' AS entity_type, d.id, d.title AS title, CONCAT(COALESCE(co.name, ''), CASE WHEN d.amount IS NOT NULL THEN CONCAT(' • ', FORMAT(d.amount, 2), ' ', d.currency) ELSE '' END) AS subtitle, d.stage AS meta, '/sales/pipeline' AS href, 'fa-briefcase' AS icon, d.created_at AS sort_at
                    FROM crm_deals d
                    LEFT JOIN crm_companies co ON co.id = d.company_id
                    UNION ALL
                    SELECT 'quote' AS entity_type, q.id, q.quote_number AS title, CONCAT(COALESCE(co.name, ''), CASE WHEN d.title IS NOT NULL AND d.title <> '' THEN CONCAT(' • ', d.title) ELSE '' END) AS subtitle, q.status AS meta, '/sales' AS href, 'fa-file-signature' AS icon, q.created_at AS sort_at
                    FROM crm_quotes q
                    LEFT JOIN crm_companies co ON co.id = q.company_id
                    LEFT JOIN crm_deals d ON d.id = q.deal_id
                    UNION ALL
                    SELECT 'invoice' AS entity_type, i.id, i.invoice_number AS title, CONCAT(COALESCE(co.name, ''), CASE WHEN d.title IS NOT NULL AND d.title <> '' THEN CONCAT(' • ', d.title) ELSE '' END) AS subtitle, i.status AS meta, '/sales' AS href, 'fa-file-invoice-dollar' AS icon, i.created_at AS sort_at
                    FROM crm_invoices i
                    LEFT JOIN crm_companies co ON co.id = i.company_id
                    LEFT JOIN crm_deals d ON d.id = i.deal_id
                ) sales_results
                    WHERE title LIKE ? OR subtitle LIKE ? OR meta LIKE ?
                    ORDER BY sort_at DESC
                    LIMIT ?");
                $salesStmt->execute([$like, $like, $like, $limit]);
                $results['sales'] = $salesStmt->fetchAll();

                if (!$includeCounts) {
                    $counts['sales'] = count($results['sales']);
                }
            } catch (\Throwable $e) {
                $results['sales'] = [];
                $counts['sales'] = 0;
            }
        }

        return ['results' => $results, 'counts' => $counts, 'scope' => $scope];
    }

    private function sanitizeScope($scope) {
        $availableScopes = ['all', 'tickets', 'documents'];
        if (RolePermissions::canCurrent('projects_view')) {
            $availableScopes[] = 'projects';
        }
        if ((Auth::isAdmin() || Auth::isOperator()) && RolePermissions::canCurrent('customers_view')) {
            $availableScopes[] = 'customers';
        }
        if (!Auth::isCustomer() && RolePermissions::canCurrent('sales_view')) {
            $availableScopes[] = 'sales';
        }

        return in_array($scope, $availableScopes, true) ? $scope : 'all';
    }
}
