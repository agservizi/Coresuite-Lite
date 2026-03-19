<?php use Core\Auth; ?>
<?php use Core\Locale; ?>
<?php use Core\NotificationSettings; ?>
<?php use Core\RolePermissions; ?>
<?php use Core\WorkspaceSettings; ?>
<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$currentUser = null;
try {
    $currentUser = Auth::user();
} catch (\Throwable $e) {
    $currentUser = null;
}

$isAdmin = false;
$isOperator = false;
$isCustomer = false;

try {
    $isAdmin = Auth::isAdmin();
    $isOperator = Auth::isOperator();
    $isCustomer = Auth::isCustomer();
} catch (\Throwable $e) {
    $isAdmin = false;
    $isOperator = false;
    $isCustomer = false;
}

$workspaceSettings = WorkspaceSettings::all();
$notificationSettings = NotificationSettings::all();
$topbarText = [
    'it' => [
        'user_fallback' => 'Utente',
        'workspace_fallback' => 'Workspace',
        'page_fallback' => 'Dashboard',
        'overview' => 'Panoramica',
        'projects' => 'Progetti',
        'tickets' => 'Ticket',
        'documents' => 'Documenti',
        'customers' => 'Clienti',
        'reports' => 'Report',
        'audit_logs' => 'Log audit',
        'workspace_settings' => 'Impostazioni workspace',
        'notification_settings' => 'Impostazioni notifiche',
        'roles_permissions' => 'Ruoli e permessi',
        'documents_board' => 'Board documenti',
        'active_users' => 'Utenti attivi',
        'high_priorities' => 'Priorita alte',
        'open_tickets' => 'Ticket aperti',
        'in_progress' => 'In lavorazione',
        'my_documents' => 'I miei documenti',
        'open_request' => 'Apri richiesta',
        'new_ticket' => 'Nuovo ticket',
        'new_project' => 'Nuovo progetto',
        'open_projects' => 'Apri progetti',
        'open_tickets_action' => 'Apri ticket',
        'upload_document' => 'Carica documento',
        'open_customers' => 'Apri clienti',
        'open_reports' => 'Apri report',
        'manage_users' => 'Gestione utenti',
        'admin_workflow' => 'Flusso admin',
        'admin_workflow_meta' => 'Controllo operativo e governance',
        'operator_workflow' => 'Flusso operatore',
        'operator_workflow_meta' => 'Azioni rapide sul supporto',
        'customer_workspace_title' => 'Workspace cliente',
        'customer_workspace_meta' => 'Le tue attivita piu frequenti',
        'follow_up_ticket' => 'Follow-up ticket',
        'library_review' => 'Revisione libreria',
        'admin_area' => 'Area admin',
        'support' => 'Supporto',
        'admin' => 'Admin',
        'light' => 'Chiaro',
        'dark' => 'Scuro',
        'system' => 'Sistema',
        'language' => 'Lingua',
        'theme_light_meta' => 'Modalita chiara',
        'theme_dark_meta' => 'Modalita scura',
        'theme_system_meta' => 'Rilevamento automatico',
        'search_placeholder' => 'Cerca progetti, ticket, clienti, documenti...',
        'search_aria' => 'Cerca in workspace',
        'search_status' => 'Digita almeno 2 caratteri per cercare nel workspace.',
        'quick_nav' => 'Navigazione rapida',
        'toggle_menu' => 'Apri o chiudi menu',
        'new' => 'Nuovo',
        'notif_inbox' => 'Centro notifiche',
        'notif_active' => 'attive',
        'notif_filter_all' => 'Tutte',
        'notif_filter_unread' => 'Non lette',
        'notif_mark_all_read' => 'Segna tutto come letto',
        'notif_empty_all' => 'Nessuna notifica disponibile.',
        'notif_empty_unread' => 'Nessuna notifica non letta.',
        'notif_toggle_empty' => 'Centro notifiche, nessuna notifica non letta',
        'notif_toggle_count' => 'Centro notifiche, {count} non lette',
        'theme' => 'Tema',
        'personal_area' => 'Area personale',
        'logout' => 'Logout',
        'recent_searches' => 'Ricerche recenti',
        'recent_searches_meta' => 'Ultime ricerche del workspace',
        'quick_actions' => 'Azioni rapide',
        'quick_actions_meta' => 'Operazioni frequenti',
        'pinned_actions' => 'Azioni fissate',
        'pinned_actions_meta' => 'Le tue scorciatoie personali',
        'open_results' => 'Apri risultati completi',
        'pin_action' => 'Fissa azione',
        'notif_workspace_title' => 'Workspace attivo',
        'notif_workspace_text' => 'Panoramica aggiornata e shell pronta per il lavoro.',
        'notif_tickets_text' => 'Controlla i ticket aperti e le priorita alte.',
        'notif_library_text' => 'Apri l archivio documentale con filtri persistenti.',
        'notif_admin_text' => 'Verifica utenti attivi, ruoli e accessi del workspace.',
    ],
    'en' => [
        'user_fallback' => 'User',
        'workspace_fallback' => 'Workspace',
        'page_fallback' => 'Dashboard',
        'overview' => 'Overview',
        'projects' => 'Projects',
        'tickets' => 'Tickets',
        'documents' => 'Documents',
        'customers' => 'Customers',
        'reports' => 'Reports',
        'audit_logs' => 'Audit logs',
        'workspace_settings' => 'Workspace settings',
        'notification_settings' => 'Notification settings',
        'roles_permissions' => 'Roles & permissions',
        'documents_board' => 'Documents board',
        'active_users' => 'Active users',
        'high_priorities' => 'High priorities',
        'open_tickets' => 'Open tickets',
        'in_progress' => 'In progress',
        'my_documents' => 'My documents',
        'open_request' => 'Open request',
        'new_ticket' => 'New ticket',
        'new_project' => 'New project',
        'open_projects' => 'Open projects',
        'open_tickets_action' => 'Open tickets',
        'upload_document' => 'Upload document',
        'open_customers' => 'Open customers',
        'open_reports' => 'Open reports',
        'manage_users' => 'User management',
        'admin_workflow' => 'Admin workflow',
        'admin_workflow_meta' => 'Operational control and governance',
        'operator_workflow' => 'Operator workflow',
        'operator_workflow_meta' => 'Quick support actions',
        'customer_workspace_title' => 'Customer workspace',
        'customer_workspace_meta' => 'Your most frequent activities',
        'follow_up_ticket' => 'Ticket follow-up',
        'library_review' => 'Library review',
        'admin_area' => 'Admin area',
        'support' => 'Support',
        'admin' => 'Admin',
        'light' => 'Light',
        'dark' => 'Dark',
        'system' => 'System',
        'language' => 'Language',
        'theme_light_meta' => 'Light mode',
        'theme_dark_meta' => 'Dark mode',
        'theme_system_meta' => 'Auto detect',
        'search_placeholder' => 'Search projects, tickets, customers, documents...',
        'search_aria' => 'Search in workspace',
        'search_status' => 'Type at least 2 characters to search the workspace.',
        'quick_nav' => 'Quick navigation',
        'toggle_menu' => 'Open or close menu',
        'new' => 'New',
        'notif_inbox' => 'Notification inbox',
        'notif_active' => 'active',
        'notif_filter_all' => 'All',
        'notif_filter_unread' => 'Unread',
        'notif_mark_all_read' => 'Mark all as read',
        'notif_empty_all' => 'No notifications available.',
        'notif_empty_unread' => 'No unread notifications.',
        'notif_toggle_empty' => 'Notification inbox, no unread notifications',
        'notif_toggle_count' => 'Notification inbox, {count} unread',
        'theme' => 'Theme',
        'personal_area' => 'Personal area',
        'logout' => 'Logout',
        'recent_searches' => 'Recent searches',
        'recent_searches_meta' => 'Latest workspace searches',
        'quick_actions' => 'Quick actions',
        'quick_actions_meta' => 'Frequent operations',
        'pinned_actions' => 'Pinned actions',
        'pinned_actions_meta' => 'Your personal shortcuts',
        'open_results' => 'Open full results',
        'pin_action' => 'Pin action',
        'notif_workspace_title' => 'Workspace active',
        'notif_workspace_text' => 'Updated overview and shell ready for work.',
        'notif_tickets_text' => 'Review open tickets and high priorities.',
        'notif_library_text' => 'Open the document archive with persistent filters.',
        'notif_admin_text' => 'Review active users, roles, and workspace access.',
    ],
    'fr' => [
        'user_fallback' => 'Utilisateur',
        'workspace_fallback' => 'Workspace',
        'page_fallback' => 'Dashboard',
        'overview' => 'Vue d ensemble',
        'projects' => 'Projets',
        'tickets' => 'Tickets',
        'documents' => 'Documents',
        'customers' => 'Clients',
        'reports' => 'Rapports',
        'audit_logs' => 'Logs audit',
        'workspace_settings' => 'Parametres workspace',
        'notification_settings' => 'Parametres notifications',
        'roles_permissions' => 'Roles et permissions',
        'documents_board' => 'Board documents',
        'active_users' => 'Utilisateurs actifs',
        'high_priorities' => 'Priorites hautes',
        'open_tickets' => 'Tickets ouverts',
        'in_progress' => 'En cours',
        'my_documents' => 'Mes documents',
        'open_request' => 'Ouvrir demande',
        'new_ticket' => 'Nouveau ticket',
        'new_project' => 'Nouveau projet',
        'open_projects' => 'Ouvrir projets',
        'open_tickets_action' => 'Ouvrir tickets',
        'upload_document' => 'Televerser document',
        'open_customers' => 'Ouvrir clients',
        'open_reports' => 'Ouvrir rapports',
        'manage_users' => 'Gestion utilisateurs',
        'admin_workflow' => 'Flux admin',
        'admin_workflow_meta' => 'Controle operationnel et gouvernance',
        'operator_workflow' => 'Flux operateur',
        'operator_workflow_meta' => 'Actions rapides de support',
        'customer_workspace_title' => 'Workspace client',
        'customer_workspace_meta' => 'Vos activites les plus frequentes',
        'follow_up_ticket' => 'Suivi ticket',
        'library_review' => 'Revision bibliotheque',
        'admin_area' => 'Zone admin',
        'support' => 'Support',
        'admin' => 'Admin',
        'light' => 'Clair',
        'dark' => 'Sombre',
        'system' => 'Systeme',
        'language' => 'Langue',
        'theme_light_meta' => 'Mode clair',
        'theme_dark_meta' => 'Mode sombre',
        'theme_system_meta' => 'Detection automatique',
        'search_placeholder' => 'Rechercher projets, tickets, clients, documents...',
        'search_aria' => 'Rechercher dans le workspace',
        'search_status' => 'Tapez au moins 2 caracteres pour rechercher dans le workspace.',
        'quick_nav' => 'Navigation rapide',
        'toggle_menu' => 'Ouvrir ou fermer le menu',
        'new' => 'Nouveau',
        'notif_inbox' => 'Inbox notifications',
        'notif_active' => 'actives',
        'notif_filter_all' => 'Toutes',
        'notif_filter_unread' => 'Non lues',
        'notif_mark_all_read' => 'Tout marquer comme lu',
        'notif_empty_all' => 'Aucune notification disponible.',
        'notif_empty_unread' => 'Aucune notification non lue.',
        'notif_toggle_empty' => 'Inbox notifications, aucune notification non lue',
        'notif_toggle_count' => 'Inbox notifications, {count} non lues',
        'theme' => 'Theme',
        'personal_area' => 'Espace personnel',
        'logout' => 'Deconnexion',
        'recent_searches' => 'Recherches recentes',
        'recent_searches_meta' => 'Dernieres recherches du workspace',
        'quick_actions' => 'Actions rapides',
        'quick_actions_meta' => 'Operations frequentes',
        'pinned_actions' => 'Actions epinglees',
        'pinned_actions_meta' => 'Vos raccourcis personnels',
        'open_results' => 'Ouvrir les resultats complets',
        'pin_action' => 'Epingler action',
        'notif_workspace_title' => 'Workspace actif',
        'notif_workspace_text' => 'Vue d ensemble mise a jour et shell prete pour le travail.',
        'notif_tickets_text' => 'Controlez les tickets ouverts et les priorites hautes.',
        'notif_library_text' => 'Ouvrez l archive documentaire avec des filtres persistants.',
        'notif_admin_text' => 'Verifiez utilisateurs actifs, roles et acces du workspace.',
    ],
    'es' => [
        'user_fallback' => 'Usuario',
        'workspace_fallback' => 'Workspace',
        'page_fallback' => 'Dashboard',
        'overview' => 'Resumen',
        'projects' => 'Proyectos',
        'tickets' => 'Tickets',
        'documents' => 'Documentos',
        'customers' => 'Clientes',
        'reports' => 'Reportes',
        'audit_logs' => 'Logs de auditoria',
        'workspace_settings' => 'Configuracion workspace',
        'notification_settings' => 'Configuracion de notificaciones',
        'roles_permissions' => 'Roles y permisos',
        'documents_board' => 'Board de documentos',
        'active_users' => 'Usuarios activos',
        'high_priorities' => 'Prioridades altas',
        'open_tickets' => 'Tickets abiertos',
        'in_progress' => 'En progreso',
        'my_documents' => 'Mis documentos',
        'open_request' => 'Abrir solicitud',
        'new_ticket' => 'Nuevo ticket',
        'new_project' => 'Nuevo proyecto',
        'open_projects' => 'Abrir proyectos',
        'open_tickets_action' => 'Abrir tickets',
        'upload_document' => 'Cargar documento',
        'open_customers' => 'Abrir clientes',
        'open_reports' => 'Abrir reportes',
        'manage_users' => 'Gestion de usuarios',
        'admin_workflow' => 'Flujo admin',
        'admin_workflow_meta' => 'Control operativo y gobernanza',
        'operator_workflow' => 'Flujo operador',
        'operator_workflow_meta' => 'Acciones rapidas de soporte',
        'customer_workspace_title' => 'Workspace cliente',
        'customer_workspace_meta' => 'Tus actividades mas frecuentes',
        'follow_up_ticket' => 'Seguimiento ticket',
        'library_review' => 'Revision de libreria',
        'admin_area' => 'Area admin',
        'support' => 'Soporte',
        'admin' => 'Admin',
        'light' => 'Claro',
        'dark' => 'Oscuro',
        'system' => 'Sistema',
        'language' => 'Idioma',
        'theme_light_meta' => 'Modo claro',
        'theme_dark_meta' => 'Modo oscuro',
        'theme_system_meta' => 'Deteccion automatica',
        'search_placeholder' => 'Buscar proyectos, tickets, clientes, documentos...',
        'search_aria' => 'Buscar en workspace',
        'search_status' => 'Escribe al menos 2 caracteres para buscar en el workspace.',
        'quick_nav' => 'Navegacion rapida',
        'toggle_menu' => 'Abrir o cerrar menu',
        'new' => 'Nuevo',
        'notif_inbox' => 'Inbox notificaciones',
        'notif_active' => 'activas',
        'notif_filter_all' => 'Todas',
        'notif_filter_unread' => 'No leidas',
        'notif_mark_all_read' => 'Marcar todo como leido',
        'notif_empty_all' => 'No hay notificaciones disponibles.',
        'notif_empty_unread' => 'No hay notificaciones sin leer.',
        'notif_toggle_empty' => 'Inbox notificaciones, no hay notificaciones sin leer',
        'notif_toggle_count' => 'Inbox notificaciones, {count} sin leer',
        'theme' => 'Tema',
        'personal_area' => 'Area personal',
        'logout' => 'Cerrar sesion',
        'recent_searches' => 'Busquedas recientes',
        'recent_searches_meta' => 'Ultimas busquedas del workspace',
        'quick_actions' => 'Acciones rapidas',
        'quick_actions_meta' => 'Operaciones frecuentes',
        'pinned_actions' => 'Acciones fijadas',
        'pinned_actions_meta' => 'Tus accesos directos personales',
        'open_results' => 'Abrir resultados completos',
        'pin_action' => 'Fijar accion',
        'notif_workspace_title' => 'Workspace activo',
        'notif_workspace_text' => 'Resumen actualizado y shell lista para trabajar.',
        'notif_tickets_text' => 'Revisa tickets abiertos y prioridades altas.',
        'notif_library_text' => 'Abre el archivo documental con filtros persistentes.',
        'notif_admin_text' => 'Revisa usuarios activos, roles y accesos del workspace.',
    ],
];
$tt = $topbarText[Locale::current()] ?? $topbarText['it'];
$customersEnabled = !$isCustomer && !empty($workspaceSettings['customers_enabled']) && RolePermissions::canCurrent('customers_view');
$reportsEnabled = !$isCustomer && !empty($workspaceSettings['reports_enabled']) && RolePermissions::canCurrent('reports_view');
$auditLogsEnabled = !$isCustomer && !empty($workspaceSettings['audit_logs_enabled']) && RolePermissions::canCurrent('audit_logs_view');
$documentsBoardEnabled = !empty($workspaceSettings['documents_board_enabled']);
$spotlightHintsEnabled = !empty($workspaceSettings['spotlight_hints_enabled']);

