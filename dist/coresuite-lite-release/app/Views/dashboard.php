<?php

use Core\Auth;
use Core\Locale;
use Core\RolePermissions;

$pageTitle = 'Dashboard';
$locale = Locale::current();

$dashboardText = [
    'it' => [
        'page_title' => 'Dashboard',
        'team' => 'Team',
        'greeting_morning' => 'Buongiorno',
        'greeting_afternoon' => 'Buon pomeriggio',
        'greeting_evening' => 'Buonasera',
        'status_labels' => ['open' => 'Aperto', 'closed' => 'Chiuso', 'in_progress' => 'In lavorazione', 'resolved' => 'Risolto'],
        'activity_labels' => ['login' => 'Login eseguito', 'logout' => 'Logout eseguito', 'create' => 'Nuovo elemento creato', 'upload' => 'Documento caricato', 'comment' => 'Nuovo commento', 'update_status' => 'Stato ticket aggiornato', 'profile_update' => 'Profilo aggiornato'],
        'kanban_columns' => ['open' => 'Aperti', 'in_progress' => 'In lavorazione', 'resolved' => 'Risolti'],
        'hero_lead' => 'Una vista piu chiara su clienti, ticket e documenti per capire al volo dove intervenire oggi.',
        'activities_monitored' => 'attivita monitorate',
        'tickets_open_pct' => 'ticket ancora aperti',
        'docs_per_customer' => 'documenti per cliente',
        'quick_actions' => 'Azioni rapide',
        'manage_tickets' => 'Gestisci ticket',
        'open_documents' => 'Apri documenti',
        'sales_hub' => 'Apri area commerciale',
        'last_30_days' => 'Aggiornamento basato sugli ultimi 30 giorni di operativita.',
        'customer_base' => 'Base clienti',
        'customers_active' => 'Clienti attivi in piattaforma',
        'request_volume' => 'Volume richieste',
        'tickets_total' => 'Ticket raccolti complessivamente',
        'to_watch' => 'Da presidiare',
        'tickets_open_now' => 'Ticket aperti in questo momento',
        'archive' => 'Archivio',
        'documents_download' => 'Documenti disponibili al download',
        'sales_focus' => 'Focus commerciale',
        'pipeline_value' => 'Valore pipeline',
        'followups_open' => 'Follow-up da presidiare',
        'operational_trend' => 'Trend operativo',
        'ticket_distribution' => 'Distribuzione ticket per stato',
        'donut_view' => 'Donut view',
        'tickets' => 'Ticket',
        'total' => 'Totale',
        'donut_empty' => 'Il donut si attivera appena saranno disponibili ticket con uno stato assegnato.',
        'snapshot' => 'Snapshot',
        'day_priority' => 'Priorita del giorno',
        'spotlight_lead' => 'La dashboard mette in evidenza carico ticket e stato dell\'archivio per aiutarti a decidere subito il prossimo passo.',
        'support_pressure' => 'Pressione supporto',
        'ticket_flow_ok' => 'Flusso ticket tracciato e aggiornato.',
        'ticket_flow_empty' => 'Ancora nessun ticket registrato.',
        'archive_ok' => 'Archivio documentale disponibile per i clienti.',
        'archive_empty' => 'Archivio documenti ancora vuoto.',
        'customer_base_ok' => 'Base clienti attiva pronta per le operazioni.',
        'customer_base_empty' => 'Nessun cliente attivo rilevato.',
        'notification_inbox' => 'Centro notifiche',
        'quick_signals' => 'Segnali rapidi',
        'items' => 'elementi',
        'no_notifications' => 'Nessuna notifica da mostrare.',
        'activity_center' => 'Centro attivita',
        'recent_workspace_events' => 'Ultimi eventi di workspace',
        'events' => 'eventi',
        'system' => 'sistema',
        'no_recent_activity' => 'Ancora nessuna attivita recente.',
        'kanban_snapshot' => 'Kanban snapshot',
        'ticket_pipeline' => 'Pipeline ticket',
        'open_full_board' => 'Apri board completa',
        'untitled' => '(senza oggetto)',
        'priority_suffix' => 'priorita',
        'no_tickets' => 'Nessun ticket',
        'customer_summary' => 'Riepilogo clienti',
        'customers_to_watch' => 'Clienti da osservare',
        'open_tickets_short' => 'aperti',
        'documents_short' => 'documenti',
        'customer_summary_wait' => 'I riepiloghi cliente compariranno appena saranno disponibili dati.',
        'customer_summary_hidden' => 'Il riepilogo clienti e nascosto dai permessi correnti.',
        'ticket_feed' => 'Flusso ticket',
        'latest_requests' => 'Ultime richieste',
        'manage_list' => 'Gestisci elenco',
        'recent_support_update' => 'Aggiornamento recente nel flusso di assistenza',
        'no_recent_tickets' => 'Nessun ticket recente da mostrare.',
        'document_hub' => 'Hub documenti',
        'latest_uploads' => 'Ultimi upload',
        'open_archive' => 'Apri archivio',
        'download' => 'Download',
        'customer_prefix' => 'Cliente: ',
        'document_available_archive' => 'Documento disponibile in archivio',
        'no_recent_documents' => 'Nessun documento caricato di recente.',
        'time_just_now' => 'Proprio ora',
        'time_minutes_ago' => '%d min fa',
        'time_hours_ago' => '%d h fa',
        'time_yesterday_at' => 'Ieri alle %s',
        'time_days_ago' => '%d gg fa',
        'time_date_format' => 'd-m-Y H:i',
        'time_clock_format' => 'H:i',
    ],
    'en' => [
        'page_title' => 'Dashboard',
        'team' => 'Team',
        'greeting_morning' => 'Good morning',
        'greeting_afternoon' => 'Good afternoon',
        'greeting_evening' => 'Good evening',
        'status_labels' => ['open' => 'Open', 'closed' => 'Closed', 'in_progress' => 'In Progress', 'resolved' => 'Resolved'],
        'activity_labels' => ['login' => 'Login completed', 'logout' => 'Logout completed', 'create' => 'New item created', 'upload' => 'Document uploaded', 'comment' => 'New comment', 'update_status' => 'Ticket status updated', 'profile_update' => 'Profile updated'],
        'kanban_columns' => ['open' => 'Open', 'in_progress' => 'In Progress', 'resolved' => 'Resolved'],
        'hero_lead' => 'A clearer view of customers, tickets and documents so you can immediately see where to act today.',
        'activities_monitored' => 'activities monitored',
        'tickets_open_pct' => 'tickets still open',
        'docs_per_customer' => 'documents per customer',
        'quick_actions' => 'Quick actions',
        'manage_tickets' => 'Manage tickets',
        'open_documents' => 'Open documents',
        'sales_hub' => 'Open sales hub',
        'last_30_days' => 'Update based on the last 30 days of activity.',
        'customer_base' => 'Customer base',
        'customers_active' => 'Active customers on the platform',
        'request_volume' => 'Request volume',
        'tickets_total' => 'Total tickets collected',
        'to_watch' => 'Needs attention',
        'tickets_open_now' => 'Tickets currently open',
        'archive' => 'Archive',
        'documents_download' => 'Documents available for download',
        'sales_focus' => 'Sales focus',
        'pipeline_value' => 'Pipeline value',
        'followups_open' => 'Follow-ups to handle',
        'operational_trend' => 'Operational trend',
        'ticket_distribution' => 'Ticket distribution by status',
        'donut_view' => 'Donut view',
        'tickets' => 'Tickets',
        'total' => 'Total',
        'donut_empty' => 'The donut will appear as soon as tickets with assigned statuses are available.',
        'snapshot' => 'Snapshot',
        'day_priority' => 'Priority for today',
        'spotlight_lead' => 'The dashboard highlights ticket load and archive status so you can decide the next step right away.',
        'support_pressure' => 'Support pressure',
        'ticket_flow_ok' => 'Ticket flow is tracked and updated.',
        'ticket_flow_empty' => 'No tickets recorded yet.',
        'archive_ok' => 'Document archive available for customers.',
        'archive_empty' => 'Document archive is still empty.',
        'customer_base_ok' => 'Active customer base ready for operations.',
        'customer_base_empty' => 'No active customers detected.',
        'notification_inbox' => 'Notification inbox',
        'quick_signals' => 'Quick signals',
        'items' => 'items',
        'no_notifications' => 'No notifications to show.',
        'activity_center' => 'Activity center',
        'recent_workspace_events' => 'Latest workspace events',
        'events' => 'events',
        'system' => 'system',
        'no_recent_activity' => 'No recent activity yet.',
        'kanban_snapshot' => 'Kanban snapshot',
        'ticket_pipeline' => 'Ticket pipeline',
        'open_full_board' => 'Open full board',
        'untitled' => '(untitled)',
        'priority_suffix' => 'priority',
        'no_tickets' => 'No tickets',
        'customer_summary' => 'Customer summary',
        'customers_to_watch' => 'Customers to watch',
        'open_tickets_short' => 'open',
        'documents_short' => 'documents',
        'customer_summary_wait' => 'Customer summaries will appear as soon as data is available.',
        'customer_summary_hidden' => 'Customer summary is hidden by current permissions.',
        'ticket_feed' => 'Ticket feed',
        'latest_requests' => 'Latest requests',
        'manage_list' => 'Manage list',
        'recent_support_update' => 'Recent update in the support workflow',
        'no_recent_tickets' => 'No recent tickets to show.',
        'document_hub' => 'Document hub',
        'latest_uploads' => 'Latest uploads',
        'open_archive' => 'Open archive',
        'download' => 'Download',
        'customer_prefix' => 'Customer: ',
        'document_available_archive' => 'Document available in archive',
        'no_recent_documents' => 'No documents uploaded recently.',
        'time_just_now' => 'Just now',
        'time_minutes_ago' => '%d min ago',
        'time_hours_ago' => '%d hr ago',
        'time_yesterday_at' => 'Yesterday at %s',
        'time_days_ago' => '%d days ago',
        'time_date_format' => 'Y-m-d g:i A',
        'time_clock_format' => 'g:i A',
    ],
    'fr' => [
        'page_title' => 'Tableau de bord',
        'team' => 'Equipe',
        'greeting_morning' => 'Bonjour',
        'greeting_afternoon' => 'Bon apres-midi',
        'greeting_evening' => 'Bonsoir',
        'status_labels' => ['open' => 'Ouvert', 'closed' => 'Ferme', 'in_progress' => 'En cours', 'resolved' => 'Resolu'],
        'activity_labels' => ['login' => 'Connexion effectuee', 'logout' => 'Deconnexion effectuee', 'create' => 'Nouvel element cree', 'upload' => 'Document televerse', 'comment' => 'Nouveau commentaire', 'update_status' => 'Statut du ticket mis a jour', 'profile_update' => 'Profil mis a jour'],
        'kanban_columns' => ['open' => 'Ouverts', 'in_progress' => 'En cours', 'resolved' => 'Resolus'],
        'hero_lead' => 'Une vue plus claire des clients, tickets et documents pour comprendre tout de suite ou intervenir aujourd hui.',
        'activities_monitored' => 'activites surveillees',
        'tickets_open_pct' => 'tickets encore ouverts',
        'docs_per_customer' => 'documents par client',
        'quick_actions' => 'Actions rapides',
        'manage_tickets' => 'Gerer les tickets',
        'open_documents' => 'Ouvrir les documents',
        'sales_hub' => 'Ouvrir hub commercial',
        'last_30_days' => 'Mise a jour basee sur les 30 derniers jours d activite.',
        'customer_base' => 'Base clients',
        'customers_active' => 'Clients actifs sur la plateforme',
        'request_volume' => 'Volume des demandes',
        'tickets_total' => 'Tickets collectes au total',
        'to_watch' => 'A surveiller',
        'tickets_open_now' => 'Tickets actuellement ouverts',
        'archive' => 'Archive',
        'documents_download' => 'Documents disponibles au telechargement',
        'sales_focus' => 'Focus commercial',
        'pipeline_value' => 'Valeur pipeline',
        'followups_open' => 'Follow-ups a traiter',
        'operational_trend' => 'Tendance operationnelle',
        'ticket_distribution' => 'Repartition des tickets par statut',
        'donut_view' => 'Vue donut',
        'tickets' => 'Tickets',
        'total' => 'Total',
        'donut_empty' => 'Le donut apparaitra des que des tickets avec un statut assigne seront disponibles.',
        'snapshot' => 'Snapshot',
        'day_priority' => 'Priorite du jour',
        'spotlight_lead' => 'Le tableau de bord met en evidence la charge ticket et l etat de l archive pour vous aider a decider tout de suite du prochain pas.',
        'support_pressure' => 'Pression support',
        'ticket_flow_ok' => 'Le flux ticket est suivi et mis a jour.',
        'ticket_flow_empty' => 'Aucun ticket enregistre pour le moment.',
        'archive_ok' => 'Archive documentaire disponible pour les clients.',
        'archive_empty' => 'Archive documentaire encore vide.',
        'customer_base_ok' => 'Base clients active prete pour les operations.',
        'customer_base_empty' => 'Aucun client actif detecte.',
        'notification_inbox' => 'Boite de notifications',
        'quick_signals' => 'Signaux rapides',
        'items' => 'elements',
        'no_notifications' => 'Aucune notification a afficher.',
        'activity_center' => 'Centre d activite',
        'recent_workspace_events' => 'Derniers evenements du workspace',
        'events' => 'evenements',
        'system' => 'systeme',
        'no_recent_activity' => 'Aucune activite recente pour le moment.',
        'kanban_snapshot' => 'Snapshot kanban',
        'ticket_pipeline' => 'Pipeline tickets',
        'open_full_board' => 'Ouvrir le board complet',
        'untitled' => '(sans objet)',
        'priority_suffix' => 'priorite',
        'no_tickets' => 'Aucun ticket',
        'customer_summary' => 'Resume clients',
        'customers_to_watch' => 'Clients a surveiller',
        'open_tickets_short' => 'ouverts',
        'documents_short' => 'documents',
        'customer_summary_wait' => 'Les resumes clients apparaitront des que les donnees seront disponibles.',
        'customer_summary_hidden' => 'Le resume clients est masque par les permissions actuelles.',
        'ticket_feed' => 'Flux tickets',
        'latest_requests' => 'Dernieres demandes',
        'manage_list' => 'Gerer la liste',
        'recent_support_update' => 'Mise a jour recente dans le flux support',
        'no_recent_tickets' => 'Aucun ticket recent a afficher.',
        'document_hub' => 'Hub documents',
        'latest_uploads' => 'Derniers televersements',
        'open_archive' => 'Ouvrir l archive',
        'download' => 'Telecharger',
        'customer_prefix' => 'Client : ',
        'document_available_archive' => 'Document disponible dans l archive',
        'no_recent_documents' => 'Aucun document televerse recemment.',
        'time_just_now' => 'A l instant',
        'time_minutes_ago' => 'il y a %d min',
        'time_hours_ago' => 'il y a %d h',
        'time_yesterday_at' => 'Hier a %s',
        'time_days_ago' => 'il y a %d j',
        'time_date_format' => 'd-m-Y H:i',
        'time_clock_format' => 'H:i',
    ],
    'es' => [
        'page_title' => 'Panel',
        'team' => 'Equipo',
        'greeting_morning' => 'Buenos dias',
        'greeting_afternoon' => 'Buenas tardes',
        'greeting_evening' => 'Buenas noches',
        'status_labels' => ['open' => 'Abierto', 'closed' => 'Cerrado', 'in_progress' => 'En curso', 'resolved' => 'Resuelto'],
        'activity_labels' => ['login' => 'Inicio de sesion completado', 'logout' => 'Cierre de sesion completado', 'create' => 'Nuevo elemento creado', 'upload' => 'Documento cargado', 'comment' => 'Nuevo comentario', 'update_status' => 'Estado del ticket actualizado', 'profile_update' => 'Perfil actualizado'],
        'kanban_columns' => ['open' => 'Abiertos', 'in_progress' => 'En curso', 'resolved' => 'Resueltos'],
        'hero_lead' => 'Una vista mas clara de clientes, tickets y documentos para entender enseguida donde intervenir hoy.',
        'activities_monitored' => 'actividades monitorizadas',
        'tickets_open_pct' => 'tickets aun abiertos',
        'docs_per_customer' => 'documentos por cliente',
        'quick_actions' => 'Acciones rapidas',
        'manage_tickets' => 'Gestionar tickets',
        'open_documents' => 'Abrir documentos',
        'sales_hub' => 'Abrir hub comercial',
        'last_30_days' => 'Actualizacion basada en los ultimos 30 dias de actividad.',
        'customer_base' => 'Base de clientes',
        'customers_active' => 'Clientes activos en la plataforma',
        'request_volume' => 'Volumen de solicitudes',
        'tickets_total' => 'Tickets recogidos en total',
        'to_watch' => 'A vigilar',
        'tickets_open_now' => 'Tickets abiertos en este momento',
        'archive' => 'Archivo',
        'documents_download' => 'Documentos disponibles para descargar',
        'sales_focus' => 'Foco comercial',
        'pipeline_value' => 'Valor pipeline',
        'followups_open' => 'Follow-ups pendientes',
        'operational_trend' => 'Tendencia operativa',
        'ticket_distribution' => 'Distribucion de tickets por estado',
        'donut_view' => 'Vista donut',
        'tickets' => 'Tickets',
        'total' => 'Total',
        'donut_empty' => 'El donut aparecera en cuanto haya tickets con un estado asignado.',
        'snapshot' => 'Snapshot',
        'day_priority' => 'Prioridad del dia',
        'spotlight_lead' => 'El panel destaca la carga de tickets y el estado del archivo para ayudarte a decidir enseguida el siguiente paso.',
        'support_pressure' => 'Presion de soporte',
        'ticket_flow_ok' => 'El flujo de tickets esta monitorizado y actualizado.',
        'ticket_flow_empty' => 'Todavia no hay tickets registrados.',
        'archive_ok' => 'Archivo documental disponible para los clientes.',
        'archive_empty' => 'El archivo documental aun esta vacio.',
        'customer_base_ok' => 'Base de clientes activa lista para operar.',
        'customer_base_empty' => 'No se detectaron clientes activos.',
        'notification_inbox' => 'Bandeja de notificaciones',
        'quick_signals' => 'Senales rapidas',
        'items' => 'elementos',
        'no_notifications' => 'No hay notificaciones para mostrar.',
        'activity_center' => 'Centro de actividad',
        'recent_workspace_events' => 'Ultimos eventos del workspace',
        'events' => 'eventos',
        'system' => 'sistema',
        'no_recent_activity' => 'Todavia no hay actividad reciente.',
        'kanban_snapshot' => 'Snapshot kanban',
        'ticket_pipeline' => 'Pipeline de tickets',
        'open_full_board' => 'Abrir tablero completo',
        'untitled' => '(sin asunto)',
        'priority_suffix' => 'prioridad',
        'no_tickets' => 'No hay tickets',
        'customer_summary' => 'Resumen de clientes',
        'customers_to_watch' => 'Clientes a vigilar',
        'open_tickets_short' => 'abiertos',
        'documents_short' => 'documentos',
        'customer_summary_wait' => 'Los resumenes de clientes apareceran en cuanto haya datos disponibles.',
        'customer_summary_hidden' => 'El resumen de clientes esta oculto por los permisos actuales.',
        'ticket_feed' => 'Feed de tickets',
        'latest_requests' => 'Ultimas solicitudes',
        'manage_list' => 'Gestionar lista',
        'recent_support_update' => 'Actualizacion reciente en el flujo de soporte',
        'no_recent_tickets' => 'No hay tickets recientes para mostrar.',
        'document_hub' => 'Hub de documentos',
        'latest_uploads' => 'Ultimas cargas',
        'open_archive' => 'Abrir archivo',
        'download' => 'Descargar',
        'customer_prefix' => 'Cliente: ',
        'document_available_archive' => 'Documento disponible en el archivo',
        'no_recent_documents' => 'No hay documentos cargados recientemente.',
        'time_just_now' => 'Ahora mismo',
        'time_minutes_ago' => 'hace %d min',
        'time_hours_ago' => 'hace %d h',
        'time_yesterday_at' => 'Ayer a las %s',
        'time_days_ago' => 'hace %d d',
        'time_date_format' => 'd-m-Y H:i',
        'time_clock_format' => 'H:i',
    ],
];

