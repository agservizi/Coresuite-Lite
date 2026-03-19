<?php use Core\Auth; ?>
<?php use Core\DB; ?>
<?php use Core\Locale; ?>
<?php use Core\RolePermissions; ?>
<?php use Core\WorkspaceSettings; ?>
<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isActivePath = function ($path, $prefix = false) use ($currentPath) {
    if ($prefix) {
        return strpos($currentPath, $path) === 0;
    }
    return $currentPath === $path;
};

$isAdmin = false;
$isCustomer = false;
$currentUser = null;

try {
    $isAdmin = Auth::isAdmin();
    $isCustomer = Auth::isCustomer();
    $currentUser = Auth::user();
} catch (\Throwable $e) {
    $isAdmin = false;
    $isCustomer = false;
    $currentUser = null;
}

$workspaceSettings = WorkspaceSettings::all();
$sidebarText = [
    'it' => ['workspace_fallback' => 'Workspace', 'dashboard' => 'Dashboard', 'sales' => 'Area commerciale', 'sales_pipeline' => 'Pipeline vendite', 'sales_calendar' => 'Agenda commerciale', 'projects' => 'Progetti', 'tickets' => 'Ticket', 'customers' => 'Clienti', 'documents' => 'Documenti', 'documents_board' => 'Board documenti', 'reports' => 'Report', 'audit_logs' => 'Log audit', 'profile' => 'Profilo', 'users_manage' => 'Gestione utenti', 'upload_document' => 'Carica documento', 'global_search' => 'Ricerca globale', 'filter_placeholder' => 'Filtra moduli e pagine...', 'filter_aria' => 'Filtra menu sidebar', 'filter_empty' => 'Nessun modulo corrisponde alla ricerca.', 'tooltip_search' => 'Ricerca globale', 'tooltip_tickets' => 'Apri ticket', 'operational' => 'Operativo', 'administration' => 'Amministrazione', 'workspace' => 'Workspace', 'footer_meta' => 'Pannello operativo', 'preferences' => 'Preferenze', 'new_request' => 'Nuova richiesta', 'settings' => 'Impostazioni', 'search' => 'Ricerca', 'workspace_settings' => 'Impostazioni workspace', 'notification_settings' => 'Impostazioni notifiche', 'roles_permissions' => 'Ruoli e permessi', 'spotlight' => 'Spotlight', 'live' => 'Live', 'insight' => 'Insight', 'trace' => 'Trace', 'view' => 'Vista', 'admin_badge' => 'Admin', 'signal' => 'Segnale', 'matrix' => 'Matrice', 'new' => 'Nuovo'],
    'en' => ['workspace_fallback' => 'Workspace', 'dashboard' => 'Dashboard', 'sales' => 'Sales hub', 'sales_pipeline' => 'Sales pipeline', 'sales_calendar' => 'Sales agenda', 'projects' => 'Projects', 'tickets' => 'Tickets', 'customers' => 'Customers', 'documents' => 'Documents', 'documents_board' => 'Documents board', 'reports' => 'Reports', 'audit_logs' => 'Audit logs', 'profile' => 'Profile', 'users_manage' => 'User management', 'upload_document' => 'Upload document', 'global_search' => 'Global search', 'filter_placeholder' => 'Filter modules and pages...', 'filter_aria' => 'Filter sidebar menu', 'filter_empty' => 'No modules match this search.', 'tooltip_search' => 'Global search', 'tooltip_tickets' => 'Open tickets', 'operational' => 'Operational', 'administration' => 'Administration', 'workspace' => 'Workspace', 'footer_meta' => 'Operations panel', 'preferences' => 'Preferences', 'new_request' => 'New request', 'settings' => 'Settings', 'search' => 'Search', 'workspace_settings' => 'Workspace settings', 'notification_settings' => 'Notification settings', 'roles_permissions' => 'Roles & permissions', 'spotlight' => 'Spotlight', 'live' => 'Live', 'insight' => 'Insight', 'trace' => 'Trace', 'view' => 'View', 'admin_badge' => 'Admin', 'signal' => 'Signal', 'matrix' => 'Matrix', 'new' => 'New'],
    'fr' => ['workspace_fallback' => 'Workspace', 'dashboard' => 'Dashboard', 'sales' => 'Hub commercial', 'sales_pipeline' => 'Pipeline commercial', 'sales_calendar' => 'Agenda commerciale', 'projects' => 'Projets', 'tickets' => 'Tickets', 'customers' => 'Clients', 'documents' => 'Documents', 'documents_board' => 'Board documents', 'reports' => 'Rapports', 'audit_logs' => 'Logs audit', 'profile' => 'Profil', 'users_manage' => 'Gestion utilisateurs', 'upload_document' => 'Televerser document', 'global_search' => 'Recherche globale', 'filter_placeholder' => 'Filtrer modules et pages...', 'filter_aria' => 'Filtrer menu sidebar', 'filter_empty' => 'Aucun module ne correspond a cette recherche.', 'tooltip_search' => 'Recherche globale', 'tooltip_tickets' => 'Ouvrir tickets', 'operational' => 'Operationnel', 'administration' => 'Administration', 'workspace' => 'Workspace', 'footer_meta' => 'Panneau operationnel', 'preferences' => 'Preferences', 'new_request' => 'Nouvelle demande', 'settings' => 'Parametres', 'search' => 'Recherche', 'workspace_settings' => 'Parametres workspace', 'notification_settings' => 'Parametres notifications', 'roles_permissions' => 'Roles et permissions', 'spotlight' => 'Spotlight', 'live' => 'Live', 'insight' => 'Insight', 'trace' => 'Trace', 'view' => 'Vue', 'admin_badge' => 'Admin', 'signal' => 'Signal', 'matrix' => 'Matrice', 'new' => 'Nouveau'],
    'es' => ['workspace_fallback' => 'Workspace', 'dashboard' => 'Dashboard', 'sales' => 'Hub comercial', 'sales_pipeline' => 'Pipeline comercial', 'sales_calendar' => 'Agenda comercial', 'projects' => 'Proyectos', 'tickets' => 'Tickets', 'customers' => 'Clientes', 'documents' => 'Documentos', 'documents_board' => 'Board de documentos', 'reports' => 'Reportes', 'audit_logs' => 'Logs de auditoria', 'profile' => 'Perfil', 'users_manage' => 'Gestion usuarios', 'upload_document' => 'Cargar documento', 'global_search' => 'Busqueda global', 'filter_placeholder' => 'Filtrar modulos y paginas...', 'filter_aria' => 'Filtrar menu sidebar', 'filter_empty' => 'Ningun modulo coincide con esta busqueda.', 'tooltip_search' => 'Busqueda global', 'tooltip_tickets' => 'Abrir tickets', 'operational' => 'Operativo', 'administration' => 'Administracion', 'workspace' => 'Workspace', 'footer_meta' => 'Panel operativo', 'preferences' => 'Preferencias', 'new_request' => 'Nueva solicitud', 'settings' => 'Configuracion', 'search' => 'Busqueda', 'workspace_settings' => 'Configuracion workspace', 'notification_settings' => 'Configuracion de notificaciones', 'roles_permissions' => 'Roles y permisos', 'spotlight' => 'Spotlight', 'live' => 'Live', 'insight' => 'Insight', 'trace' => 'Trace', 'view' => 'Vista', 'admin_badge' => 'Admin', 'signal' => 'Senal', 'matrix' => 'Matriz', 'new' => 'Nuevo'],
];
$st = $sidebarText[Locale::current()] ?? $sidebarText['it'];
$customersEnabled = !$isCustomer && !empty($workspaceSettings['customers_enabled']) && RolePermissions::canCurrent('customers_view');
$reportsEnabled = !$isCustomer && !empty($workspaceSettings['reports_enabled']) && RolePermissions::canCurrent('reports_view');
$auditLogsEnabled = !$isCustomer && !empty($workspaceSettings['audit_logs_enabled']) && RolePermissions::canCurrent('audit_logs_view');
$documentsBoardEnabled = !empty($workspaceSettings['documents_board_enabled']);

