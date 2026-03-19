<?php
use Core\Auth;
use Core\Locale;
use Core\RolePermissions;

$locale = Locale::current();
$ticketsText = [
    'it' => [
        'page_title' => 'Tickets',
        'status_labels' => ['open' => 'Aperto', 'in_progress' => 'In lavorazione', 'resolved' => 'Risolto', 'closed' => 'Chiuso'],
        'priority_labels' => ['low' => 'Bassa', 'medium' => 'Media', 'high' => 'Alta'],
        'hero_title' => 'Gestisci il flusso ticket con piu chiarezza',
        'hero_lead' => 'Una vista unica per capire carico operativo, priorita attive e interventi da aprire subito.',
        'open_kanban' => 'Apri board kanban',
        'new_ticket' => 'Nuovo ticket',
        'export_csv' => 'Esporta CSV',
        'high_priority' => 'priorita alte',
        'visible_total' => 'Totale visibile',
        'tickets_in_list' => 'ticket in elenco',
        'open_label' => 'Aperti',
        'open_meta' => 'nuove richieste da presidiare',
        'in_progress_label' => 'In lavorazione',
        'in_progress_meta' => 'ticket attualmente in gestione',
        'closed_or_resolved' => 'Chiusi o risolti',
        'closed_meta' => 'esiti completati nel dataset corrente',
        'ticket_board' => 'Ticket board',
        'requests_overview' => 'Panoramica richieste',
        'search_placeholder' => 'Cerca oggetto, categoria o cliente',
        'all_statuses' => 'Tutti gli stati',
        'resolved_label' => 'Risolti',
        'closed_label' => 'Chiusi',
        'all_priorities' => 'Tutte le priorita',
        'high' => 'Alta',
        'medium' => 'Media',
        'low' => 'Bassa',
        'subject' => 'Oggetto',
        'category' => 'Categoria',
        'priority' => 'Priorita',
        'status' => 'Stato',
        'date' => 'Data',
        'customer' => 'Cliente',
        'actions' => 'Azioni',
        'untitled' => '(senza oggetto)',
        'customer_request' => 'Richiesta cliente',
        'details' => 'Dettagli',
        'no_tickets' => 'Nessun ticket disponibile.',
        'pagination' => 'Paginazione',
        'previous' => 'Precedente',
        'next' => 'Successiva',
        'sort_by' => 'Ordina per',
        'sort_none' => 'Nessun ordinamento applicato',
        'sort_asc' => 'Ordinamento crescente attivo',
        'sort_desc' => 'Ordinamento decrescente attivo',
    ],
    'en' => [
        'page_title' => 'Tickets',
        'status_labels' => ['open' => 'Open', 'in_progress' => 'In Progress', 'resolved' => 'Resolved', 'closed' => 'Closed'],
        'priority_labels' => ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'],
        'hero_title' => 'Manage the ticket flow with more clarity',
        'hero_lead' => 'A single view to understand operational load, active priorities and the issues to open right away.',
        'open_kanban' => 'Open kanban board',
        'new_ticket' => 'New ticket',
        'export_csv' => 'Export CSV',
        'high_priority' => 'high priorities',
        'visible_total' => 'Visible total',
        'tickets_in_list' => 'tickets in the list',
        'open_label' => 'Open',
        'open_meta' => 'new requests needing attention',
        'in_progress_label' => 'In progress',
        'in_progress_meta' => 'tickets currently being handled',
        'closed_or_resolved' => 'Closed or resolved',
        'closed_meta' => 'completed outcomes in the current dataset',
        'ticket_board' => 'Ticket board',
        'requests_overview' => 'Requests overview',
        'search_placeholder' => 'Search subject, category or customer',
        'all_statuses' => 'All statuses',
        'resolved_label' => 'Resolved',
        'closed_label' => 'Closed',
        'all_priorities' => 'All priorities',
        'high' => 'High',
        'medium' => 'Medium',
        'low' => 'Low',
        'subject' => 'Subject',
        'category' => 'Category',
        'priority' => 'Priority',
        'status' => 'Status',
        'date' => 'Date',
        'customer' => 'Customer',
        'actions' => 'Actions',
        'untitled' => '(untitled)',
        'customer_request' => 'Customer request',
        'details' => 'Details',
        'no_tickets' => 'No tickets available.',
        'pagination' => 'Pagination',
        'previous' => 'Previous',
        'next' => 'Next',
        'sort_by' => 'Sort by',
        'sort_none' => 'No sorting applied',
        'sort_asc' => 'Ascending sort active',
        'sort_desc' => 'Descending sort active',
    ],
    'fr' => [
        'page_title' => 'Tickets',
        'status_labels' => ['open' => 'Ouvert', 'in_progress' => 'En cours', 'resolved' => 'Resolu', 'closed' => 'Ferme'],
        'priority_labels' => ['low' => 'Basse', 'medium' => 'Moyenne', 'high' => 'Haute'],
        'hero_title' => 'Gerez le flux des tickets avec plus de clarte',
        'hero_lead' => 'Une vue unique pour comprendre la charge operationnelle, les priorites actives et les interventions a ouvrir immediatement.',
        'open_kanban' => 'Ouvrir le board kanban',
        'new_ticket' => 'Nouveau ticket',
        'export_csv' => 'Exporter CSV',
        'high_priority' => 'priorites hautes',
        'visible_total' => 'Total visible',
        'tickets_in_list' => 'tickets dans la liste',
        'open_label' => 'Ouverts',
        'open_meta' => 'nouvelles demandes a surveiller',
        'in_progress_label' => 'En cours',
        'in_progress_meta' => 'tickets actuellement en gestion',
        'closed_or_resolved' => 'Fermes ou resolus',
        'closed_meta' => 'issues finalisees dans le jeu de donnees actuel',
        'ticket_board' => 'Board tickets',
        'requests_overview' => 'Vue d ensemble des demandes',
        'search_placeholder' => 'Rechercher sujet, categorie ou client',
        'all_statuses' => 'Tous les statuts',
        'resolved_label' => 'Resolus',
        'closed_label' => 'Fermes',
        'all_priorities' => 'Toutes les priorites',
        'high' => 'Haute',
        'medium' => 'Moyenne',
        'low' => 'Basse',
        'subject' => 'Sujet',
        'category' => 'Categorie',
        'priority' => 'Priorite',
        'status' => 'Statut',
        'date' => 'Date',
        'customer' => 'Client',
        'actions' => 'Actions',
        'untitled' => '(sans objet)',
        'customer_request' => 'Demande client',
        'details' => 'Details',
        'no_tickets' => 'Aucun ticket disponible.',
        'pagination' => 'Pagination',
        'previous' => 'Precedent',
        'next' => 'Suivante',
        'sort_by' => 'Trier par',
        'sort_none' => 'Aucun tri applique',
        'sort_asc' => 'Tri croissant actif',
        'sort_desc' => 'Tri decroissant actif',
    ],
    'es' => [
        'page_title' => 'Tickets',
        'status_labels' => ['open' => 'Abierto', 'in_progress' => 'En curso', 'resolved' => 'Resuelto', 'closed' => 'Cerrado'],
        'priority_labels' => ['low' => 'Baja', 'medium' => 'Media', 'high' => 'Alta'],
        'hero_title' => 'Gestiona el flujo de tickets con mas claridad',
        'hero_lead' => 'Una vista unica para entender la carga operativa, las prioridades activas y las intervenciones que abrir de inmediato.',
        'open_kanban' => 'Abrir tablero kanban',
        'new_ticket' => 'Nuevo ticket',
        'export_csv' => 'Exportar CSV',
        'high_priority' => 'prioridades altas',
        'visible_total' => 'Total visible',
        'tickets_in_list' => 'tickets en la lista',
        'open_label' => 'Abiertos',
        'open_meta' => 'nuevas solicitudes que atender',
        'in_progress_label' => 'En curso',
        'in_progress_meta' => 'tickets actualmente en gestion',
        'closed_or_resolved' => 'Cerrados o resueltos',
        'closed_meta' => 'resultados completados en el conjunto actual',
        'ticket_board' => 'Tablero de tickets',
        'requests_overview' => 'Resumen de solicitudes',
        'search_placeholder' => 'Buscar asunto, categoria o cliente',
        'all_statuses' => 'Todos los estados',
        'resolved_label' => 'Resueltos',
        'closed_label' => 'Cerrados',
        'all_priorities' => 'Todas las prioridades',
        'high' => 'Alta',
        'medium' => 'Media',
        'low' => 'Baja',
        'subject' => 'Asunto',
        'category' => 'Categoria',
        'priority' => 'Prioridad',
        'status' => 'Estado',
        'date' => 'Fecha',
        'customer' => 'Cliente',
        'actions' => 'Acciones',
        'untitled' => '(sin asunto)',
        'customer_request' => 'Solicitud del cliente',
        'details' => 'Detalles',
        'no_tickets' => 'No hay tickets disponibles.',
        'pagination' => 'Paginacion',
        'previous' => 'Anterior',
        'next' => 'Siguiente',
        'sort_by' => 'Ordenar por',
        'sort_none' => 'Sin orden aplicado',
        'sort_asc' => 'Orden ascendente activo',
        'sort_desc' => 'Orden descendente activo',
    ],
];
$tt = $ticketsText[$locale] ?? $ticketsText['it'];
$pageTitle = $tt['page_title'];