$dt = $dashboardText[$locale] ?? $dashboardText['it'];
$pageTitle = $dt['page_title'];

$formatDashboardDate = static function ($value) use ($dt) {
    $rawValue = trim((string)$value);
    if ($rawValue === '') {
        return '';
    }

    try {
        $date = new \DateTime($rawValue);
        $now = new \DateTime();
    } catch (\Throwable $e) {
        return $rawValue;
    }

    $diff = max(0, $now->getTimestamp() - $date->getTimestamp());

    if ($diff < 60) {
        return (string)$dt['time_just_now'];
    }

    if ($diff < 3600) {
        return sprintf((string)$dt['time_minutes_ago'], max(1, (int)floor($diff / 60)));
    }

    if ($diff < 86400) {
        return sprintf((string)$dt['time_hours_ago'], max(1, (int)floor($diff / 3600)));
    }

    if ($diff < 172800) {
        return sprintf((string)$dt['time_yesterday_at'], $date->format((string)$dt['time_clock_format']));
    }

    if ($diff < 604800) {
        return sprintf((string)$dt['time_days_ago'], max(2, (int)floor($diff / 86400)));
    }

    return $date->format((string)$dt['time_date_format']);
};

$customersCount = (int)($customersCount ?? 0);
$ticketsCount = (int)($ticketsCount ?? 0);
$openTicketsCount = (int)($openTicketsCount ?? 0);
$documentsCount = (int)($documentsCount ?? 0);
$salesOpenDealsCount = (int)($salesOpenDealsCount ?? 0);
$salesReminderCount = (int)($salesReminderCount ?? 0);
$salesPipelineValue = (float)($salesPipelineValue ?? 0);

