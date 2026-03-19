<?php
use Core\Auth;
use Core\DB;
use Core\Locale;
use Core\RolePermissions;

class ProjectController {
    private function ensureSchema(): void {
        static $booted = false;
        if ($booted) {
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
                KEY idx_projects_priority (priority),
                KEY idx_projects_customer (customer_id),
                KEY idx_projects_owner (owner_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query("
            CREATE TABLE IF NOT EXISTS project_milestones (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                project_id INT UNSIGNED NOT NULL,
                title VARCHAR(180) NOT NULL,
                status VARCHAR(24) NOT NULL DEFAULT 'planned',
                due_date DATE NULL DEFAULT NULL,
                sort_order INT UNSIGNED NOT NULL DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY idx_project_milestones_project (project_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        DB::query("
            CREATE TABLE IF NOT EXISTS project_tasks (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                project_id INT UNSIGNED NOT NULL,
                milestone_id INT UNSIGNED NULL DEFAULT NULL,
                title VARCHAR(180) NOT NULL,
                status VARCHAR(24) NOT NULL DEFAULT 'todo',
                priority VARCHAR(24) NOT NULL DEFAULT 'medium',
                assignee_id INT UNSIGNED NULL DEFAULT NULL,
                due_date DATE NULL DEFAULT NULL,
                sort_order INT UNSIGNED NOT NULL DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                KEY idx_project_tasks_project (project_id),
                KEY idx_project_tasks_milestone (milestone_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        $booted = true;
    }

    private function ensureDemoProjects(): void {
        static $seeded = false;
        if ($seeded) {
            return;
        }

        $countRow = DB::query("SELECT COUNT(*) as total FROM projects")->fetch();
        if ((int)($countRow['total'] ?? 0) > 0) {
            $seeded = true;
            return;
        }

        $usersStmt = DB::query("SELECT id, email FROM users WHERE email IN ('admin@example.com', 'operator@example.com', 'customer@example.com')");
        $userMap = [];
        foreach ($usersStmt->fetchAll() as $user) {
            $userMap[(string)$user['email']] = (int)$user['id'];
        }

        $customerId = $userMap['customer@example.com'] ?? null;
        $adminId = $userMap['admin@example.com'] ?? null;
        $operatorId = $userMap['operator@example.com'] ?? null;
        if (!$customerId || !$adminId) {
            $seeded = true;
            return;
        }

        $projectStmt = DB::prepare("
            INSERT INTO projects (customer_id, owner_id, name, code, status, priority, health, progress, budget, start_date, due_date, description, tags)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $demoProjects = [
            [$customerId, $adminId, 'Workspace Migration Retail', 'PRJ-2401', 'active', 'high', 'on_track', 68, 24000, '2026-03-01', '2026-04-15', 'Migrazione del workspace cliente con focus su documenti, permessi e adoption operativa.', 'migration, retail, workspace'],
            [$customerId, $operatorId ?: $adminId, 'Customer Portal Refresh', 'PRJ-2402', 'review', 'medium', 'watch', 84, 12000, '2026-02-20', '2026-03-28', 'Rifinitura customer-facing con allineamento UX, contenuti e flussi di supporto.', 'portal, ux, customer'],
            [$customerId, $adminId, 'Compliance Archive Rollout', 'PRJ-2403', 'planning', 'high', 'at_risk', 22, 18000, '2026-03-18', '2026-05-05', 'Setup archivio documentale con policy, tassonomie e controllo accessi per audit.', 'archive, compliance, audit'],
        ];

        $projectIds = [];
        foreach ($demoProjects as $projectRow) {
            $projectStmt->execute($projectRow);
            $projectIds[$projectRow[3]] = (int)DB::lastInsertId();
        }

        $milestoneStmt = DB::prepare("
            INSERT INTO project_milestones (project_id, title, status, due_date, sort_order)
            VALUES (?, ?, ?, ?, ?)
        ");
        $taskStmt = DB::prepare("
            INSERT INTO project_tasks (project_id, milestone_id, title, status, priority, assignee_id, due_date, sort_order)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $milestoneMap = [];
        $demoMilestones = [
            ['PRJ-2401', 'Scoperta e mapping processi', 'done', '2026-03-08', 1],
            ['PRJ-2401', 'Migrazione documentale', 'active', '2026-03-24', 2],
            ['PRJ-2401', 'Go-live assistito', 'planned', '2026-04-12', 3],
            ['PRJ-2402', 'UI polish e handoff', 'active', '2026-03-22', 1],
            ['PRJ-2402', 'QA customer journey', 'planned', '2026-03-26', 2],
            ['PRJ-2403', 'Definizione tassonomie', 'planned', '2026-03-29', 1],
            ['PRJ-2403', 'Policy accessi e audit', 'planned', '2026-04-08', 2],
        ];

        foreach ($demoMilestones as $row) {
            $projectCode = $row[0];
            if (empty($projectIds[$projectCode])) {
                continue;
            }
            $milestoneStmt->execute([$projectIds[$projectCode], $row[1], $row[2], $row[3], $row[4]]);
            $milestoneMap[$projectCode][$row[1]] = (int)DB::lastInsertId();
        }

        $demoTasks = [
            ['PRJ-2401', 'Scoperta e mapping processi', 'Pulire naming storico documenti', 'done', 'medium', $adminId, '2026-03-06', 1],
            ['PRJ-2401', 'Migrazione documentale', 'Validare permessi per area finance', 'doing', 'high', $operatorId ?: $adminId, '2026-03-21', 2],
            ['PRJ-2401', 'Go-live assistito', 'Preparare checklist onboarding operatori', 'todo', 'medium', $adminId, '2026-04-10', 3],
            ['PRJ-2402', 'UI polish e handoff', 'Aggiornare componenti auth', 'doing', 'high', $operatorId ?: $adminId, '2026-03-20', 1],
            ['PRJ-2402', 'QA customer journey', 'Eseguire regressione su search e inbox', 'todo', 'medium', $adminId, '2026-03-25', 2],
            ['PRJ-2403', 'Definizione tassonomie', 'Confermare categorie compliance', 'todo', 'high', $adminId, '2026-03-27', 1],
            ['PRJ-2403', 'Policy accessi e audit', 'Mappare ruoli e retention log', 'todo', 'high', $operatorId ?: $adminId, '2026-04-03', 2],
        ];

        foreach ($demoTasks as $row) {
            $projectCode = $row[0];
            $milestoneTitle = $row[1];
            if (empty($projectIds[$projectCode])) {
                continue;
            }
            $taskStmt->execute([
                $projectIds[$projectCode],
                $milestoneMap[$projectCode][$milestoneTitle] ?? null,
                $row[2],
                $row[3],
                $row[4],
                $row[5],
                $row[6],
                $row[7],
            ]);
        }

        $seeded = true;
    }

    private function authorizeView(): void {
        if (!RolePermissions::canCurrent('projects_view')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    private function authorizeManage(): void {
        if (!RolePermissions::canCurrent('projects_manage')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    private function dictionaries(): array {
        return [
            'status' => [
                'planning' => ['it' => 'Pianificazione', 'en' => 'Planning', 'fr' => 'Planification', 'es' => 'Planificacion'],
                'active' => ['it' => 'Attivo', 'en' => 'Active', 'fr' => 'Actif', 'es' => 'Activo'],
                'review' => ['it' => 'Revisione', 'en' => 'Review', 'fr' => 'Revision', 'es' => 'Revision'],
                'completed' => ['it' => 'Completato', 'en' => 'Completed', 'fr' => 'Termine', 'es' => 'Completado'],
                'blocked' => ['it' => 'Bloccato', 'en' => 'Blocked', 'fr' => 'Bloque', 'es' => 'Bloqueado'],
            ],
            'priority' => [
                'low' => ['it' => 'Bassa', 'en' => 'Low', 'fr' => 'Basse', 'es' => 'Baja'],
                'medium' => ['it' => 'Media', 'en' => 'Medium', 'fr' => 'Moyenne', 'es' => 'Media'],
                'high' => ['it' => 'Alta', 'en' => 'High', 'fr' => 'Haute', 'es' => 'Alta'],
            ],
            'health' => [
                'on_track' => ['it' => 'In linea', 'en' => 'On track', 'fr' => 'En ligne', 'es' => 'En linea'],
                'watch' => ['it' => 'Da monitorare', 'en' => 'Watch', 'fr' => 'A surveiller', 'es' => 'En observacion'],
                'at_risk' => ['it' => 'A rischio', 'en' => 'At risk', 'fr' => 'A risque', 'es' => 'En riesgo'],
            ],
            'milestone_status' => [
                'planned' => ['it' => 'Pianificata', 'en' => 'Planned', 'fr' => 'Planifiee', 'es' => 'Planificada'],
                'active' => ['it' => 'In corso', 'en' => 'Active', 'fr' => 'Active', 'es' => 'Activa'],
                'done' => ['it' => 'Chiusa', 'en' => 'Done', 'fr' => 'Cloturee', 'es' => 'Cerrada'],
            ],
            'task_status' => [
                'todo' => ['it' => 'Da fare', 'en' => 'To do', 'fr' => 'A faire', 'es' => 'Por hacer'],
                'doing' => ['it' => 'In corso', 'en' => 'Doing', 'fr' => 'En cours', 'es' => 'En curso'],
                'done' => ['it' => 'Fatto', 'en' => 'Done', 'fr' => 'Fait', 'es' => 'Hecho'],
            ],
        ];
    }

    private function labelFor(string $group, string $key): string {
        $dict = $this->dictionaries();
        $locale = Locale::current();
        return $dict[$group][$key][$locale] ?? $dict[$group][$key]['it'] ?? $key;
    }

    private function canAccessProject(array $project): bool {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        if (Auth::isCustomer()) {
            return (int)($project['customer_id'] ?? 0) === (int)$user['id'];
        }

        return true;
    }

    private function loadCustomers(): array {
        if (Auth::isCustomer()) {
            return [];
        }

        $stmt = DB::prepare("SELECT id, name FROM users WHERE role = 'customer' ORDER BY name");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function loadAssignableUsers(): array {
        if (Auth::isCustomer()) {
            return [];
        }

        $stmt = DB::prepare("SELECT id, name, role FROM users WHERE role IN ('admin', 'operator') AND status = 'active' ORDER BY FIELD(role, 'admin', 'operator'), name");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function findProject(int $id): ?array {
        $stmt = DB::prepare("
            SELECT p.*, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, o.name as owner_name
            FROM projects p
            LEFT JOIN users c ON p.customer_id = c.id
            LEFT JOIN users o ON p.owner_id = o.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    private function touchProjectHealth(int $projectId): void {
        $projectStmt = DB::prepare("SELECT progress, due_date FROM projects WHERE id = ?");
        $projectStmt->execute([$projectId]);
        $project = $projectStmt->fetch() ?: [];

        $taskStmt = DB::prepare("
            SELECT
                COUNT(*) as total,
                SUM(CASE WHEN status = 'done' THEN 1 ELSE 0 END) as done_total,
                SUM(CASE WHEN due_date IS NOT NULL AND due_date < CURDATE() AND status != 'done' THEN 1 ELSE 0 END) as overdue_total
            FROM project_tasks
            WHERE project_id = ?
        ");
        $taskStmt->execute([$projectId]);
        $taskStats = $taskStmt->fetch() ?: [];

        $total = (int)($taskStats['total'] ?? 0);
        $done = (int)($taskStats['done_total'] ?? 0);
        $overdue = (int)($taskStats['overdue_total'] ?? 0);
        $progress = $total > 0 ? (int)round(($done / $total) * 100) : (int)($project['progress'] ?? 0);
        $health = 'on_track';

        if ($overdue > 0) {
            $health = 'at_risk';
        } elseif ($progress < 40 || (!empty($project['due_date']) && strtotime((string)$project['due_date']) <= strtotime('+10 days'))) {
            $health = 'watch';
        }

        $updateStmt = DB::prepare("UPDATE projects SET progress = ?, health = ? WHERE id = ?");
        $updateStmt->execute([$progress, $health, $projectId]);
    }

    public function list($params = []): void {
        $this->ensureSchema();
        $this->ensureDemoProjects();
        $this->authorizeView();

        $user = Auth::user();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        $search = trim((string)($_GET['q'] ?? ''));
        $statusFilter = trim((string)($_GET['status'] ?? ''));
        $priorityFilter = trim((string)($_GET['priority'] ?? ''));
        $healthFilter = trim((string)($_GET['health'] ?? ''));
        $customerFilter = max(0, (int)($_GET['customer'] ?? 0));
        $sortBy = trim((string)($_GET['sort'] ?? ''));
        $sortDir = strtolower(trim((string)($_GET['dir'] ?? 'desc')));
        $validStatuses = array_keys($this->dictionaries()['status']);
        $validPriorities = array_keys($this->dictionaries()['priority']);
        $validHealth = array_keys($this->dictionaries()['health']);
        $validSorts = ['due_date', 'progress', 'health'];

        if (!in_array($sortBy, $validSorts, true)) {
            $sortBy = '';
        }

        $sortDir = $sortDir === 'asc' ? 'asc' : 'desc';

        $baseFrom = " FROM projects p LEFT JOIN users c ON p.customer_id = c.id LEFT JOIN users o ON p.owner_id = o.id WHERE 1=1";
        $paramsSql = [];
        $filters = [];

        if (Auth::isCustomer()) {
            $filters[] = "p.customer_id = ?";
            $paramsSql[] = (int)$user['id'];
        }
        if ($search !== '') {
            $filters[] = "(p.name LIKE ? OR p.code LIKE ? OR COALESCE(c.name, '') LIKE ?)";
            $like = '%' . $search . '%';
            $paramsSql[] = $like;
            $paramsSql[] = $like;
            $paramsSql[] = $like;
        }
        if (in_array($statusFilter, $validStatuses, true)) {
            $filters[] = "p.status = ?";
            $paramsSql[] = $statusFilter;
        }
        if (in_array($priorityFilter, $validPriorities, true)) {
            $filters[] = "p.priority = ?";
            $paramsSql[] = $priorityFilter;
        }
        if (in_array($healthFilter, $validHealth, true)) {
            $filters[] = "p.health = ?";
            $paramsSql[] = $healthFilter;
        }
        if (!Auth::isCustomer() && $customerFilter > 0) {
            $filters[] = "p.customer_id = ?";
            $paramsSql[] = $customerFilter;
        }

        $filterSql = $filters ? ' AND ' . implode(' AND ', $filters) : '';

        $countStmt = DB::prepare("SELECT COUNT(*) as total" . $baseFrom . $filterSql);
        $countStmt->execute($paramsSql);
        $total = (int)($countStmt->fetch()['total'] ?? 0);

        $orderSql = "
            ORDER BY
                CASE p.status
                    WHEN 'blocked' THEN 1
                    WHEN 'active' THEN 2
                    WHEN 'planning' THEN 3
                    WHEN 'review' THEN 4
                    ELSE 5
                END,
                p.updated_at DESC
        ";

        if ($sortBy === 'due_date') {
            $orderSql = "
                ORDER BY
                    p.due_date IS NULL ASC,
                    p.due_date " . strtoupper($sortDir) . ",
                    p.updated_at DESC
            ";
        } elseif ($sortBy === 'progress') {
            $orderSql = "
                ORDER BY
                    p.progress " . strtoupper($sortDir) . ",
                    p.updated_at DESC
            ";
        } elseif ($sortBy === 'health') {
            $direction = $sortDir === 'asc' ? 'ASC' : 'DESC';
            $orderSql = "
                ORDER BY
                    CASE p.health
                        WHEN 'on_track' THEN 1
                        WHEN 'watch' THEN 2
                        WHEN 'at_risk' THEN 3
                        ELSE 4
                    END " . $direction . ",
                    p.updated_at DESC
            ";
        }

        $listStmt = DB::prepare("
            SELECT p.*, c.name as customer_name, o.name as owner_name
            " . $baseFrom . $filterSql . "
            " . $orderSql . "
            LIMIT ? OFFSET ?
        ");
        $listParams = $paramsSql;
        $listParams[] = $perPage;
        $listParams[] = $offset;
        $listStmt->execute($listParams);
        $projects = $listStmt->fetchAll();

        foreach ($projects as &$project) {
            $project['status_label'] = $this->labelFor('status', (string)($project['status'] ?? 'planning'));
            $project['priority_label'] = $this->labelFor('priority', (string)($project['priority'] ?? 'medium'));
            $project['health_label'] = $this->labelFor('health', (string)($project['health'] ?? 'on_track'));
        }
        unset($project);

        $statsBase = " FROM projects p WHERE 1=1";
        $statsParams = [];
        if (Auth::isCustomer()) {
            $statsBase .= " AND p.customer_id = ?";
            $statsParams[] = (int)$user['id'];
        }
        $kpiStmt = DB::prepare("
            SELECT
                COUNT(*) as total_projects,
                SUM(CASE WHEN status IN ('active','review') THEN 1 ELSE 0 END) as live_projects,
                SUM(CASE WHEN health = 'at_risk' OR status = 'blocked' THEN 1 ELSE 0 END) as at_risk_projects,
                SUM(CASE WHEN due_date IS NOT NULL AND due_date <= DATE_ADD(CURDATE(), INTERVAL 14 DAY) AND status NOT IN ('completed') THEN 1 ELSE 0 END) as due_soon_projects
            " . $statsBase
        );
        $kpiStmt->execute($statsParams);
        $kpis = $kpiStmt->fetch() ?: [];

        $customers = $this->loadCustomers();
        $totalPages = max(1, (int)ceil($total / $perPage));

        include __DIR__ . '/../Views/projects.php';
    }

    public function board($params = []): void {
        $this->ensureSchema();
        $this->ensureDemoProjects();
        $this->authorizeView();

        $user = Auth::user();
        $statuses = ['planning', 'active', 'review', 'completed', 'blocked'];
        $boardProjects = [];

        foreach ($statuses as $status) {
            if (Auth::isCustomer()) {
                $stmt = DB::prepare("
                    SELECT p.*, u.name as customer_name
                    FROM projects p
                    LEFT JOIN users u ON p.customer_id = u.id
                    WHERE p.customer_id = ? AND p.status = ?
                    ORDER BY p.updated_at DESC
                    LIMIT 12
                ");
                $stmt->execute([(int)$user['id'], $status]);
            } else {
                $stmt = DB::prepare("
                    SELECT p.*, u.name as customer_name
                    FROM projects p
                    LEFT JOIN users u ON p.customer_id = u.id
                    WHERE p.status = ?
                    ORDER BY p.updated_at DESC
                    LIMIT 12
                ");
                $stmt->execute([$status]);
            }

            $boardProjects[$status] = array_map(function ($project) {
                $project['status_label'] = $this->labelFor('status', (string)($project['status'] ?? 'planning'));
                $project['priority_label'] = $this->labelFor('priority', (string)($project['priority'] ?? 'medium'));
                $project['health_label'] = $this->labelFor('health', (string)($project['health'] ?? 'on_track'));
                return $project;
            }, $stmt->fetchAll());
        }

        include __DIR__ . '/../Views/projects_board.php';
    }

    public function create($params = []): void {
        $this->ensureSchema();
        $this->ensureDemoProjects();
        $this->authorizeManage();
        $project = null;
        $customers = $this->loadCustomers();
        $assignableUsers = $this->loadAssignableUsers();
        include __DIR__ . '/../Views/project_form.php';
    }

    public function store($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $error = Locale::runtime('csrf_invalid');
            $project = $_POST;
            $customers = $this->loadCustomers();
            $assignableUsers = $this->loadAssignableUsers();
            include __DIR__ . '/../Views/project_form.php';
            return;
        }

        $payload = $this->sanitizePayload($_POST);
        $validationError = $this->validatePayload($payload);
        if ($validationError !== null) {
            $error = $validationError;
            $project = $payload;
            $customers = $this->loadCustomers();
            $assignableUsers = $this->loadAssignableUsers();
            include __DIR__ . '/../Views/project_form.php';
            return;
        }

        $insertStmt = DB::prepare("
            INSERT INTO projects (
                customer_id, owner_id, name, code, status, priority, health, progress,
                budget, start_date, due_date, description, tags
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $insertStmt->execute([
            $payload['customer_id'],
            $payload['owner_id'],
            $payload['name'],
            $payload['code'],
            $payload['status'],
            $payload['priority'],
            $payload['health'],
            $payload['progress'],
            $payload['budget'],
            $payload['start_date'],
            $payload['due_date'],
            $payload['description'],
            $payload['tags'],
        ]);

        $projectId = (int)DB::lastInsertId();
        $this->touchProjectHealth($projectId);
        Auth::logAction('create', 'project', $projectId);
        Auth::flash(Locale::runtime('project_created'), 'success');
        header('Location: /projects/' . $projectId);
        exit;
    }

    public function show($params = []): void {
        $this->ensureSchema();
        $this->ensureDemoProjects();
        $this->authorizeView();

        $id = (int)($params['id'] ?? 0);
        $project = $this->findProject($id);

        if (!$project) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }
        if (!$this->canAccessProject($project)) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            return;
        }

        $project['status_label'] = $this->labelFor('status', (string)($project['status'] ?? 'planning'));
        $project['priority_label'] = $this->labelFor('priority', (string)($project['priority'] ?? 'medium'));
        $project['health_label'] = $this->labelFor('health', (string)($project['health'] ?? 'on_track'));

        $ticketsTotal = 0;
        $ticketsOpen = 0;
        $documentsTotal = 0;
        $recentTickets = [];
        $recentDocuments = [];
        $activity = [];
        $milestones = [];
        $tasks = [];
        $taskSummary = [
            'total' => 0,
            'done' => 0,
            'doing' => 0,
            'todo' => 0,
            'overdue' => 0,
        ];

        if (!empty($project['customer_id'])) {
            $ticketsStmt = DB::prepare("
                SELECT
                    COUNT(*) as total,
                    SUM(CASE WHEN status IN ('open', 'in_progress') THEN 1 ELSE 0 END) as open_total
                FROM tickets
                WHERE customer_id = ?
            ");
            $ticketsStmt->execute([(int)$project['customer_id']]);
            $ticketRow = $ticketsStmt->fetch() ?: [];
            $ticketsTotal = (int)($ticketRow['total'] ?? 0);
            $ticketsOpen = (int)($ticketRow['open_total'] ?? 0);

            $documentsStmt = DB::prepare("SELECT COUNT(*) as total FROM documents WHERE customer_id = ?");
            $documentsStmt->execute([(int)$project['customer_id']]);
            $documentsTotal = (int)(($documentsStmt->fetch() ?: [])['total'] ?? 0);

            $recentTicketsStmt = DB::prepare("
                SELECT id, subject, category, status, priority, created_at
                FROM tickets
                WHERE customer_id = ?
                ORDER BY created_at DESC
                LIMIT 5
            ");
            $recentTicketsStmt->execute([(int)$project['customer_id']]);
            $recentTickets = $recentTicketsStmt->fetchAll();

            $recentDocumentsStmt = DB::prepare("
                SELECT id, filename_original, mime, size, created_at
                FROM documents
                WHERE customer_id = ?
                ORDER BY created_at DESC
                LIMIT 5
            ");
            $recentDocumentsStmt->execute([(int)$project['customer_id']]);
            $recentDocuments = $recentDocumentsStmt->fetchAll();
        }

        $activityStmt = DB::prepare("
            SELECT a.*, u.name as actor_name
            FROM audit_logs a
            LEFT JOIN users u ON a.actor_id = u.id
            WHERE a.entity = 'project' AND a.entity_id = ?
            ORDER BY a.created_at DESC
            LIMIT 10
        ");
        $activityStmt->execute([$id]);
        $activity = $activityStmt->fetchAll();

        $milestoneStmt = DB::prepare("
            SELECT *
            FROM project_milestones
            WHERE project_id = ?
            ORDER BY sort_order ASC, due_date IS NULL, due_date ASC, id ASC
        ");
        $milestoneStmt->execute([$id]);
        $milestones = $milestoneStmt->fetchAll();

        foreach ($milestones as &$milestone) {
            $milestone['status_label'] = $this->labelFor('milestone_status', (string)($milestone['status'] ?? 'planned'));
        }
        unset($milestone);

        $taskStmt = DB::prepare("
            SELECT t.*, u.name as assignee_name, m.title as milestone_title
            FROM project_tasks t
            LEFT JOIN users u ON t.assignee_id = u.id
            LEFT JOIN project_milestones m ON t.milestone_id = m.id
            WHERE t.project_id = ?
            ORDER BY
                CASE t.status
                    WHEN 'doing' THEN 1
                    WHEN 'todo' THEN 2
                    ELSE 3
                END,
                t.sort_order ASC,
                t.due_date IS NULL,
                t.due_date ASC,
                t.id ASC
        ");
        $taskStmt->execute([$id]);
        $tasks = $taskStmt->fetchAll();

        foreach ($tasks as &$task) {
            $statusKey = (string)($task['status'] ?? 'todo');
            $task['status_label'] = $this->labelFor('task_status', $statusKey);
            $task['priority_label'] = $this->labelFor('priority', (string)($task['priority'] ?? 'medium'));
            if (isset($taskSummary[$statusKey])) {
                $taskSummary[$statusKey]++;
            }
            $taskSummary['total']++;
            if ($statusKey === 'done') {
                $taskSummary['done']++;
            }
            if (!empty($task['due_date']) && strtotime((string)$task['due_date']) < strtotime(date('Y-m-d')) && $statusKey !== 'done') {
                $taskSummary['overdue']++;
            }
        }
        unset($task);

        $milestoneCompleted = count(array_filter($milestones, static fn ($milestone) => (string)($milestone['status'] ?? '') === 'done'));
        $assignableUsers = $this->loadAssignableUsers();

        include __DIR__ . '/../Views/project_workspace.php';
    }

    public function addMilestone($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /projects/' . (int)($params['id'] ?? 0));
            exit;
        }

        $projectId = (int)($params['id'] ?? 0);
        $title = trim((string)($_POST['title'] ?? ''));
        $status = trim((string)($_POST['status'] ?? 'planned'));
        $dueDate = trim((string)($_POST['due_date'] ?? '')) ?: null;
        $allowed = ['planned', 'active', 'done'];

        if ($title === '') {
            Auth::flash(Locale::runtime('project_milestone_required'), 'danger');
            header('Location: /projects/' . $projectId);
            exit;
        }

        if (!in_array($status, $allowed, true)) {
            $status = 'planned';
        }

        $sortStmt = DB::prepare("SELECT COALESCE(MAX(sort_order), 0) + 1 as next_order FROM project_milestones WHERE project_id = ?");
        $sortStmt->execute([$projectId]);
        $sortOrder = (int)(($sortStmt->fetch() ?: [])['next_order'] ?? 1);

        $stmt = DB::prepare("INSERT INTO project_milestones (project_id, title, status, due_date, sort_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$projectId, $title, $status, $dueDate, $sortOrder]);

        $this->touchProjectHealth($projectId);
        Auth::logAction('create', 'project_milestone', (int)DB::lastInsertId());
        Auth::flash(Locale::runtime('project_milestone_created'), 'success');
        header('Location: /projects/' . $projectId);
        exit;
    }

    public function addTask($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /projects/' . (int)($params['id'] ?? 0));
            exit;
        }

        $projectId = (int)($params['id'] ?? 0);
        $title = trim((string)($_POST['title'] ?? ''));
        $status = trim((string)($_POST['status'] ?? 'todo'));
        $priority = trim((string)($_POST['priority'] ?? 'medium'));
        $milestoneId = max(0, (int)($_POST['milestone_id'] ?? 0));
        $assigneeId = max(0, (int)($_POST['assignee_id'] ?? 0));
        $dueDate = trim((string)($_POST['due_date'] ?? '')) ?: null;
        $allowedStatus = ['todo', 'doing', 'done'];
        $allowedPriority = ['low', 'medium', 'high'];

        if ($title === '') {
            Auth::flash(Locale::runtime('project_task_required'), 'danger');
            header('Location: /projects/' . $projectId);
            exit;
        }

        if (!in_array($status, $allowedStatus, true)) {
            $status = 'todo';
        }
        if (!in_array($priority, $allowedPriority, true)) {
            $priority = 'medium';
        }

        $sortStmt = DB::prepare("SELECT COALESCE(MAX(sort_order), 0) + 1 as next_order FROM project_tasks WHERE project_id = ?");
        $sortStmt->execute([$projectId]);
        $sortOrder = (int)(($sortStmt->fetch() ?: [])['next_order'] ?? 1);

        $stmt = DB::prepare("INSERT INTO project_tasks (project_id, milestone_id, title, status, priority, assignee_id, due_date, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $projectId,
            $milestoneId > 0 ? $milestoneId : null,
            $title,
            $status,
            $priority,
            $assigneeId > 0 ? $assigneeId : (int)(Auth::user()['id'] ?? 0),
            $dueDate,
            $sortOrder,
        ]);

        $this->touchProjectHealth($projectId);
        Auth::logAction('create', 'project_task', (int)DB::lastInsertId());
        Auth::flash(Locale::runtime('project_task_created'), 'success');
        header('Location: /projects/' . $projectId);
        exit;
    }

    public function updateMilestone($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /projects/' . (int)($params['id'] ?? 0));
            exit;
        }

        $projectId = (int)($params['id'] ?? 0);
        $milestoneId = (int)($params['milestoneId'] ?? 0);
        $title = trim((string)($_POST['title'] ?? ''));
        $status = trim((string)($_POST['status'] ?? 'planned'));
        $dueDate = trim((string)($_POST['due_date'] ?? '')) ?: null;

        if ($title === '') {
            Auth::flash(Locale::runtime('project_milestone_required'), 'danger');
            header('Location: /projects/' . $projectId);
            exit;
        }

        if (!in_array($status, ['planned', 'active', 'done'], true)) {
            $status = 'planned';
        }

        $stmt = DB::prepare("UPDATE project_milestones SET title = ?, status = ?, due_date = ? WHERE id = ? AND project_id = ?");
        $stmt->execute([$title, $status, $dueDate, $milestoneId, $projectId]);

        $this->touchProjectHealth($projectId);
        Auth::logAction('update', 'project_milestone', $milestoneId);
        Auth::flash(Locale::runtime('project_milestone_updated'), 'success');
        header('Location: /projects/' . $projectId);
        exit;
    }

    public function deleteMilestone($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /projects/' . (int)($params['id'] ?? 0));
            exit;
        }

        $projectId = (int)($params['id'] ?? 0);
        $milestoneId = (int)($params['milestoneId'] ?? 0);

        $nullTasksStmt = DB::prepare("UPDATE project_tasks SET milestone_id = NULL WHERE project_id = ? AND milestone_id = ?");
        $nullTasksStmt->execute([$projectId, $milestoneId]);

        $stmt = DB::prepare("DELETE FROM project_milestones WHERE id = ? AND project_id = ?");
        $stmt->execute([$milestoneId, $projectId]);

        $this->touchProjectHealth($projectId);
        Auth::logAction('delete', 'project_milestone', $milestoneId);
        Auth::flash(Locale::runtime('project_milestone_deleted'), 'success');
        header('Location: /projects/' . $projectId);
        exit;
    }

    public function updateTask($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /projects/' . (int)($params['id'] ?? 0));
            exit;
        }

        $projectId = (int)($params['id'] ?? 0);
        $taskId = (int)($params['taskId'] ?? 0);
        $title = trim((string)($_POST['title'] ?? ''));
        $status = trim((string)($_POST['status'] ?? 'todo'));
        $priority = trim((string)($_POST['priority'] ?? 'medium'));
        $milestoneId = max(0, (int)($_POST['milestone_id'] ?? 0));
        $assigneeId = max(0, (int)($_POST['assignee_id'] ?? 0));
        $dueDate = trim((string)($_POST['due_date'] ?? '')) ?: null;

        if ($title === '') {
            Auth::flash(Locale::runtime('project_task_required'), 'danger');
            header('Location: /projects/' . $projectId);
            exit;
        }
        if (!in_array($status, ['todo', 'doing', 'done'], true)) {
            $status = 'todo';
        }
        if (!in_array($priority, ['low', 'medium', 'high'], true)) {
            $priority = 'medium';
        }

        $stmt = DB::prepare("
            UPDATE project_tasks
            SET title = ?, status = ?, priority = ?, milestone_id = ?, assignee_id = ?, due_date = ?
            WHERE id = ? AND project_id = ?
        ");
        $stmt->execute([
            $title,
            $status,
            $priority,
            $milestoneId > 0 ? $milestoneId : null,
            $assigneeId > 0 ? $assigneeId : null,
            $dueDate,
            $taskId,
            $projectId,
        ]);

        $this->touchProjectHealth($projectId);
        Auth::logAction('update', 'project_task', $taskId);
        Auth::flash(Locale::runtime('project_task_updated'), 'success');
        header('Location: /projects/' . $projectId);
        exit;
    }

    public function updateTaskStatus($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /projects/' . (int)($params['id'] ?? 0));
            exit;
        }

        $projectId = (int)($params['id'] ?? 0);
        $taskId = (int)($params['taskId'] ?? 0);
        $status = trim((string)($_POST['status'] ?? 'todo'));
        if (!in_array($status, ['todo', 'doing', 'done'], true)) {
            $status = 'todo';
        }

        $stmt = DB::prepare("UPDATE project_tasks SET status = ? WHERE id = ? AND project_id = ?");
        $stmt->execute([$status, $taskId, $projectId]);

        $this->touchProjectHealth($projectId);
        Auth::logAction('update', 'project_task', $taskId);
        Auth::flash(Locale::runtime('project_task_status_updated'), 'success');
        header('Location: /projects/' . $projectId);
        exit;
    }

    public function deleteTask($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /projects/' . (int)($params['id'] ?? 0));
            exit;
        }

        $projectId = (int)($params['id'] ?? 0);
        $taskId = (int)($params['taskId'] ?? 0);

        $stmt = DB::prepare("DELETE FROM project_tasks WHERE id = ? AND project_id = ?");
        $stmt->execute([$taskId, $projectId]);

        $this->touchProjectHealth($projectId);
        Auth::logAction('delete', 'project_task', $taskId);
        Auth::flash(Locale::runtime('project_task_deleted'), 'success');
        header('Location: /projects/' . $projectId);
        exit;
    }

    public function edit($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        $id = (int)($params['id'] ?? 0);
        $stmt = DB::prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $project = $stmt->fetch();

        if (!$project) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }

        $customers = $this->loadCustomers();
        $assignableUsers = $this->loadAssignableUsers();
        include __DIR__ . '/../Views/project_form.php';
    }

    public function update($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        $id = (int)($params['id'] ?? 0);
        $currentStmt = DB::prepare("SELECT * FROM projects WHERE id = ?");
        $currentStmt->execute([$id]);
        $currentProject = $currentStmt->fetch();

        if (!$currentProject) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $error = Locale::runtime('csrf_invalid');
            $project = array_merge($currentProject, $_POST);
            $customers = $this->loadCustomers();
            $assignableUsers = $this->loadAssignableUsers();
            include __DIR__ . '/../Views/project_form.php';
            return;
        }

        $payload = $this->sanitizePayload($_POST, true, (int)($currentProject['customer_id'] ?? 0));
        $validationError = $this->validatePayload($payload, $id);
        if ($validationError !== null) {
            $error = $validationError;
            $project = array_merge($currentProject, $payload);
            $customers = $this->loadCustomers();
            $assignableUsers = $this->loadAssignableUsers();
            include __DIR__ . '/../Views/project_form.php';
            return;
        }

        $updateStmt = DB::prepare("
            UPDATE projects
            SET customer_id = ?, owner_id = ?, name = ?, code = ?, status = ?, priority = ?, health = ?,
                progress = ?, budget = ?, start_date = ?, due_date = ?, description = ?, tags = ?
            WHERE id = ?
        ");
        $updateStmt->execute([
            $payload['customer_id'],
            $payload['owner_id'],
            $payload['name'],
            $payload['code'],
            $payload['status'],
            $payload['priority'],
            $payload['health'],
            $payload['progress'],
            $payload['budget'],
            $payload['start_date'],
            $payload['due_date'],
            $payload['description'],
            $payload['tags'],
            $id,
        ]);

        $this->touchProjectHealth($id);
        Auth::logAction('update', 'project', $id);
        Auth::flash(Locale::runtime('project_updated'), 'success');
        header('Location: /projects/' . $id);
        exit;
    }

    private function sanitizePayload(array $input, bool $isUpdate = false, int $fallbackCustomerId = 0): array {
        $validStatuses = array_keys($this->dictionaries()['status']);
        $validPriorities = array_keys($this->dictionaries()['priority']);
        $validHealth = array_keys($this->dictionaries()['health']);
        $customerId = Auth::isCustomer() ? (int)(Auth::user()['id'] ?? 0) : max(0, (int)($input['customer_id'] ?? $fallbackCustomerId));
        $progress = max(0, min(100, (int)($input['progress'] ?? 0)));
        $budgetRaw = trim((string)($input['budget'] ?? ''));

        return [
            'customer_id' => $customerId > 0 ? $customerId : null,
            'owner_id' => Auth::isCustomer() ? (int)(Auth::user()['id'] ?? 0) : max(0, (int)($input['owner_id'] ?? (Auth::user()['id'] ?? 0))),
            'name' => trim((string)($input['name'] ?? '')),
            'code' => strtoupper(trim((string)($input['code'] ?? ''))),
            'status' => in_array(($input['status'] ?? ''), $validStatuses, true) ? (string)$input['status'] : 'planning',
            'priority' => in_array(($input['priority'] ?? ''), $validPriorities, true) ? (string)$input['priority'] : 'medium',
            'health' => in_array(($input['health'] ?? ''), $validHealth, true) ? (string)$input['health'] : 'on_track',
            'progress' => $progress,
            'budget' => $budgetRaw !== '' ? (float)$budgetRaw : null,
            'start_date' => trim((string)($input['start_date'] ?? '')) ?: null,
            'due_date' => trim((string)($input['due_date'] ?? '')) ?: null,
            'description' => trim((string)($input['description'] ?? '')),
            'tags' => trim((string)($input['tags'] ?? '')),
        ];
    }

    private function validatePayload(array $payload, int $ignoreId = 0): ?string {
        if ($payload['name'] === '' || $payload['code'] === '') {
            return Locale::runtime('project_required_fields');
        }

        $codeStmt = DB::prepare("SELECT id FROM projects WHERE code = ?" . ($ignoreId > 0 ? " AND id != ?" : ""));
        $params = [$payload['code']];
        if ($ignoreId > 0) {
            $params[] = $ignoreId;
        }
        $codeStmt->execute($params);
        if ($codeStmt->fetch()) {
            return Locale::runtime('project_code_exists');
        }

        if ($payload['due_date'] !== null && $payload['start_date'] !== null && strtotime((string)$payload['due_date']) < strtotime((string)$payload['start_date'])) {
            return Locale::runtime('project_date_invalid');
        }

        return null;
    }

    public function delete($params = []): void {
        $this->ensureSchema();
        $this->authorizeManage();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /projects');
            exit;
        }

        $id = (int)($params['id'] ?? 0);
        DB::prepare("DELETE FROM project_tasks WHERE project_id = ?")->execute([$id]);
        DB::prepare("DELETE FROM project_milestones WHERE project_id = ?")->execute([$id]);
        DB::prepare("DELETE FROM projects WHERE id = ?")->execute([$id]);

        Auth::logAction('delete', 'project', $id);
        Auth::flash(Locale::runtime('project_deleted'), 'success');
        header('Location: /projects');
        exit;
    }
}