$displayName = $currentUser['name'] ?? $tt['user_fallback'];
$roleLabel = ucfirst((string)($currentUser['role'] ?? 'member'));
$workspaceLabel = trim((string)($workspaceSettings['workspace_name'] ?? ($currentUser['name'] ?? $tt['workspace_fallback'])));
$todayLabel = Locale::formatDate(date('Y-m-d'));
$pageTitleValue = trim((string)($pageTitle ?? $tt['page_fallback']));
$localeOptions = Locale::supported();
$localeLabel = Locale::currentLabel();

$navItems = [
    ['href' => '/dashboard', 'label' => $tt['overview'], 'icon' => 'fa-gauge-high', 'match' => '/dashboard'],
];

if (RolePermissions::canCurrent('projects_view')) {
    $navItems[] = ['href' => '/projects', 'label' => $tt['projects'], 'icon' => 'fa-diagram-project', 'match' => '/projects'];
}

$navItems = array_merge($navItems, [
    ['href' => '/tickets', 'label' => $tt['tickets'], 'icon' => 'fa-ticket-alt', 'match' => '/tickets'],
    ['href' => '/documents', 'label' => $tt['documents'], 'icon' => 'fa-file-lines', 'match' => '/documents'],
]);

if ($customersEnabled) {
    $navItems[] = ['href' => '/customers', 'label' => $tt['customers'], 'icon' => 'fa-address-card', 'match' => '/customers'];
}
if ($reportsEnabled) {
    $navItems[] = ['href' => '/reports', 'label' => $tt['reports'], 'icon' => 'fa-chart-column', 'match' => '/reports'];
}