$currentUser = null;
try {
    $currentUser = Auth::user();
} catch (\Throwable $e) {
    $currentUser = null;
}

$displayName = trim((string)($currentUser['name'] ?? $dt['team']));
$firstName = $displayName !== '' ? explode(' ', $displayName)[0] : $dt['team'];
$currentHour = (int)date('G');
$greeting = $currentHour < 12 ? $dt['greeting_morning'] : ($currentHour < 18 ? $dt['greeting_afternoon'] : $dt['greeting_evening']);

$ticketHealth = $ticketsCount > 0 ? (int)round(($openTicketsCount / max($ticketsCount, 1)) * 100) : 0;
$documentCoverage = $customersCount > 0 ? number_format($documentsCount / max($customersCount, 1), 1, ',', '.') : '0,0';
$activityTotal = $ticketsCount + $documentsCount;
$hasChartData = !empty(array_filter((array)($chartValues ?? []), static function ($value) {
    return (int)$value > 0;
}));

$statusLabels = $dt['status_labels'];

$statusClasses = [
    'open' => 'bg-info text-dark',
    'closed' => 'bg-success',
    'in_progress' => 'bg-warning text-dark',
    'resolved' => 'bg-primary',
];

$activityLabels = $dt['activity_labels'];

$donutColors = ['#3b82f6', '#f59e0b', '#14b8a6', '#64748b'];
$donutTotal = array_sum((array)($chartValues ?? []));
$donutSeries = [];
foreach (($chartLabels ?? []) as $index => $label) {
    $value = (int)($chartValues[$index] ?? 0);
    if ($value <= 0) {
        continue;
    }
    $donutSeries[] = [
        'name' => (string)$label,
        'y' => $value,
        'color' => $donutColors[$index] ?? '#94a3b8',
    ];
}