$tickets = (array)($tickets ?? []);
$ticketSummary = (array)($ticketSummary ?? []);
$totalTickets = (int)($ticketSummary['visible_total'] ?? count($tickets));
$openCount = (int)($ticketSummary['open_total'] ?? 0);
$progressCount = (int)($ticketSummary['in_progress_total'] ?? 0);
$closedCount = (int)($ticketSummary['closed_total'] ?? 0);
$resolvedCount = (int)($ticketSummary['resolved_total'] ?? 0);
$highPriorityCount = (int)($ticketSummary['high_priority_total'] ?? 0);

$statusLabels = $tt['status_labels'];
$priorityLabels = $tt['priority_labels'];

$search = (string)($search ?? '');
$statusFilter = (string)($statusFilter ?? '');
$priorityFilter = (string)($priorityFilter ?? '');
$sortBy = (string)($sortBy ?? '');
$sortDir = (string)($sortDir ?? 'desc');
$showCustomerColumn = !Auth::isCustomer();
$ticketQueryBase = [];
if ($search !== '') $ticketQueryBase['q'] = $search;
if ($statusFilter !== '') $ticketQueryBase['status'] = $statusFilter;
if ($priorityFilter !== '') $ticketQueryBase['priority'] = $priorityFilter;
if ($sortBy !== '') $ticketQueryBase['sort'] = $sortBy;
if ($sortDir !== '') $ticketQueryBase['dir'] = $sortDir;
$ticketQueryString = http_build_query($ticketQueryBase);
$ticketQuerySuffix = $ticketQueryString !== '' ? '&' . $ticketQueryString : '';
$buildTicketQuery = static function (array $overrides = []) use ($search, $statusFilter, $priorityFilter, $sortBy, $sortDir): string {
    $query = [
        'q' => $search,
        'status' => $statusFilter,
        'priority' => $priorityFilter,
        'sort' => $sortBy,
        'dir' => $sortDir,
    ];

    foreach ($overrides as $key => $value) {
        $query[$key] = $value;
    }

    return http_build_query(array_filter($query, static function ($value) {
        return $value !== null && $value !== '';
    }));
};
$buildTicketUrl = static function (array $overrides = []) use ($buildTicketQuery): string {
    $query = $buildTicketQuery($overrides);
    return '/tickets' . ($query !== '' ? '?' . $query : '');
};
$sortMeta = static function (string $column) use ($sortBy, $sortDir, $tt): array {
    $isActive = $sortBy === $column;

    return [
        'is_active' => $isActive,
        'direction' => $isActive ? $sortDir : null,
        'next_direction' => $isActive && $sortDir === 'asc' ? 'desc' : 'asc',
        'aria_sort' => $isActive ? ($sortDir === 'asc' ? 'ascending' : 'descending') : 'none',
        'icon' => !$isActive ? 'fa-sort' : ($sortDir === 'asc' ? 'fa-sort-up' : 'fa-sort-down'),
        'state' => !$isActive ? $tt['sort_none'] : ($sortDir === 'asc' ? $tt['sort_asc'] : $tt['sort_desc']),
    ];
};