$activeSectionLabel = $tt['overview'];
foreach ($navItems as $navItem) {
    if (strpos($currentPath, $navItem['match']) === 0) {
        $activeSectionLabel = $navItem['label'];
        break;
    }
}

$searchParam = (string)($_GET['q'] ?? '');
$quickActions = [];

if ($isCustomer) {
    if (RolePermissions::canCurrent('projects_view')) {
        $quickActions[] = ['id' => 'customer-projects', 'href' => '/projects', 'label' => $tt['open_projects'], 'icon' => 'fa-diagram-project'];
    }
    if (RolePermissions::canCurrent('tickets_create')) {
        $quickActions[] = ['id' => 'new-ticket', 'href' => '/tickets/create', 'label' => $tt['new_ticket'], 'icon' => 'fa-plus-circle'];
    }
} else {
    $quickActions[] = ['id' => 'open-tickets', 'href' => '/tickets', 'label' => $tt['open_tickets_action'], 'icon' => 'fa-ticket-alt'];
    if (RolePermissions::canCurrent('projects_view')) {
        $quickActions[] = ['id' => 'open-projects', 'href' => '/projects', 'label' => $tt['open_projects'], 'icon' => 'fa-diagram-project'];
    }
    if (RolePermissions::canCurrent('projects_manage')) {
        $quickActions[] = ['id' => 'new-project', 'href' => '/projects/create', 'label' => $tt['new_project'], 'icon' => 'fa-plus-circle'];
    }
}