$kanbanColumns = [
    'open' => ['label' => $dt['kanban_columns']['open'], 'icon' => 'fa-inbox'],
    'in_progress' => ['label' => $dt['kanban_columns']['in_progress'], 'icon' => 'fa-spinner'],
    'resolved' => ['label' => $dt['kanban_columns']['resolved'], 'icon' => 'fa-circle-check'],
];

$kanbanBuckets = [
    'open' => [],
    'in_progress' => [],
    'resolved' => [],
];

foreach (($kanbanTickets ?? []) as $kanbanTicket) {
    $ticketStatus = (string)($kanbanTicket['status'] ?? 'open');
    if (!isset($kanbanBuckets[$ticketStatus])) {
        continue;
    }
    if (count($kanbanBuckets[$ticketStatus]) >= 4) {
        continue;
    }
    $kanbanBuckets[$ticketStatus][] = $kanbanTicket;
}

ob_start();
?>
<section class="dashboard-hero mb-4 dashboard-reveal" data-reveal="hero">
    <div class="dashboard-hero__content">
        <div class="dashboard-hero__eyebrow">Control center</div>
        <h2 class="dashboard-hero__title"><?php echo $greeting . ', ' . htmlspecialchars($firstName); ?></h2>
        <p class="dashboard-hero__lead"><?php echo htmlspecialchars($dt['hero_lead']); ?></p>
        <div class="dashboard-hero__metrics">
            <span class="dashboard-chip"><i class="fas fa-signal"></i><?php echo $activityTotal; ?> <?php echo htmlspecialchars($dt['activities_monitored']); ?></span>
            <span class="dashboard-chip"><i class="fas fa-life-ring"></i><?php echo $ticketHealth; ?>% <?php echo htmlspecialchars($dt['tickets_open_pct']); ?></span>
            <span class="dashboard-chip"><i class="fas fa-folder-open"></i><?php echo $documentCoverage; ?> <?php echo htmlspecialchars($dt['docs_per_customer']); ?></span>
        </div>
    </div>
    <div class="dashboard-hero__panel">
        <p class="dashboard-hero__panel-label"><?php echo htmlspecialchars($dt['quick_actions']); ?></p>
        <div class="dashboard-hero__actions">
            <a href="/tickets" class="btn btn-primary"><i class="fas fa-ticket-alt me-2"></i><?php echo htmlspecialchars($dt['manage_tickets']); ?></a>
            <a href="/documents" class="btn btn-outline-secondary"><i class="fas fa-file-alt me-2"></i><?php echo htmlspecialchars($dt['open_documents']); ?></a>
            <?php if (!Auth::isCustomer() && RolePermissions::canCurrent('sales_view')): ?>
                <a href="/sales" class="btn btn-outline-secondary"><i class="fas fa-briefcase me-2"></i><?php echo htmlspecialchars($dt['sales_hub']); ?></a>
            <?php endif; ?>
        </div>
        <div class="dashboard-hero__note">
            <span class="dashboard-hero__note-dot"></span>
            <?php echo htmlspecialchars($dt['last_30_days']); ?>
        </div>
    </div>