$sidebarName = trim((string)($workspaceSettings['workspace_name'] ?? ($currentUser['name'] ?? $st['workspace_fallback'])));
$sidebarRole = ucfirst((string)($currentUser['role'] ?? 'member'));
$userId = (int)($currentUser['id'] ?? 0);
$openTicketCount = 0;
$visibleDocumentCount = 0;
$activeUserCount = 0;
$recentUploadCount = 0;
$customerCount = 0;
$projectCount = 0;
$salesOpenDealsCount = 0;
$salesReminderCount = 0;

try {
    if ($isCustomer && $userId > 0) {
        $ticketStmt = DB::prepare("SELECT COUNT(*) AS total FROM tickets WHERE customer_id = ? AND status IN ('open', 'in_progress')");
        $ticketStmt->execute([$userId]);
        $openTicketCount = (int)($ticketStmt->fetch()['total'] ?? 0);

        $docStmt = DB::prepare("SELECT COUNT(*) AS total FROM documents WHERE customer_id = ?");
        $docStmt->execute([$userId]);
        $visibleDocumentCount = (int)($docStmt->fetch()['total'] ?? 0);
    } else {
        $ticketStmt = DB::prepare("SELECT COUNT(*) AS total FROM tickets WHERE status IN ('open', 'in_progress')");
        $ticketStmt->execute();
        $openTicketCount = (int)($ticketStmt->fetch()['total'] ?? 0);

        $docStmt = DB::prepare("SELECT COUNT(*) AS total FROM documents");
        $docStmt->execute();
        $visibleDocumentCount = (int)($docStmt->fetch()['total'] ?? 0);
    }

    if ($isAdmin) {
        $userStmt = DB::prepare("SELECT COUNT(*) AS total FROM users WHERE status = 'active'");
        $userStmt->execute();
        $activeUserCount = (int)($userStmt->fetch()['total'] ?? 0);

        $uploadStmt = DB::prepare("SELECT COUNT(*) AS total FROM documents WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
        $uploadStmt->execute();
        $recentUploadCount = (int)($uploadStmt->fetch()['total'] ?? 0);
    }

    if (!$isCustomer) {
        $customerStmt = DB::prepare("SELECT COUNT(*) AS total FROM users WHERE role = 'customer'");
        $customerStmt->execute();
        $customerCount = (int)($customerStmt->fetch()['total'] ?? 0);
    }
    if (RolePermissions::canCurrent('projects_view')) {
        if ($isCustomer && $userId > 0) {
            $projectStmt = DB::prepare("SELECT COUNT(*) AS total FROM projects WHERE customer_id = ? AND status IN ('planning', 'active', 'review', 'blocked')");
            $projectStmt->execute([$userId]);
        } else {
            $projectStmt = DB::prepare("SELECT COUNT(*) AS total FROM projects WHERE status IN ('planning', 'active', 'review', 'blocked')");
            $projectStmt->execute();
        }
        $projectCount = (int)($projectStmt->fetch()['total'] ?? 0);
    }

    if (!$isCustomer && RolePermissions::canCurrent('sales_view')) {
        $salesDealStmt = DB::prepare("SELECT COUNT(*) AS total FROM crm_deals WHERE status = 'open' AND stage NOT IN ('won', 'lost')");
        $salesDealStmt->execute();
        $salesOpenDealsCount = (int)($salesDealStmt->fetch()['total'] ?? 0);

        $salesReminderStmt = DB::prepare("SELECT COUNT(*) AS total FROM crm_reminders WHERE status = 'pending'");
        $salesReminderStmt->execute();
        $salesReminderCount = (int)($salesReminderStmt->fetch()['total'] ?? 0);
    }
} catch (\Throwable $e) {
    $openTicketCount = $openTicketCount ?: 0;
    $visibleDocumentCount = $visibleDocumentCount ?: 0;
    $activeUserCount = $activeUserCount ?: 0;
    $recentUploadCount = $recentUploadCount ?: 0;
    $projectCount = $projectCount ?: 0;
    $salesOpenDealsCount = $salesOpenDealsCount ?: 0;
    $salesReminderCount = $salesReminderCount ?: 0;
}

$primaryLinks = [
    ['href' => '/dashboard', 'label' => $st['dashboard'], 'icon' => 'fa-gauge-high', 'active' => $isActivePath('/dashboard'), 'badge' => $st['live']],
];

if (RolePermissions::canCurrent('projects_view')) {
    $primaryLinks[] = ['href' => '/projects', 'label' => $st['projects'], 'icon' => 'fa-diagram-project', 'active' => $isActivePath('/projects', true), 'badge' => (string)$projectCount];
}

if (!$isCustomer && RolePermissions::canCurrent('sales_view')) {
    $primaryLinks[] = ['href' => '/sales', 'label' => $st['sales'], 'icon' => 'fa-briefcase', 'active' => $isActivePath('/sales') || $isActivePath('/sales/', true), 'badge' => (string)$salesOpenDealsCount];
}

$primaryLinks = array_merge($primaryLinks, [
    ['href' => '/tickets', 'label' => $st['tickets'], 'icon' => 'fa-ticket-alt', 'active' => $isActivePath('/tickets', true), 'badge' => (string)$openTicketCount],
    ['href' => '/documents', 'label' => $st['documents'], 'icon' => 'fa-file-lines', 'active' => ($isActivePath('/documents', true) && !$isActivePath('/documents/upload')), 'badge' => (string)$visibleDocumentCount],
    ['href' => '/profile', 'label' => $st['profile'], 'icon' => 'fa-user-cog', 'active' => $isActivePath('/profile'), 'badge' => $sidebarRole],
]);

if ($customersEnabled) {
    array_splice($primaryLinks, 3, 0, [[
        'href' => '/customers',
        'label' => $st['customers'],
        'icon' => 'fa-address-card',
        'active' => $isActivePath('/customers', true),
        'badge' => (string)$customerCount,
    ]]);
}

$customerLinks = [];
if ($isCustomer) {
    if (RolePermissions::canCurrent('tickets_create')) {
        $customerLinks[] = ['href' => '/tickets/create', 'label' => $st['new_request'], 'icon' => 'fa-plus-circle', 'active' => $isActivePath('/tickets/create'), 'badge' => $st['new']];
    }
}

$adminLinks = [];
if ($isAdmin && RolePermissions::canCurrent('users_manage')) {
    $adminLinks[] = ['href' => '/admin/users', 'label' => $st['users_manage'], 'icon' => 'fa-users-cog', 'active' => $isActivePath('/admin/users', true), 'badge' => (string)$activeUserCount];
}
if (RolePermissions::canCurrent('documents_upload')) {
    $adminLinks[] = ['href' => '/documents/upload', 'label' => $st['upload_document'], 'icon' => 'fa-cloud-arrow-up', 'active' => $isActivePath('/documents/upload'), 'badge' => (string)$recentUploadCount];
}

$supportLinks = [
    ['href' => '/search', 'label' => $st['global_search'], 'icon' => 'fa-compass', 'active' => $isActivePath('/search'), 'badge' => $st['spotlight']],
];

if ($reportsEnabled) {
    $supportLinks[] = ['href' => '/reports', 'label' => $st['reports'], 'icon' => 'fa-chart-column', 'active' => $isActivePath('/reports'), 'badge' => $st['insight']];
}
if (!$isCustomer && RolePermissions::canCurrent('sales_pipeline_view')) {
    $supportLinks[] = ['href' => '/sales/pipeline', 'label' => $st['sales_pipeline'], 'icon' => 'fa-chart-line', 'active' => $isActivePath('/sales/pipeline'), 'badge' => (string)$salesOpenDealsCount];
}
if (!$isCustomer && RolePermissions::canCurrent('sales_calendar_view')) {
    $supportLinks[] = ['href' => '/sales/calendar', 'label' => $st['sales_calendar'], 'icon' => 'fa-calendar-check', 'active' => $isActivePath('/sales/calendar'), 'badge' => (string)$salesReminderCount];
}
if ($auditLogsEnabled) {
    $supportLinks[] = ['href' => '/audit-logs', 'label' => $st['audit_logs'], 'icon' => 'fa-shield-alt', 'active' => $isActivePath('/audit-logs'), 'badge' => $st['trace']];
}
if ($documentsBoardEnabled) {
    $supportLinks[] = ['href' => '/documents/board', 'label' => $st['documents_board'], 'icon' => 'fa-table-columns', 'active' => $isActivePath('/documents/board'), 'badge' => $st['view']];
}
if ($isAdmin && RolePermissions::canCurrent('workspace_settings_view')) {
    $supportLinks[] = ['href' => '/workspace/settings', 'label' => $st['workspace_settings'], 'icon' => 'fa-sliders', 'active' => $isActivePath('/workspace/settings'), 'badge' => $st['admin_badge']];
}
if ($isAdmin && RolePermissions::canCurrent('notification_settings_view')) {
    $supportLinks[] = ['href' => '/workspace/notifications', 'label' => $st['notification_settings'], 'icon' => 'fa-bell', 'active' => $isActivePath('/workspace/notifications'), 'badge' => $st['signal']];
}
if ($isAdmin && RolePermissions::canCurrent('roles_permissions_view')) {
    $supportLinks[] = ['href' => '/admin/roles-permissions', 'label' => $st['roles_permissions'], 'icon' => 'fa-user-lock', 'active' => $isActivePath('/admin/roles-permissions'), 'badge' => $st['matrix']];
}
?>

<aside class="admin-sidebar" id="adminSidebar" aria-label="Menu principale" aria-hidden="false" tabindex="-1">
    <div class="admin-sidebar-shell">
        <div class="admin-sidebar-search">
            <i class="fas fa-magnifying-glass"></i>
            <input type="search" placeholder="<?php echo htmlspecialchars($st['filter_placeholder']); ?>" aria-label="<?php echo htmlspecialchars($st['filter_aria']); ?>" data-sidebar-filter>
        </div>

        <div class="admin-sidebar-quickactions">
            <a class="admin-sidebar-quickaction" href="/search" data-tooltip="<?php echo htmlspecialchars($st['tooltip_search']); ?>">
                <i class="fas fa-compass"></i>
                <span><?php echo htmlspecialchars($st['spotlight']); ?></span>
            </a>
            <a class="admin-sidebar-quickaction" href="/tickets" data-tooltip="<?php echo htmlspecialchars($st['tooltip_tickets']); ?>">
                <i class="fas fa-ticket-alt"></i>
                <span><?php echo htmlspecialchars($st['tickets']); ?></span>
            </a>
        </div>

        <div class="admin-sidebar-main">
            <section class="admin-sidebar-section" data-sidebar-section>
                <button class="admin-sidebar-section__toggle" type="button" data-sidebar-section-toggle="operativo" aria-expanded="true">
                    <span class="admin-sidebar-title"><?php echo htmlspecialchars($st['operational']); ?></span>
                    <i class="fas fa-angle-down"></i>
                </button>
                <div class="admin-sidebar-section__body" data-sidebar-section-body="operativo">
                    <?php foreach ($primaryLinks as $link): ?>
                        <a class="admin-nav-link <?php echo $link['active'] ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($link['href']); ?>" data-nav-label="<?php echo htmlspecialchars($link['label']); ?>" data-tooltip="<?php echo htmlspecialchars($link['label']); ?>" title="<?php echo htmlspecialchars($link['label']); ?>">
                            <i class="fas <?php echo htmlspecialchars($link['icon']); ?>"></i>
                            <span><?php echo htmlspecialchars($link['label']); ?></span>
                            <small><?php echo htmlspecialchars($link['badge']); ?></small>
                        </a>
                    <?php endforeach; ?>
                    <?php foreach ($customerLinks as $link): ?>
                        <a class="admin-nav-link <?php echo $link['active'] ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($link['href']); ?>" data-nav-label="<?php echo htmlspecialchars($link['label']); ?>" data-tooltip="<?php echo htmlspecialchars($link['label']); ?>" title="<?php echo htmlspecialchars($link['label']); ?>">
                            <i class="fas <?php echo htmlspecialchars($link['icon']); ?>"></i>
                            <span><?php echo htmlspecialchars($link['label']); ?></span>
                            <small><?php echo htmlspecialchars($link['badge']); ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>

            <?php if (!empty($adminLinks)): ?>
                <section class="admin-sidebar-section" data-sidebar-section>
                    <button class="admin-sidebar-section__toggle" type="button" data-sidebar-section-toggle="admin" aria-expanded="true">
                        <span class="admin-sidebar-title"><?php echo htmlspecialchars($st['administration']); ?></span>
                        <i class="fas fa-angle-down"></i>
                    </button>
                    <div class="admin-sidebar-section__body" data-sidebar-section-body="admin">
                        <?php foreach ($adminLinks as $link): ?>
                            <a class="admin-nav-link <?php echo $link['active'] ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($link['href']); ?>" data-nav-label="<?php echo htmlspecialchars($link['label']); ?>" data-tooltip="<?php echo htmlspecialchars($link['label']); ?>" title="<?php echo htmlspecialchars($link['label']); ?>">
                                <i class="fas <?php echo htmlspecialchars($link['icon']); ?>"></i>
                                <span><?php echo htmlspecialchars($link['label']); ?></span>
                                <small><?php echo htmlspecialchars($link['badge']); ?></small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <section class="admin-sidebar-section" data-sidebar-section>
                <button class="admin-sidebar-section__toggle" type="button" data-sidebar-section-toggle="workspace" aria-expanded="true">
                    <span class="admin-sidebar-title"><?php echo htmlspecialchars($st['workspace']); ?></span>
                    <i class="fas fa-angle-down"></i>
                </button>
                <div class="admin-sidebar-section__body" data-sidebar-section-body="workspace">
                    <?php foreach ($supportLinks as $link): ?>
                        <a class="admin-nav-link <?php echo !empty($link['active']) ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($link['href']); ?>" data-nav-label="<?php echo htmlspecialchars($link['label']); ?>" data-tooltip="<?php echo htmlspecialchars($link['label']); ?>" title="<?php echo htmlspecialchars($link['label']); ?>">
                            <i class="fas <?php echo htmlspecialchars($link['icon']); ?>"></i>
                            <span><?php echo htmlspecialchars($link['label']); ?></span>
                            <small><?php echo htmlspecialchars($link['badge']); ?></small>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>

            <div class="admin-sidebar-empty" data-sidebar-empty hidden><?php echo htmlspecialchars($st['filter_empty']); ?></div>
        </div>

        <div class="admin-sidebar-footer">
            <div class="admin-sidebar-footer__label"><?php echo htmlspecialchars((string)($workspaceSettings['workspace_name'] ?? 'CoreSuite Lite')); ?></div>
            <div class="admin-sidebar-footer__meta"><?php echo htmlspecialchars($st['footer_meta']); ?></div>
            <div class="admin-sidebar-footer__links">
                <a href="/profile"><?php echo htmlspecialchars($st['preferences']); ?></a>
                <?php if ($isAdmin): ?>
                    <a href="/workspace/settings"><?php echo htmlspecialchars($st['settings']); ?></a>
                <?php else: ?>
                    <a href="/search"><?php echo htmlspecialchars($st['search']); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</aside>

<div class="admin-sidebar-overlay" id="adminSidebarOverlay"></div>