if ($isAdmin || $isOperator) {
    if (RolePermissions::canCurrent('documents_upload')) {
        $quickActions[] = ['id' => 'upload-document', 'href' => '/documents/upload', 'label' => $tt['upload_document'], 'icon' => 'fa-cloud-arrow-up'];
    }
    if ($customersEnabled) {
        $quickActions[] = ['id' => 'open-customers', 'href' => '/customers', 'label' => $tt['open_customers'], 'icon' => 'fa-address-card'];
    }
    if ($reportsEnabled) {
        $quickActions[] = ['id' => 'open-reports', 'href' => '/reports', 'label' => $tt['open_reports'], 'icon' => 'fa-chart-column'];
    }
    if ($auditLogsEnabled) {
        $quickActions[] = ['id' => 'open-audit-logs', 'href' => '/audit-logs', 'label' => $tt['audit_logs'], 'icon' => 'fa-shield-alt'];
    }
}

if ($isAdmin && RolePermissions::canCurrent('users_manage')) {
    $quickActions[] = ['id' => 'manage-users', 'href' => '/admin/users', 'label' => $tt['manage_users'], 'icon' => 'fa-users-cog'];
}
if ($isAdmin && RolePermissions::canCurrent('workspace_settings_view')) {
    $quickActions[] = ['id' => 'workspace-settings', 'href' => '/workspace/settings', 'label' => $tt['workspace_settings'], 'icon' => 'fa-sliders'];
}
if ($isAdmin && RolePermissions::canCurrent('notification_settings_view')) {
    $quickActions[] = ['id' => 'notification-settings', 'href' => '/workspace/notifications', 'label' => $tt['notification_settings'], 'icon' => 'fa-bell'];
}
if ($isAdmin && RolePermissions::canCurrent('roles_permissions_view')) {
    $quickActions[] = ['id' => 'roles-permissions', 'href' => '/admin/roles-permissions', 'label' => $tt['roles_permissions'], 'icon' => 'fa-user-lock'];
}