</section>

<div class="row g-3 mb-4 admin-kpi-grid">
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--customers h-100 dashboard-reveal dashboard-hoverlift" data-reveal="card">
            <div class="card-body">
                <div class="admin-kpi-icon"><i class="fas fa-users"></i></div>
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($dt['customer_base']); ?></div>
                <p class="admin-kpi-value"><?php echo $customersCount; ?></p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars($dt['customers_active']); ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--tickets h-100 dashboard-reveal dashboard-hoverlift" data-reveal="card">
            <div class="card-body">
                <div class="admin-kpi-icon"><i class="fas fa-ticket-alt"></i></div>
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($dt['request_volume']); ?></div>
                <p class="admin-kpi-value"><?php echo $ticketsCount; ?></p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars($dt['tickets_total']); ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--open h-100 dashboard-reveal dashboard-hoverlift" data-reveal="card">
            <div class="card-body">
                <div class="admin-kpi-icon"><i class="fas fa-life-ring"></i></div>
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($dt['to_watch']); ?></div>
                <p class="admin-kpi-value"><?php echo $openTicketsCount; ?></p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars($dt['tickets_open_now']); ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--documents h-100 dashboard-reveal dashboard-hoverlift" data-reveal="card">
            <div class="card-body">
                <div class="admin-kpi-icon"><i class="fas fa-file-alt"></i></div>
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($dt['archive']); ?></div>
                <p class="admin-kpi-value"><?php echo $documentsCount; ?></p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars($dt['documents_download']); ?></p>
            </div>
        </div>
    </div>
    <?php if (!Auth::isCustomer() && RolePermissions::canCurrent('sales_view')): ?>
        <div class="col-12 col-sm-6 col-xxl-3">
            <div class="card admin-kpi-card admin-kpi-card--customers h-100 dashboard-reveal dashboard-hoverlift" data-reveal="card">
                <div class="card-body">
                    <div class="admin-kpi-icon"><i class="fas fa-briefcase"></i></div>
                    <div class="admin-kpi-meta"><?php echo htmlspecialchars($dt['sales_focus']); ?></div>
                    <p class="admin-kpi-value"><?php echo $salesOpenDealsCount; ?></p>
                    <p class="admin-kpi-label"><?php echo htmlspecialchars($dt['followups_open']); ?>: <?php echo $salesReminderCount; ?><br><?php echo htmlspecialchars($dt['pipeline_value']); ?>: <?php echo number_format($salesPipelineValue, 0, ',', '.'); ?> EUR</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-8">
        <div class="card admin-chart-card h-100 dashboard-reveal dashboard-hoverlift" data-reveal="panel">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($dt['operational_trend']); ?></p>
                    <span><?php echo htmlspecialchars($dt['ticket_distribution']); ?></span>
                </div>
                <?php if ($hasChartData): ?>
                    <div class="dashboard-chart-legend-inline" aria-label="<?php echo htmlspecialchars($dt['ticket_distribution']); ?>">
                        <?php foreach ($donutSeries as $legendItem): ?>
                            <span class="dashboard-chart-legend-inline__item">
                                <span class="dashboard-chart-legend-inline__swatch" style="background: <?php echo htmlspecialchars((string)$legendItem['color']); ?>;"></span>
                                <span><?php echo htmlspecialchars((string)$legendItem['name']); ?></span>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="dashboard-chart-shell">
                    <?php if ($hasChartData): ?>
                        <div id="dashboardTicketDonut" class="dashboard-highcharts-donut" aria-label="<?php echo htmlspecialchars($dt['ticket_distribution']); ?>" role="img"></div>
                    <?php else: ?>
                        <div class="dashboard-chart-empty">
                            <i class="fas fa-chart-pie"></i>
                            <p class="mb-0"><?php echo htmlspecialchars($dt['donut_empty']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card dashboard-spotlight-card h-100 dashboard-reveal dashboard-hoverlift" data-reveal="panel">
            <div class="card-body">
                <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($dt['snapshot']); ?></p>
                <h3 class="dashboard-spotlight-card__title"><?php echo htmlspecialchars($dt['day_priority']); ?></h3>
                <p class="dashboard-spotlight-card__lead"><?php echo htmlspecialchars($dt['spotlight_lead']); ?></p>
                <div class="dashboard-mini-stat">
                    <span class="dashboard-mini-stat__label"><?php echo htmlspecialchars($dt['support_pressure']); ?></span>
                    <strong class="dashboard-mini-stat__value"><?php echo $ticketHealth; ?>%</strong>
                </div>
                <div class="dashboard-progress" aria-hidden="true">
                    <span style="width: <?php echo max(8, min(100, $ticketHealth)); ?>%;"></span>
                </div>
                <ul class="dashboard-insights">
                    <li><i class="fas fa-check-circle"></i><?php echo htmlspecialchars($ticketsCount > 0 ? $dt['ticket_flow_ok'] : $dt['ticket_flow_empty']); ?></li>
                    <li><i class="fas fa-folder"></i><?php echo htmlspecialchars($documentsCount > 0 ? $dt['archive_ok'] : $dt['archive_empty']); ?></li>
                    <li><i class="fas fa-users"></i><?php echo htmlspecialchars($customersCount > 0 ? $dt['customer_base_ok'] : $dt['customer_base_empty']); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-xxl-4">
        <div class="card dashboard-feed-card h-100 dashboard-reveal dashboard-hoverlift" data-reveal="panel">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($dt['notification_inbox']); ?></p>
                    <span><?php echo htmlspecialchars($dt['quick_signals']); ?></span>
                </div>
                <span class="badge rounded-pill dashboard-soft-badge" data-dashboard-notification-summary data-count-label="<?php echo htmlspecialchars($dt['items']); ?>"><?php echo count($notificationItems ?? []); ?> <?php echo htmlspecialchars($dt['items']); ?></span>
            </div>
            <div class="card-body">
                <?php if (!empty($notificationItems)): ?>
                    <div class="dashboard-notification-list" data-live-notification-source="dashboard">
                        <?php foreach ($notificationItems as $notification): ?>
                            <a
                                class="dashboard-notification-item"
                                href="<?php echo htmlspecialchars((string)$notification['href']); ?>"
                                data-live-notification
                                data-notification-source="dashboard"
                                data-notification-key="<?php echo htmlspecialchars(md5((string)$notification['href'] . '|' . (string)$notification['title'] . '|' . (string)$notification['meta'])); ?>"
                                data-notification-tone="<?php echo htmlspecialchars((string)($notification['notify_tone'] ?? 'info')); ?>"
                                data-notification-icon="<?php echo htmlspecialchars((string)$notification['icon']); ?>"
                                data-notification-title="<?php echo htmlspecialchars((string)$notification['title']); ?>"
                                data-notification-message="<?php echo htmlspecialchars((string)$notification['text']); ?>"
                                data-notification-meta="<?php echo htmlspecialchars((string)$notification['meta']); ?>"
                                data-notification-href="<?php echo htmlspecialchars((string)$notification['href']); ?>"
                            >
                                <div class="dashboard-notification-item__icon is-<?php echo htmlspecialchars((string)$notification['tone']); ?>">
                                    <i class="fas <?php echo htmlspecialchars((string)$notification['icon']); ?>"></i>
                                </div>
                                <div class="dashboard-notification-item__content">
                                    <span class="dashboard-notification-item__status-dot" aria-hidden="true"></span>
                                    <strong><?php echo htmlspecialchars((string)$notification['title']); ?></strong>
                                    <span><?php echo htmlspecialchars((string)$notification['text']); ?></span>
                                    <small><?php echo htmlspecialchars((string)$notification['meta']); ?></small>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state">
                        <i class="fas fa-bell"></i>
                        <p class="mb-0"><?php echo htmlspecialchars($dt['no_notifications']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-xxl-8">
        <div class="card dashboard-feed-card h-100 dashboard-reveal dashboard-hoverlift" data-reveal="panel">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($dt['activity_center']); ?></p>
                    <span><?php echo htmlspecialchars($dt['recent_workspace_events']); ?></span>
                </div>
                <span class="badge rounded-pill dashboard-soft-badge"><?php echo count($recentActivity ?? []); ?> <?php echo htmlspecialchars($dt['events']); ?></span>
            </div>
            <div class="card-body">
                <?php if (!empty($recentActivity)): ?>
                    <div class="dashboard-activity-stream">
                        <?php foreach ($recentActivity as $index => $activityItem): ?>
                            <?php
                            $actionKey = (string)($activityItem['action'] ?? '');
                            $entityKey = (string)($activityItem['entity'] ?? $dt['system']);
                            $entityId = (string)($activityItem['entity_id'] ?? '');
                            $activityText = $activityLabels[$actionKey] ?? ucfirst(str_replace('_', ' ', $actionKey));
                            ?>
                            <article class="dashboard-activity-item">
                                <div class="dashboard-activity-item__rail"></div>
                                <div class="dashboard-activity-item__dot"></div>
                                <div class="dashboard-activity-item__content">
                                    <strong><?php echo htmlspecialchars($activityText); ?></strong>
                                    <span><?php echo htmlspecialchars(ucfirst($entityKey)); ?><?php echo $entityId !== '' ? ' #' . htmlspecialchars($entityId) : ''; ?></span>
                                    <small><?php echo htmlspecialchars($formatDashboardDate($activityItem['created_at'] ?? '')); ?></small>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state">
                        <i class="fas fa-wave-square"></i>
                        <p class="mb-0"><?php echo htmlspecialchars($dt['no_recent_activity']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-xxl-8">
        <div class="card dashboard-feed-card h-100 dashboard-reveal dashboard-hoverlift" data-reveal="panel">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($dt['kanban_snapshot']); ?></p>
                    <span><?php echo htmlspecialchars($dt['ticket_pipeline']); ?></span>
                </div>
                <a href="/tickets" class="btn btn-sm btn-outline-secondary"><?php echo htmlspecialchars($dt['open_full_board']); ?></a>
            </div>
            <div class="card-body">
                <div class="dashboard-kanban">
                    <?php foreach ($kanbanColumns as $columnKey => $column): ?>
                        <section class="dashboard-kanban-column">
                            <header class="dashboard-kanban-column__head">
                                <span><i class="fas <?php echo htmlspecialchars((string)$column['icon']); ?> me-2"></i><?php echo htmlspecialchars((string)$column['label']); ?></span>
                                <strong><?php echo count($kanbanBuckets[$columnKey] ?? []); ?></strong>
                            </header>
                            <div class="dashboard-kanban-column__body">
                                <?php if (!empty($kanbanBuckets[$columnKey])): ?>
                                    <?php foreach ($kanbanBuckets[$columnKey] as $boardTicket): ?>
                                        <?php $priority = (string)($boardTicket['priority'] ?? 'medium'); ?>
                                        <a class="dashboard-kanban-card" href="/tickets/<?php echo (int)$boardTicket['id']; ?>">
                                            <strong>#<?php echo (int)$boardTicket['id']; ?> <?php echo htmlspecialchars((string)($boardTicket['subject'] ?? $dt['untitled'])); ?></strong>
                                            <span class="dashboard-kanban-card__meta"><?php echo htmlspecialchars($priorityLabels[$priority] ?? ucfirst($priority)); ?> <?php echo htmlspecialchars($dt['priority_suffix']); ?></span>
                                            <small><?php echo htmlspecialchars($formatDashboardDate($boardTicket['created_at'] ?? '')); ?></small>
                                        </a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="dashboard-kanban-empty"><?php echo htmlspecialchars($dt['no_tickets']); ?></div>
                                <?php endif; ?>
                            </div>
                        </section>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xxl-4">
        <div class="card dashboard-feed-card h-100 dashboard-reveal dashboard-hoverlift" data-reveal="panel">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($dt['customer_summary']); ?></p>
                    <span><?php echo htmlspecialchars($dt['customers_to_watch']); ?></span>
                </div>
            </div>
            <div class="card-body">
                <?php if (RolePermissions::canCurrent('customers_view') && !empty($customerSummaries)): ?>
                    <div class="dashboard-customer-grid">
                        <?php foreach ($customerSummaries as $summary): ?>
                            <article class="dashboard-customer-card">
                                <strong><?php echo htmlspecialchars((string)$summary['name']); ?></strong>
                                <div class="dashboard-customer-card__stats">
                                    <span><?php echo (int)($summary['tickets_total'] ?? 0); ?> ticket</span>
                                    <span><?php echo (int)($summary['tickets_open'] ?? 0); ?> <?php echo htmlspecialchars($dt['open_tickets_short']); ?></span>
                                    <span><?php echo (int)($summary['documents_total'] ?? 0); ?> <?php echo htmlspecialchars($dt['documents_short']); ?></span>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php elseif (RolePermissions::canCurrent('customers_view')): ?>
                    <div class="dashboard-empty-state">
                        <i class="fas fa-users"></i>
                        <p class="mb-0"><?php echo htmlspecialchars($dt['customer_summary_wait']); ?></p>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state">
                        <i class="fas fa-user-lock"></i>
                        <p class="mb-0"><?php echo htmlspecialchars($dt['customer_summary_hidden']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-xl-6">
        <div class="card dashboard-feed-card h-100 dashboard-reveal dashboard-hoverlift" data-reveal="panel">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($dt['ticket_feed']); ?></p>
                    <span><?php echo htmlspecialchars($dt['latest_requests']); ?></span>
                </div>
                <a href="/tickets" class="btn btn-sm btn-outline-secondary"><?php echo htmlspecialchars($dt['manage_list']); ?></a>
            </div>
            <div class="card-body">
                <?php if (!empty($latestTickets)): ?>
                    <div class="dashboard-feed">
                        <?php foreach ($latestTickets as $lt): ?>
                            <?php
                            $status = (string)($lt['status'] ?? 'open');
                            $statusLabel = $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status));
                            $statusClass = $statusClasses[$status] ?? 'bg-secondary';
                            ?>
                            <a class="dashboard-feed-item" href="/tickets/<?php echo (int)$lt['id']; ?>">
                                <div class="dashboard-feed-item__icon"><i class="fas fa-ticket-alt"></i></div>
                                <div class="dashboard-feed-item__content">
                                    <div class="dashboard-feed-item__top">
                                        <strong>#<?php echo (int)$lt['id']; ?> <?php echo htmlspecialchars((string)($lt['subject'] ?: $dt['untitled'])); ?></strong>
                                        <span class="badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($statusLabel); ?></span>
                                    </div>
                                    <span class="dashboard-feed-item__meta"><?php echo htmlspecialchars($dt['recent_support_update']); ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state">
                        <i class="fas fa-inbox"></i>
                        <p class="mb-0"><?php echo htmlspecialchars($dt['no_recent_tickets']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <div class="card dashboard-feed-card h-100 dashboard-reveal dashboard-hoverlift" data-reveal="panel">
            <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($dt['document_hub']); ?></p>
                    <span><?php echo htmlspecialchars($dt['latest_uploads']); ?></span>
                </div>
                <a href="/documents" class="btn btn-sm btn-outline-secondary"><?php echo htmlspecialchars($dt['open_archive']); ?></a>
            </div>
            <div class="card-body">
                <?php if (!empty($latestDocuments)): ?>
                    <div class="dashboard-feed">
                        <?php foreach ($latestDocuments as $ld): ?>
                            <?php $customerInfo = isset($ld['customer_name']) ? (string)$ld['customer_name'] : ''; ?>
                            <a class="dashboard-feed-item" href="/documents/<?php echo (int)$ld['id']; ?>/download">
                                <div class="dashboard-feed-item__icon dashboard-feed-item__icon--document"><i class="fas fa-file-arrow-down"></i></div>
                                <div class="dashboard-feed-item__content">
                                    <div class="dashboard-feed-item__top">
                                        <strong><?php echo htmlspecialchars((string)$ld['filename_original']); ?></strong>
                                        <span class="dashboard-link-pill"><?php echo htmlspecialchars($dt['download']); ?></span>
                                    </div>
                                    <span class="dashboard-feed-item__meta">
                                        <?php echo $customerInfo !== '' ? htmlspecialchars($dt['customer_prefix']) . htmlspecialchars($customerInfo) : htmlspecialchars($dt['document_available_archive']); ?>
                                    </span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="dashboard-empty-state">
                        <i class="fas fa-folder-open"></i>
                        <p class="mb-0"><?php echo htmlspecialchars($dt['no_recent_documents']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$dashboardDonutTotalLabel = json_encode((string)$dt['total']);
$dashboardDonutTotalValue = json_encode((string)$donutTotal);
$dashboardTicketsLabel = json_encode((string)$dt['tickets']);
$dashboardDonutSeriesJson = json_encode($donutSeries);
$content .= <<<HTML
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('dashboardTicketDonut');
    if (!container || typeof Highcharts === 'undefined') {
        return;
    }

    Highcharts.chart('dashboardTicketDonut', {
        chart: {
            type: 'pie',
            backgroundColor: 'transparent',
            spacing: [8, 8, 8, 8],
            custom: {},
            events: {
                render() {
                    const chart = this;
                    const series = chart.series[0];
                    if (!series || !series.center) {
                        return;
                    }

                    let customLabel = chart.options.chart.custom.label;
                    if (!customLabel) {
                        customLabel = chart.options.chart.custom.label = chart.renderer
                            .label(
                                '<span style="font-size:0.78em;color:var(--text-muted, #64748b);text-transform:uppercase;letter-spacing:0.12em;">' + {$dashboardDonutTotalLabel} + '</span><br/><strong style="font-size:1.55em;color:var(--accent-strong, #0b7f82);">' + {$dashboardDonutTotalValue} + '</strong><br/><span style="font-size:0.82em;color:var(--text-muted, #64748b);text-transform:uppercase;letter-spacing:0.12em;">' + {$dashboardTicketsLabel} + '</span>',
                                0,
                                0,
                                null,
                                null,
                                null,
                                true
                            )
                            .css({
                                color: 'var(--text-main, #0f172a)',
                                textAlign: 'center'
                            })
                            .attr({
                                padding: 0
                            })
                            .add();
                    }

                    customLabel.css({
                        fontSize: (series.center[2] / 12) + 'px'
                    });

                    const labelBox = customLabel.getBBox();
                    const x = series.center[0] + chart.plotLeft - (labelBox.width / 2);
                    const y = series.center[1] + chart.plotTop - (labelBox.height / 2) + 2;

                    customLabel.attr({ x, y });
                }
            }
        },
        title: { text: null },
        subtitle: { text: null },
        credits: { enabled: false },
        accessibility: {
            enabled: false
        },
        legend: { enabled: false },
        tooltip: {
            pointFormat: '<span style="color:{point.color}">\u25cf</span> {point.name}: <b>{point.y}</b> ({point.percentage:.0f}%)'
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                borderRadius: 8,
                borderWidth: 0,
                dataLabels: [{
                    enabled: true,
                    distance: 18,
                    format: '{point.name}',
                    style: {
                        fontSize: '0.86em',
                        fontWeight: '600',
                        color: 'var(--text-main, #0f172a)',
                        textOutline: 'none'
                    }
                }, {
                    enabled: true,
                    distance: -15,
                    format: '{point.percentage:.0f}%',
                    style: {
                        fontSize: '0.86em',
                        color: '#ffffff',
                        fontWeight: '700',
                        textOutline: 'none'
                    }
                }],
                showInLegend: false
            }
        },
        series: [{
            name: {$dashboardTicketsLabel},
            colorByPoint: false,
            innerSize: '75%',
            data: {$dashboardDonutSeriesJson}
        }]
    });
});
</script>
HTML;

include __DIR__ . '/layout.php';