$idSort = $sortMeta('id');
$subjectSort = $sortMeta('subject');
$categorySort = $sortMeta('category');
$prioritySort = $sortMeta('priority');
$statusSort = $sortMeta('status');
$customerSort = $sortMeta('customer_name');
$dateSort = $sortMeta('created_at');

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow">Support workspace</div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($tt['hero_title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($tt['hero_lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/tickets/board" class="btn btn-outline-secondary"><?php echo htmlspecialchars($tt['open_kanban']); ?></a>
        <?php if (RolePermissions::canCurrent('tickets_create')): ?>
            <a href="/tickets/create" class="btn btn-primary"><i class="fas fa-plus me-2"></i><?php echo htmlspecialchars($tt['new_ticket']); ?></a>
        <?php endif; ?>
        <a href="<?php echo htmlspecialchars($buildTicketUrl(['format' => 'csv', 'page' => null])); ?>" class="btn btn-outline-secondary"><i class="fas fa-file-arrow-down me-2"></i><?php echo htmlspecialchars($tt['export_csv']); ?></a>
        <span class="admin-section-chip"><i class="fas fa-bolt"></i><?php echo $highPriorityCount; ?> <?php echo htmlspecialchars($tt['high_priority']); ?></span>
    </div>
</section>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($tt['visible_total']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $totalTickets; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($tt['tickets_in_list']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($tt['open_label']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $openCount; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($tt['open_meta']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($tt['in_progress_label']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $progressCount; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($tt['in_progress_meta']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($tt['closed_or_resolved']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $closedCount + $resolvedCount; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($tt['closed_meta']); ?></span>
            </div>
        </div>
    </div>
</div>

<div class="card admin-data-card">
    <div class="card-header border-0">
        <div>
            <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($tt['ticket_board']); ?></p>
            <span><?php echo htmlspecialchars($tt['requests_overview']); ?></span>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="admin-filter-shell">
            <div class="admin-filter-shell__top">
                <form method="GET" action="/tickets" class="admin-searchbar">
                    <input class="form-control" type="text" name="q" placeholder="<?php echo htmlspecialchars($tt['search_placeholder']); ?>" value="<?php echo htmlspecialchars($search); ?>">
                    <?php if ($statusFilter !== ''): ?><input type="hidden" name="status" value="<?php echo htmlspecialchars($statusFilter); ?>"><?php endif; ?>
                    <?php if ($priorityFilter !== ''): ?><input type="hidden" name="priority" value="<?php echo htmlspecialchars($priorityFilter); ?>"><?php endif; ?>
                    <?php if ($sortBy !== ''): ?><input type="hidden" name="sort" value="<?php echo htmlspecialchars($sortBy); ?>"><?php endif; ?>
                    <?php if ($sortDir !== ''): ?><input type="hidden" name="dir" value="<?php echo htmlspecialchars($sortDir); ?>"><?php endif; ?>
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="admin-filter-shell__groups">
                <div class="admin-pillbar">
                    <a class="admin-pill <?php echo $statusFilter === '' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['status' => null, 'page' => null])); ?>"><?php echo htmlspecialchars($tt['all_statuses']); ?></a>
                    <a class="admin-pill <?php echo $statusFilter === 'open' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['status' => 'open', 'page' => null])); ?>"><?php echo htmlspecialchars($tt['open_label']); ?></a>
                    <a class="admin-pill <?php echo $statusFilter === 'in_progress' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['status' => 'in_progress', 'page' => null])); ?>"><?php echo htmlspecialchars($tt['in_progress_label']); ?></a>
                    <a class="admin-pill <?php echo $statusFilter === 'resolved' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['status' => 'resolved', 'page' => null])); ?>"><?php echo htmlspecialchars($tt['resolved_label']); ?></a>
                    <a class="admin-pill <?php echo $statusFilter === 'closed' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['status' => 'closed', 'page' => null])); ?>"><?php echo htmlspecialchars($tt['closed_label']); ?></a>
                </div>
                <div class="admin-pillbar">
                    <a class="admin-pill <?php echo $priorityFilter === '' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['priority' => null, 'page' => null])); ?>"><?php echo htmlspecialchars($tt['all_priorities']); ?></a>
                    <a class="admin-pill <?php echo $priorityFilter === 'high' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['priority' => 'high', 'page' => null])); ?>"><?php echo htmlspecialchars($tt['high']); ?></a>
                    <a class="admin-pill <?php echo $priorityFilter === 'medium' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['priority' => 'medium', 'page' => null])); ?>"><?php echo htmlspecialchars($tt['medium']); ?></a>
                    <a class="admin-pill <?php echo $priorityFilter === 'low' ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['priority' => 'low', 'page' => null])); ?>"><?php echo htmlspecialchars($tt['low']); ?></a>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill dashboard-soft-badge"><?php echo htmlspecialchars($tt['open_label']); ?> <?php echo $openCount; ?></span>
                    <span class="badge rounded-pill dashboard-soft-badge"><?php echo htmlspecialchars($tt['in_progress_label']); ?> <?php echo $progressCount; ?></span>
                    <span class="badge rounded-pill dashboard-soft-badge"><?php echo htmlspecialchars($tt['closed_label']); ?> <?php echo $closedCount; ?></span>
                </div>
            </div>
        </div>
        <div class="table-responsive admin-table-wrap">
            <table class="table table-hover align-middle mb-0 admin-enhanced-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col" aria-sort="<?php echo htmlspecialchars($idSort['aria_sort']); ?>">
                            <a class="admin-table-sort<?php echo $idSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['sort' => 'id', 'dir' => $idSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($tt['sort_by'] . ' #'); ?>">
                                <span>#</span>
                                <i class="fas <?php echo htmlspecialchars($idSort['icon']); ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?php echo htmlspecialchars($idSort['state']); ?></span>
                            </a>
                        </th>
                        <th scope="col" aria-sort="<?php echo htmlspecialchars($subjectSort['aria_sort']); ?>">
                            <a class="admin-table-sort<?php echo $subjectSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['sort' => 'subject', 'dir' => $subjectSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($tt['sort_by'] . ' ' . $tt['subject']); ?>">
                                <span><?php echo htmlspecialchars($tt['subject']); ?></span>
                                <i class="fas <?php echo htmlspecialchars($subjectSort['icon']); ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?php echo htmlspecialchars($subjectSort['state']); ?></span>
                            </a>
                        </th>
                        <th scope="col" aria-sort="<?php echo htmlspecialchars($categorySort['aria_sort']); ?>">
                            <a class="admin-table-sort<?php echo $categorySort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['sort' => 'category', 'dir' => $categorySort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($tt['sort_by'] . ' ' . $tt['category']); ?>">
                                <span><?php echo htmlspecialchars($tt['category']); ?></span>
                                <i class="fas <?php echo htmlspecialchars($categorySort['icon']); ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?php echo htmlspecialchars($categorySort['state']); ?></span>
                            </a>
                        </th>
                        <th scope="col" aria-sort="<?php echo htmlspecialchars($prioritySort['aria_sort']); ?>">
                            <a class="admin-table-sort<?php echo $prioritySort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['sort' => 'priority', 'dir' => $prioritySort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($tt['sort_by'] . ' ' . $tt['priority']); ?>">
                                <span><?php echo htmlspecialchars($tt['priority']); ?></span>
                                <i class="fas <?php echo htmlspecialchars($prioritySort['icon']); ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?php echo htmlspecialchars($prioritySort['state']); ?></span>
                            </a>
                        </th>
                        <th scope="col" aria-sort="<?php echo htmlspecialchars($statusSort['aria_sort']); ?>">
                            <a class="admin-table-sort<?php echo $statusSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['sort' => 'status', 'dir' => $statusSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($tt['sort_by'] . ' ' . $tt['status']); ?>">
                                <span><?php echo htmlspecialchars($tt['status']); ?></span>
                                <i class="fas <?php echo htmlspecialchars($statusSort['icon']); ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?php echo htmlspecialchars($statusSort['state']); ?></span>
                            </a>
                        </th>
                        <?php if ($showCustomerColumn): ?>
                            <th scope="col" aria-sort="<?php echo htmlspecialchars($customerSort['aria_sort']); ?>">
                                <a class="admin-table-sort<?php echo $customerSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['sort' => 'customer_name', 'dir' => $customerSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($tt['sort_by'] . ' ' . $tt['customer']); ?>">
                                    <span><?php echo htmlspecialchars($tt['customer']); ?></span>
                                    <i class="fas <?php echo htmlspecialchars($customerSort['icon']); ?>" aria-hidden="true"></i>
                                    <span class="visually-hidden"><?php echo htmlspecialchars($customerSort['state']); ?></span>
                                </a>
                            </th>
                        <?php endif; ?>
                        <th scope="col" aria-sort="<?php echo htmlspecialchars($dateSort['aria_sort']); ?>">
                            <a class="admin-table-sort<?php echo $dateSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildTicketUrl(['sort' => 'created_at', 'dir' => $dateSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($tt['sort_by'] . ' ' . $tt['date']); ?>">
                                <span><?php echo htmlspecialchars($tt['date']); ?></span>
                                <i class="fas <?php echo htmlspecialchars($dateSort['icon']); ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?php echo htmlspecialchars($dateSort['state']); ?></span>
                            </a>
                        </th>
                        <th scope="col" class="text-end"><?php echo htmlspecialchars($tt['actions']); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tickets)): ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <?php
                            $status = (string)($ticket['status'] ?? 'open');
                            $priority = (string)($ticket['priority'] ?? 'medium');

                            $priorityClass = $priority === 'high' ? 'badge bg-danger' : ($priority === 'low' ? 'badge bg-secondary' : 'badge bg-warning text-dark');
                            $statusClass = $status === 'closed' ? 'badge bg-success' : ($status === 'in_progress' ? 'badge bg-warning text-dark' : ($status === 'resolved' ? 'badge bg-primary' : 'badge bg-info text-dark'));
                            ?>
                            <tr>
                                <td class="admin-row-id"><?php echo (int)($ticket['id'] ?? 0); ?></td>
                                <td>
                                    <div class="admin-table-primary">
                                        <a class="text-decoration-none fw-semibold" href="/tickets/<?php echo (int)($ticket['id'] ?? 0); ?>">
                                            <?php echo htmlspecialchars((string)($ticket['subject'] ?? $tt['untitled'])); ?>
                                        </a>
                                        <span class="admin-table-subtitle">
                                            <?php echo !empty($ticket['customer_name']) ? htmlspecialchars((string)$ticket['customer_name']) : htmlspecialchars($tt['customer_request']); ?>
                                        </span>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars((string)($ticket['category'] ?? '-')); ?></span></td>
                                <td><span class="<?php echo $priorityClass; ?>"><?php echo htmlspecialchars($priorityLabels[$priority] ?? ucfirst($priority)); ?></span></td>
                                <td><span class="<?php echo $statusClass; ?>"><?php echo htmlspecialchars($statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status))); ?></span></td>
                                <?php if ($showCustomerColumn): ?>
                                    <td class="text-muted small"><?php echo !empty($ticket['customer_name']) ? htmlspecialchars((string)$ticket['customer_name']) : '&mdash;'; ?></td>
                                <?php endif; ?>
                                <td class="text-muted small"><?php echo htmlspecialchars(Locale::formatDateTime($ticket['created_at'] ?? '', '-')); ?></td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-secondary" href="/tickets/<?php echo (int)($ticket['id'] ?? 0); ?>"><?php echo htmlspecialchars($tt['details']); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-0 border-0">
                                <div class="dashboard-empty-state m-3">
                                    <i class="fas fa-ticket-alt"></i>
                                    <p class="mb-0"><?php echo htmlspecialchars($tt['no_tickets']); ?></p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php if (isset($totalPages) && $totalPages > 1): ?>
    <?php $currentPage = $page ?? 1; ?>
    <nav aria-label="<?php echo htmlspecialchars($tt['pagination']); ?>" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php $prevClass = $currentPage <= 1 ? ' disabled' : ''; ?>
            <?php $nextClass = $currentPage >= $totalPages ? ' disabled' : ''; ?>
            <li class="page-item<?php echo $prevClass; ?>">
                <a class="page-link" href="<?php echo $currentPage > 1 ? $buildTicketUrl(['page' => $currentPage - 1]) : '#'; ?>"><?php echo htmlspecialchars($tt['previous']); ?></a>
            </li>
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <li class="page-item<?php echo $p == $currentPage ? ' active' : ''; ?>">
                    <a class="page-link" href="<?php echo htmlspecialchars($buildTicketUrl(['page' => $p])); ?>"><?php echo $p; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item<?php echo $nextClass; ?>">
                <a class="page-link" href="<?php echo $currentPage < $totalPages ? $buildTicketUrl(['page' => $currentPage + 1]) : '#'; ?>"><?php echo htmlspecialchars($tt['next']); ?></a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