$contextSections = [];
if ($isAdmin) {
    $contextSections = [
        [
            'title' => $tt['admin_workflow'],
            'meta' => $tt['admin_workflow_meta'],
            'items' => [
                ['id' => 'admin-users', 'href' => '/admin/users?status=active', 'label' => $tt['active_users'], 'icon' => 'fa-user-check'],
                ['id' => 'admin-tickets', 'href' => '/tickets?priority=high', 'label' => $tt['high_priorities'], 'icon' => 'fa-bolt'],
                ['id' => 'admin-documents', 'href' => $documentsBoardEnabled ? '/documents/board' : '/documents', 'label' => $documentsBoardEnabled ? $tt['documents_board'] : $tt['documents'], 'icon' => 'fa-table-columns'],
            ],
        ],
    ];
} elseif ($isOperator) {
    $operatorItems = [
        ['id' => 'operator-open', 'href' => '/tickets?status=open', 'label' => $tt['open_tickets'], 'icon' => 'fa-life-ring'],
        ['id' => 'operator-progress', 'href' => '/tickets?status=in_progress', 'label' => $tt['in_progress'], 'icon' => 'fa-spinner'],
    ];
    if (RolePermissions::canCurrent('documents_upload')) {
        $operatorItems[] = ['id' => 'operator-upload', 'href' => '/documents/upload', 'label' => $tt['upload_document'], 'icon' => 'fa-cloud-arrow-up'];
    }
    $contextSections = [
        [
            'title' => $tt['operator_workflow'],
            'meta' => $tt['operator_workflow_meta'],
            'items' => $operatorItems,
        ],
    ];
} elseif ($isCustomer) {
    $customerItems = [
        ['id' => 'customer-open-tickets', 'href' => '/tickets?status=open', 'label' => $tt['open_tickets'], 'icon' => 'fa-ticket-alt'],
        ['id' => 'customer-documents', 'href' => '/documents', 'label' => $tt['my_documents'], 'icon' => 'fa-file-lines'],
    ];
    if (RolePermissions::canCurrent('tickets_create')) {
        array_unshift($customerItems, ['id' => 'customer-new-ticket', 'href' => '/tickets/create', 'label' => $tt['open_request'], 'icon' => 'fa-plus-circle']);
    }
    $contextSections = [
        [
            'title' => $tt['customer_workspace_title'],
            'meta' => $tt['customer_workspace_meta'],
            'items' => $customerItems,
        ],
    ];
}

$notifications = [];
if (!empty($notificationSettings['in_app_workspace_updates'])) {
    $notifications[] = ['href' => '/dashboard', 'icon' => 'fa-bolt', 'tone' => 'info', 'title' => $tt['notif_workspace_title'], 'text' => $tt['notif_workspace_text'], 'meta' => $todayLabel];
}
if (!empty($notificationSettings['in_app_ticket_activity'])) {
    $notifications[] = ['href' => '/tickets', 'icon' => 'fa-ticket-alt', 'tone' => 'warning', 'title' => $tt['follow_up_ticket'], 'text' => $tt['notif_tickets_text'], 'meta' => $tt['support']];
}
if (!empty($notificationSettings['in_app_document_activity'])) {
    $notifications[] = ['href' => '/documents', 'icon' => 'fa-file-lines', 'tone' => 'success', 'title' => $tt['library_review'], 'text' => $tt['notif_library_text'], 'meta' => $tt['documents']];
}
if ($isAdmin && !empty($notificationSettings['in_app_admin_alerts'])) {
    $notifications[] = ['href' => '/admin/users', 'icon' => 'fa-users-cog', 'tone' => 'danger', 'title' => $tt['admin_area'], 'text' => $tt['notif_admin_text'], 'meta' => $tt['admin']];
}

$notificationCount = count($notifications);
$notificationToggleLabel = $notificationCount > 0
    ? str_replace('{count}', (string)$notificationCount, (string)$tt['notif_toggle_count'])
    : (string)$tt['notif_toggle_empty'];
?>

<header class="admin-topbar">
    <div class="admin-topbar-inner">
        <div class="admin-topbar-left">
            <button class="btn btn-sm btn-outline-secondary admin-sidebar-toggle" type="button" id="sidebarToggle" aria-label="<?php echo htmlspecialchars($tt['toggle_menu']); ?>" aria-controls="adminSidebar" aria-expanded="true">
                <i class="fas fa-bars"></i>
            </button>
            <div class="admin-topbar-context">
                <a class="admin-brand" href="/dashboard">
                    <i class="fas fa-layer-group"></i>
                    <span>CoreSuite Lite</span>
                </a>
                <div class="admin-topbar-crumbs">
                    <span class="admin-topbar-crumbs__section"><?php echo htmlspecialchars($activeSectionLabel); ?></span>
                    <span class="admin-topbar-crumbs__divider"></span>
                    <span class="admin-topbar-crumbs__page"><?php echo htmlspecialchars($pageTitleValue); ?></span>
                </div>
            </div>
        </div>

        <div class="admin-topbar-center">
            <nav class="admin-topbar-nav" aria-label="<?php echo htmlspecialchars($tt['quick_nav']); ?>">
                <?php foreach ($navItems as $navItem): ?>
                    <?php $isActive = strpos($currentPath, $navItem['match']) === 0; ?>
                    <a class="admin-topbar-link <?php echo $isActive ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($navItem['href']); ?>">
                        <i class="fas <?php echo htmlspecialchars($navItem['icon']); ?>"></i>
                        <span><?php echo htmlspecialchars($navItem['label']); ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
            <form class="admin-topbar-search" method="GET" action="/search" role="search" data-spotlight-search>
                <i class="fas fa-magnifying-glass"></i>
                <input type="search" name="q" value="<?php echo htmlspecialchars($searchParam); ?>" placeholder="<?php echo htmlspecialchars($tt['search_placeholder']); ?>" aria-label="<?php echo htmlspecialchars($tt['search_aria']); ?>" autocomplete="off" data-spotlight-input>
                <?php if ($spotlightHintsEnabled): ?>
                    <span class="admin-topbar-search__hint" aria-hidden="true"><?php echo stripos((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 'Mac') !== false ? 'Cmd K' : 'Ctrl K'; ?></span>
                <?php endif; ?>
                <div class="admin-spotlight" data-spotlight-panel hidden>
                    <div class="admin-spotlight__status" data-spotlight-status><?php echo htmlspecialchars($tt['search_status']); ?></div>
                    <div class="admin-spotlight__empty" data-spotlight-empty>
                        <div class="admin-spotlight__section" data-spotlight-pinned-section>
                            <div class="admin-spotlight__section-head">
                                <strong><?php echo htmlspecialchars($tt['pinned_actions']); ?></strong>
                                <span><?php echo htmlspecialchars($tt['pinned_actions_meta']); ?></span>
                            </div>
                            <div class="admin-spotlight__chips" data-spotlight-pinned></div>
                        </div>
                        <div class="admin-spotlight__section">
                            <div class="admin-spotlight__section-head">
                                <strong><?php echo htmlspecialchars($tt['quick_actions']); ?></strong>
                                <span><?php echo htmlspecialchars($tt['quick_actions_meta']); ?></span>
                            </div>
                            <div class="admin-spotlight__chips">
                                <?php foreach ($quickActions as $quickAction): ?>
                                    <div class="admin-spotlight__chip-row">
                                        <a class="admin-spotlight__chip" href="<?php echo htmlspecialchars($quickAction['href']); ?>" data-action-id="<?php echo htmlspecialchars($quickAction['id']); ?>" data-action-label="<?php echo htmlspecialchars($quickAction['label']); ?>" data-action-icon="<?php echo htmlspecialchars($quickAction['icon']); ?>" data-action-href="<?php echo htmlspecialchars($quickAction['href']); ?>">
                                            <i class="fas <?php echo htmlspecialchars($quickAction['icon']); ?>"></i>
                                            <span><?php echo htmlspecialchars($quickAction['label']); ?></span>
                                        </a>
                                        <button class="admin-spotlight__pin" type="button" aria-label="<?php echo htmlspecialchars($tt['pin_action']); ?>" data-action-pin="<?php echo htmlspecialchars($quickAction['id']); ?>" data-action-label="<?php echo htmlspecialchars($quickAction['label']); ?>" data-action-icon="<?php echo htmlspecialchars($quickAction['icon']); ?>" data-action-href="<?php echo htmlspecialchars($quickAction['href']); ?>">
                                            <i class="fas fa-thumbtack"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php foreach ($contextSections as $section): ?>
                            <div class="admin-spotlight__section">
                                <div class="admin-spotlight__section-head">
                                    <strong><?php echo htmlspecialchars((string)$section['title']); ?></strong>
                                    <span><?php echo htmlspecialchars((string)$section['meta']); ?></span>
                                </div>
                                <div class="admin-spotlight__chips">
                                    <?php foreach ((array)$section['items'] as $sectionItem): ?>
                                        <a class="admin-spotlight__chip admin-spotlight__chip--context" href="<?php echo htmlspecialchars((string)$sectionItem['href']); ?>">
                                            <i class="fas <?php echo htmlspecialchars((string)$sectionItem['icon']); ?>"></i>
                                            <span><?php echo htmlspecialchars((string)$sectionItem['label']); ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="admin-spotlight__section">
                            <div class="admin-spotlight__section-head">
                                <strong><?php echo htmlspecialchars($tt['recent_searches']); ?></strong>
                                <span><?php echo htmlspecialchars($tt['recent_searches_meta']); ?></span>
                            </div>
                            <div class="admin-spotlight__recent" data-spotlight-recent></div>
                        </div>
                    </div>
                    <div class="admin-spotlight__results" data-spotlight-results></div>
                    <a class="admin-spotlight__footer" href="/search" data-spotlight-footer hidden><?php echo htmlspecialchars($tt['open_results']); ?></a>
                </div>
            </form>
        </div>

        <div class="admin-topbar-right">
            <div class="admin-topbar-pulse">
                <span class="admin-topbar-pulse__dot"></span>
                <span><?php echo htmlspecialchars($roleLabel); ?></span>
                <span class="admin-topbar-pulse__divider"></span>
                <span><?php echo htmlspecialchars($todayLabel); ?></span>
            </div>
            <div class="dropdown admin-topbar-dropdown">
                <button class="btn btn-sm btn-outline-secondary admin-topbar-action admin-topbar-action--primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" type="button">
                    <i class="fas fa-plus"></i>
                    <span class="d-none d-md-inline"><?php echo htmlspecialchars($tt['new']); ?></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end admin-topbar-menu admin-topbar-menu--action-panel">
                    <div class="admin-topbar-menu__head">
                        <strong><?php echo htmlspecialchars($tt['new']); ?></strong>
                        <span><?php echo htmlspecialchars($tt['quick_actions_meta']); ?></span>
                    </div>
                    <div class="admin-topbar-menu__grid">
                        <?php foreach ($quickActions as $quickAction): ?>
                            <a class="admin-topbar-menu__item" href="<?php echo htmlspecialchars($quickAction['href']); ?>">
                                <i class="fas <?php echo htmlspecialchars($quickAction['icon']); ?>"></i>
                                <span><?php echo htmlspecialchars($quickAction['label']); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="dropdown admin-topbar-dropdown">
                <button class="btn btn-sm btn-outline-secondary admin-topbar-action admin-topbar-notify dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" type="button" aria-haspopup="true" aria-label="<?php echo htmlspecialchars($notificationToggleLabel); ?>" data-notification-toggle data-aria-empty-label="<?php echo htmlspecialchars($tt['notif_toggle_empty']); ?>" data-aria-count-template="<?php echo htmlspecialchars($tt['notif_toggle_count']); ?>">
                    <i class="fas fa-bell"></i>
                    <span class="admin-topbar-notify__badge"><?php echo $notificationCount; ?></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end admin-topbar-menu admin-topbar-menu--notifications" data-live-notification-source="topbar">
                    <div class="admin-topbar-menu__head">
                        <strong><?php echo htmlspecialchars($tt['notif_inbox']); ?></strong>
                        <span data-topbar-notification-summary data-count-label="<?php echo htmlspecialchars($tt['notif_active']); ?>"><?php echo $notificationCount; ?> <?php echo htmlspecialchars($tt['notif_active']); ?></span>
                    </div>
                    <div
                        class="admin-topbar-notification-toolbar"
                        data-topbar-notification-toolbar
                        data-empty-all="<?php echo htmlspecialchars($tt['notif_empty_all']); ?>"
                        data-empty-unread="<?php echo htmlspecialchars($tt['notif_empty_unread']); ?>"
                    >
                        <div class="admin-topbar-notification-filters" role="tablist" aria-label="<?php echo htmlspecialchars($tt['notif_inbox']); ?>">
                            <button class="admin-topbar-notification-filter is-active" type="button" data-notification-filter="all" aria-pressed="true"><?php echo htmlspecialchars($tt['notif_filter_all']); ?></button>
                            <button class="admin-topbar-notification-filter" type="button" data-notification-filter="unread" aria-pressed="false"><?php echo htmlspecialchars($tt['notif_filter_unread']); ?></button>
                        </div>
                        <button class="admin-topbar-notification-markread" type="button" data-notification-mark-all><?php echo htmlspecialchars($tt['notif_mark_all_read']); ?></button>
                    </div>
                    <div class="admin-topbar-menu__list" data-topbar-notification-list>
                        <?php foreach ($notifications as $notification): ?>
                            <a
                                class="admin-topbar-notification is-<?php echo htmlspecialchars((string)($notification['tone'] ?? 'info')); ?>"
                                href="<?php echo htmlspecialchars($notification['href']); ?>"
                                data-live-notification
                                data-notification-item
                                data-notification-source="topbar"
                                data-notification-key="<?php echo htmlspecialchars(md5((string)$notification['href'] . '|' . (string)$notification['title'] . '|' . (string)$notification['meta'])); ?>"
                                data-notification-tone="<?php echo htmlspecialchars((string)($notification['tone'] ?? 'info')); ?>"
                                data-notification-icon="<?php echo htmlspecialchars((string)$notification['icon']); ?>"
                                data-notification-title="<?php echo htmlspecialchars((string)$notification['title']); ?>"
                                data-notification-message="<?php echo htmlspecialchars((string)$notification['text']); ?>"
                                data-notification-meta="<?php echo htmlspecialchars((string)$notification['meta']); ?>"
                                data-notification-href="<?php echo htmlspecialchars((string)$notification['href']); ?>"
                            >
                                <span class="admin-topbar-notification__icon"><i class="fas <?php echo htmlspecialchars($notification['icon']); ?>"></i></span>
                                <span class="admin-topbar-notification__content">
                                    <span class="admin-topbar-notification__status-dot" aria-hidden="true"></span>
                                    <strong><?php echo htmlspecialchars($notification['title']); ?></strong>
                                    <span><?php echo htmlspecialchars($notification['text']); ?></span>
                                    <small><?php echo htmlspecialchars($notification['meta']); ?></small>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <div class="admin-topbar-notification-empty" data-topbar-notification-empty hidden><?php echo htmlspecialchars($tt['notif_empty_all']); ?></div>
                </div>
            </div>
            <div class="dropdown admin-topbar-dropdown">
                <button class="btn btn-sm btn-outline-secondary admin-topbar-action admin-topbar-action--circle admin-topbar-action--locale dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" type="button" aria-label="<?php echo htmlspecialchars($tt['language']); ?>">
                    <span class="admin-topbar-action__circle-copy"><?php echo htmlspecialchars(strtoupper(Locale::current())); ?></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end admin-topbar-menu admin-topbar-menu--selector admin-topbar-menu--compact-selector">
                    <div class="admin-topbar-menu__head">
                        <strong><?php echo htmlspecialchars($tt['language']); ?></strong>
                        <span><?php echo htmlspecialchars($localeLabel); ?></span>
                    </div>
                    <div class="admin-topbar-menu__selector-grid">
                        <?php foreach ($localeOptions as $localeCode => $localeName): ?>
                            <a class="admin-topbar-menu__selector<?php echo Locale::current() === $localeCode ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars(Locale::switchUrl($localeCode, $_SERVER['REQUEST_URI'] ?? '/dashboard')); ?>">
                                <span class="admin-topbar-menu__selector-chip"><?php echo htmlspecialchars(strtoupper($localeCode)); ?></span>
                                <span class="admin-topbar-menu__selector-copy">
                                    <span class="admin-topbar-menu__selector-main"><?php echo htmlspecialchars($localeName); ?></span>
                                    <span class="admin-topbar-menu__selector-meta"><?php echo htmlspecialchars(strtoupper($localeCode)); ?></span>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="dropdown admin-topbar-dropdown">
                <button class="btn btn-sm btn-outline-secondary admin-topbar-action admin-topbar-action--circle dropdown-toggle" id="themeDropdown" data-bs-toggle="dropdown" aria-expanded="false" type="button" aria-label="<?php echo htmlspecialchars($tt['theme']); ?>">
                    <i class="fas fa-sun" id="themeIcon"></i>
                    <span class="visually-hidden" id="themeCurrentLabel"><?php echo htmlspecialchars($tt['system']); ?></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end admin-topbar-menu admin-topbar-menu--selector admin-topbar-menu--compact-selector" aria-labelledby="themeDropdown">
                    <div class="admin-topbar-menu__head">
                        <strong><?php echo htmlspecialchars($tt['theme']); ?></strong>
                        <span><?php echo htmlspecialchars($tt['system']); ?></span>
                    </div>
                    <div class="admin-topbar-menu__selector-grid">
                        <a class="admin-topbar-menu__selector admin-topbar-menu__selector--theme" href="#" data-theme="light" data-theme-label="<?php echo htmlspecialchars($tt['light']); ?>">
                            <span class="admin-topbar-menu__selector-chip"><i class="fas fa-sun"></i></span>
                            <span class="admin-topbar-menu__selector-copy">
                                <span class="admin-topbar-menu__selector-main"><?php echo htmlspecialchars($tt['light']); ?></span>
                                <span class="admin-topbar-menu__selector-meta"><?php echo htmlspecialchars($tt['theme_light_meta']); ?></span>
                            </span>
                        </a>
                        <a class="admin-topbar-menu__selector admin-topbar-menu__selector--theme" href="#" data-theme="dark" data-theme-label="<?php echo htmlspecialchars($tt['dark']); ?>">
                            <span class="admin-topbar-menu__selector-chip"><i class="fas fa-moon"></i></span>
                            <span class="admin-topbar-menu__selector-copy">
                                <span class="admin-topbar-menu__selector-main"><?php echo htmlspecialchars($tt['dark']); ?></span>
                                <span class="admin-topbar-menu__selector-meta"><?php echo htmlspecialchars($tt['theme_dark_meta']); ?></span>
                            </span>
                        </a>
                        <a class="admin-topbar-menu__selector admin-topbar-menu__selector--theme" href="#" data-theme="system" data-theme-label="<?php echo htmlspecialchars($tt['system']); ?>">
                            <span class="admin-topbar-menu__selector-chip"><i class="fas fa-desktop"></i></span>
                            <span class="admin-topbar-menu__selector-copy">
                                <span class="admin-topbar-menu__selector-main"><?php echo htmlspecialchars($tt['system']); ?></span>
                                <span class="admin-topbar-menu__selector-meta"><?php echo htmlspecialchars($tt['theme_system_meta']); ?></span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown admin-topbar-dropdown">
                <button class="btn btn-sm btn-outline-secondary admin-topbar-profile dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" type="button">
                    <span class="admin-topbar-profile__avatar"><?php echo htmlspecialchars(strtoupper(substr($displayName, 0, 1))); ?></span>
                    <span class="admin-topbar-profile__meta">
                        <strong><?php echo htmlspecialchars($displayName); ?></strong>
                        <small><?php echo htmlspecialchars($workspaceLabel); ?></small>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end admin-topbar-menu admin-topbar-menu--profile">
                    <div class="admin-topbar-menu__profile-head">
                        <span class="admin-topbar-menu__profile-avatar"><?php echo htmlspecialchars(strtoupper(substr($displayName, 0, 1))); ?></span>
                        <div class="admin-topbar-menu__profile-meta">
                            <strong><?php echo htmlspecialchars($displayName); ?></strong>
                            <span><?php echo htmlspecialchars($workspaceLabel); ?></span>
                        </div>
                    </div>
                    <div class="admin-topbar-menu__stack">
                        <a class="admin-topbar-menu__selector" href="/profile">
                            <span class="admin-topbar-menu__selector-main"><?php echo htmlspecialchars($tt['personal_area']); ?></span>
                            <span class="admin-topbar-menu__selector-meta"><?php echo htmlspecialchars($roleLabel); ?></span>
                        </a>
                        <?php if ($isAdmin && RolePermissions::canCurrent('workspace_settings_view')): ?><a class="admin-topbar-menu__selector" href="/workspace/settings"><span class="admin-topbar-menu__selector-main"><?php echo htmlspecialchars($tt['workspace_settings']); ?></span><span class="admin-topbar-menu__selector-meta"><?php echo htmlspecialchars($workspaceLabel); ?></span></a><?php endif; ?>
                        <?php if ($isAdmin && RolePermissions::canCurrent('notification_settings_view')): ?><a class="admin-topbar-menu__selector" href="/workspace/notifications"><span class="admin-topbar-menu__selector-main"><?php echo htmlspecialchars($tt['notification_settings']); ?></span><span class="admin-topbar-menu__selector-meta"><?php echo htmlspecialchars($tt['notif_inbox']); ?></span></a><?php endif; ?>
                        <?php if ($isAdmin && RolePermissions::canCurrent('roles_permissions_view')): ?><a class="admin-topbar-menu__selector" href="/admin/roles-permissions"><span class="admin-topbar-menu__selector-main"><?php echo htmlspecialchars($tt['roles_permissions']); ?></span><span class="admin-topbar-menu__selector-meta"><?php echo htmlspecialchars($tt['admin']); ?></span></a><?php endif; ?>
                    </div>
                    <div class="admin-topbar-menu__footer-action">
                        <a class="admin-topbar-menu__logout" href="/logout"><?php echo htmlspecialchars($tt['logout']); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
