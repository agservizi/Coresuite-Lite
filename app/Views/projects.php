<?php
use Core\Auth;
use Core\Locale;
use Core\RolePermissions;

$projectText = [
    'it' => [
        'page_title' => 'Projects',
        'eyebrow' => 'Project hub',
        'title' => 'Portafoglio progetti con vista operativa, salute e scadenze',
        'lead' => 'Una regia unica per monitorare delivery, priorita, budget e contesto cliente senza uscire dal workspace.',
        'new_project' => 'Nuovo progetto',
        'board' => 'Apri board',
        'total' => 'Progetti totali',
        'live' => 'Live',
        'risk' => 'A rischio',
        'due_soon' => 'In scadenza',
        'kpi_total' => 'portafoglio visibile',
        'kpi_live' => 'in esecuzione o revisione',
        'kpi_risk' => 'bloccati o da presidiare',
        'kpi_due' => 'entro 14 giorni',
        'library' => 'Project index',
        'list' => 'Lista progetti',
        'search_placeholder' => 'Cerca nome progetto, codice o cliente',
        'all_statuses' => 'Tutti gli stati',
        'all_priorities' => 'Tutte le priorita',
        'all_health' => 'Tutta la salute',
        'all_customers' => 'Tutti i clienti',
        'progress' => 'Progress',
        'owner' => 'Owner',
        'customer' => 'Cliente',
        'due_date' => 'Due date',
        'budget' => 'Budget',
        'actions' => 'Azioni',
        'details' => 'Apri',
        'health' => 'Salute',
        'empty' => 'Nessun progetto corrisponde ai filtri correnti.',
        'pagination' => 'Paginazione progetti',
        'previous' => 'Precedente',
        'next' => 'Successiva',
        'sort_by' => 'Ordina per',
        'sort_none' => 'Nessun ordinamento applicato',
        'sort_asc' => 'Ordinamento crescente attivo',
        'sort_desc' => 'Ordinamento decrescente attivo',
    ],
    'en' => [
        'page_title' => 'Projects',
        'eyebrow' => 'Project hub',
        'title' => 'Project portfolio with operational, health, and deadline view',
        'lead' => 'A single control layer to monitor delivery, priorities, budget, and customer context without leaving the workspace.',
        'new_project' => 'New project',
        'board' => 'Open board',
        'total' => 'Total projects',
        'live' => 'Live',
        'risk' => 'At risk',
        'due_soon' => 'Due soon',
        'kpi_total' => 'visible portfolio',
        'kpi_live' => 'in execution or review',
        'kpi_risk' => 'blocked or requires attention',
        'kpi_due' => 'within 14 days',
        'library' => 'Project index',
        'list' => 'Project list',
        'search_placeholder' => 'Search project name, code, or customer',
        'all_statuses' => 'All statuses',
        'all_priorities' => 'All priorities',
        'all_health' => 'All health',
        'all_customers' => 'All customers',
        'progress' => 'Progress',
        'owner' => 'Owner',
        'customer' => 'Customer',
        'due_date' => 'Due date',
        'budget' => 'Budget',
        'actions' => 'Actions',
        'details' => 'Open',
        'health' => 'Health',
        'empty' => 'No projects match the current filters.',
        'pagination' => 'Projects pagination',
        'previous' => 'Previous',
        'next' => 'Next',
        'sort_by' => 'Sort by',
        'sort_none' => 'No sorting applied',
        'sort_asc' => 'Ascending sort active',
        'sort_desc' => 'Descending sort active',
    ],
    'fr' => [
        'page_title' => 'Projects',
        'eyebrow' => 'Project hub',
        'title' => 'Portefeuille projets avec vue operationnelle, sante et echeances',
        'lead' => 'Une regie unique pour suivre delivery, priorites, budget et contexte client sans quitter le workspace.',
        'new_project' => 'Nouveau projet',
        'board' => 'Ouvrir board',
        'total' => 'Projets totaux',
        'live' => 'Live',
        'risk' => 'A risque',
        'due_soon' => 'Echeance proche',
        'kpi_total' => 'portefeuille visible',
        'kpi_live' => 'en execution ou revision',
        'kpi_risk' => 'bloques ou a surveiller',
        'kpi_due' => 'dans 14 jours',
        'library' => 'Index projets',
        'list' => 'Liste projets',
        'search_placeholder' => 'Rechercher nom projet, code ou client',
        'all_statuses' => 'Tous les statuts',
        'all_priorities' => 'Toutes les priorites',
        'all_health' => 'Toute la sante',
        'all_customers' => 'Tous les clients',
        'progress' => 'Progression',
        'owner' => 'Owner',
        'customer' => 'Client',
        'due_date' => 'Echeance',
        'budget' => 'Budget',
        'actions' => 'Actions',
        'details' => 'Ouvrir',
        'health' => 'Sante',
        'empty' => 'Aucun projet ne correspond aux filtres actuels.',
        'pagination' => 'Pagination projets',
        'previous' => 'Precedent',
        'next' => 'Suivante',
        'sort_by' => 'Trier par',
        'sort_none' => 'Aucun tri applique',
        'sort_asc' => 'Tri croissant actif',
        'sort_desc' => 'Tri decroissant actif',
    ],
    'es' => [
        'page_title' => 'Projects',
        'eyebrow' => 'Project hub',
        'title' => 'Portfolio de proyectos con vista operativa, salud y vencimientos',
        'lead' => 'Una sola capa de control para seguir delivery, prioridades, presupuesto y contexto cliente sin salir del workspace.',
        'new_project' => 'Nuevo proyecto',
        'board' => 'Abrir board',
        'total' => 'Proyectos totales',
        'live' => 'Live',
        'risk' => 'En riesgo',
        'due_soon' => 'Por vencer',
        'kpi_total' => 'portfolio visible',
        'kpi_live' => 'en ejecucion o revision',
        'kpi_risk' => 'bloqueados o por atender',
        'kpi_due' => 'en 14 dias',
        'library' => 'Indice de proyectos',
        'list' => 'Lista de proyectos',
        'search_placeholder' => 'Buscar nombre de proyecto, codigo o cliente',
        'all_statuses' => 'Todos los estados',
        'all_priorities' => 'Todas las prioridades',
        'all_health' => 'Toda la salud',
        'all_customers' => 'Todos los clientes',
        'progress' => 'Progreso',
        'owner' => 'Owner',
        'customer' => 'Cliente',
        'due_date' => 'Vencimiento',
        'budget' => 'Presupuesto',
        'actions' => 'Acciones',
        'details' => 'Abrir',
        'health' => 'Salud',
        'empty' => 'Ningun proyecto coincide con los filtros actuales.',
        'pagination' => 'Paginacion proyectos',
        'previous' => 'Anterior',
        'next' => 'Siguiente',
        'sort_by' => 'Ordenar por',
        'sort_none' => 'Sin orden aplicado',
        'sort_asc' => 'Orden ascendente activo',
        'sort_desc' => 'Orden descendente activo',
    ],
];
$pt = $projectText[Locale::current()] ?? $projectText['it'];
$pageTitle = $pt['page_title'];
$buildProjectsQuery = static function (array $overrides = []) use ($search, $statusFilter, $priorityFilter, $healthFilter, $customerFilter, $sortBy, $sortDir): string {
    $query = [
        'q' => (string)($search ?? ''),
        'status' => (string)($statusFilter ?? ''),
        'priority' => (string)($priorityFilter ?? ''),
        'health' => (string)($healthFilter ?? ''),
        'customer' => (int)($customerFilter ?? 0) ?: null,
        'sort' => (string)($sortBy ?? ''),
        'dir' => (string)($sortDir ?? ''),
    ];

    foreach ($overrides as $key => $value) {
        $query[$key] = $value;
    }

    return http_build_query(array_filter($query, static function ($value) {
        return $value !== null && $value !== '';
    }));
};
$buildProjectsUrl = static function (array $overrides = []) use ($buildProjectsQuery): string {
    $query = $buildProjectsQuery($overrides);
    return '/projects' . ($query !== '' ? '?' . $query : '');
};
$sortMeta = static function (string $column) use ($sortBy, $sortDir, $pt): array {
    $isActive = $sortBy === $column;
    $direction = $isActive ? $sortDir : null;

    return [
        'is_active' => $isActive,
        'direction' => $direction,
        'next_direction' => $isActive && $sortDir === 'asc' ? 'desc' : 'asc',
        'aria_sort' => $isActive ? ($sortDir === 'asc' ? 'ascending' : 'descending') : 'none',
        'icon' => !$isActive ? 'fa-sort' : ($sortDir === 'asc' ? 'fa-sort-up' : 'fa-sort-down'),
        'state' => !$isActive ? $pt['sort_none'] : ($sortDir === 'asc' ? $pt['sort_asc'] : $pt['sort_desc']),
    ];
};
$queryBase = array_filter([
    'q' => (string)($search ?? ''),
    'status' => (string)($statusFilter ?? ''),
    'priority' => (string)($priorityFilter ?? ''),
    'health' => (string)($healthFilter ?? ''),
    'customer' => (int)($customerFilter ?? 0) ?: null,
    'sort' => (string)($sortBy ?? ''),
    'dir' => (string)($sortDir ?? ''),
]);
$querySuffix = $queryBase ? '&' . http_build_query($queryBase) : '';

$progressSort = $sortMeta('progress');
$healthSort = $sortMeta('health');
$dueDateSort = $sortMeta('due_date');

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($pt['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($pt['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($pt['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/projects/board" class="btn btn-outline-secondary"><i class="fas fa-table-columns me-2"></i><?php echo htmlspecialchars($pt['board']); ?></a>
        <?php if (RolePermissions::canCurrent('projects_manage')): ?>
            <a href="/projects/create" class="btn btn-primary"><i class="fas fa-diagram-project me-2"></i><?php echo htmlspecialchars($pt['new_project']); ?></a>
        <?php endif; ?>
    </div>
</section>

<div class="row g-3 mb-4 admin-kpi-grid">
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--customers h-100">
            <div class="card-body">
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($pt['total']); ?></div>
                <p class="admin-kpi-value"><?php echo (int)($kpis['total_projects'] ?? 0); ?></p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars($pt['kpi_total']); ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--open h-100">
            <div class="card-body">
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($pt['live']); ?></div>
                <p class="admin-kpi-value"><?php echo (int)($kpis['live_projects'] ?? 0); ?></p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars($pt['kpi_live']); ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--tickets h-100">
            <div class="card-body">
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($pt['risk']); ?></div>
                <p class="admin-kpi-value"><?php echo (int)($kpis['at_risk_projects'] ?? 0); ?></p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars($pt['kpi_risk']); ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-kpi-card admin-kpi-card--documents h-100">
            <div class="card-body">
                <div class="admin-kpi-meta"><?php echo htmlspecialchars($pt['due_soon']); ?></div>
                <p class="admin-kpi-value"><?php echo (int)($kpis['due_soon_projects'] ?? 0); ?></p>
                <p class="admin-kpi-label"><?php echo htmlspecialchars($pt['kpi_due']); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="card admin-data-card mb-4">
    <div class="card-header border-0">
        <div>
            <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($pt['library']); ?></p>
            <span><?php echo htmlspecialchars($pt['list']); ?></span>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="admin-filter-shell">
            <div class="admin-filter-shell__top">
                <form method="GET" action="/projects" class="admin-searchbar">
                    <input class="form-control" type="text" name="q" placeholder="<?php echo htmlspecialchars($pt['search_placeholder']); ?>" value="<?php echo htmlspecialchars((string)($search ?? '')); ?>">
                    <?php foreach (['status' => $statusFilter ?? '', 'priority' => $priorityFilter ?? '', 'health' => $healthFilter ?? '', 'customer' => $customerFilter ?? ''] as $name => $value): ?>
                        <?php if ((string)$value !== '' && (int)$value !== 0): ?><input type="hidden" name="<?php echo htmlspecialchars($name); ?>" value="<?php echo htmlspecialchars((string)$value); ?>"><?php endif; ?>
                    <?php endforeach; ?>
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="admin-filter-shell__groups">
                <div class="admin-pillbar">
                    <a class="admin-pill <?php echo empty($statusFilter) ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['status' => null, 'page' => null])); ?>"><?php echo htmlspecialchars($pt['all_statuses']); ?></a>
                    <?php foreach (['planning','active','review','completed','blocked'] as $status): ?>
                        <a class="admin-pill <?php echo ($statusFilter ?? '') === $status ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['status' => $status, 'page' => null])); ?>"><?php echo htmlspecialchars($this->labelFor('status', $status)); ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="admin-pillbar">
                    <a class="admin-pill <?php echo empty($priorityFilter) ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['priority' => null, 'page' => null])); ?>"><?php echo htmlspecialchars($pt['all_priorities']); ?></a>
                    <?php foreach (['low','medium','high'] as $priority): ?>
                        <a class="admin-pill <?php echo ($priorityFilter ?? '') === $priority ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['priority' => $priority, 'page' => null])); ?>"><?php echo htmlspecialchars($this->labelFor('priority', $priority)); ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="admin-pillbar">
                    <a class="admin-pill <?php echo empty($healthFilter) ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['health' => null, 'page' => null])); ?>"><?php echo htmlspecialchars($pt['all_health']); ?></a>
                    <?php foreach (['on_track','watch','at_risk'] as $health): ?>
                        <a class="admin-pill <?php echo ($healthFilter ?? '') === $health ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['health' => $health, 'page' => null])); ?>"><?php echo htmlspecialchars($this->labelFor('health', $health)); ?></a>
                    <?php endforeach; ?>
                </div>
                <?php if (!Auth::isCustomer() && !empty($customers)): ?>
                    <div class="admin-pillbar">
                        <a class="admin-pill <?php echo empty($customerFilter) ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['customer' => null, 'page' => null])); ?>"><?php echo htmlspecialchars($pt['all_customers']); ?></a>
                        <?php foreach ($customers as $customer): ?>
                            <a class="admin-pill <?php echo (int)($customerFilter ?? 0) === (int)$customer['id'] ? 'is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['customer' => (int)$customer['id'], 'page' => null])); ?>"><?php echo htmlspecialchars((string)$customer['name']); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($projects)): ?>
            <div class="table-responsive admin-table-wrap">
                <table class="table table-hover align-middle mb-0 admin-enhanced-table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?php echo htmlspecialchars($pt['list']); ?></th>
                            <th scope="col"><?php echo htmlspecialchars($pt['customer']); ?></th>
                            <th scope="col"><?php echo htmlspecialchars($pt['owner']); ?></th>
                            <th scope="col" aria-sort="<?php echo htmlspecialchars($progressSort['aria_sort']); ?>">
                                <a class="admin-table-sort<?php echo $progressSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['sort' => 'progress', 'dir' => $progressSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($pt['sort_by'] . ' ' . $pt['progress']); ?>">
                                    <span><?php echo htmlspecialchars($pt['progress']); ?></span>
                                    <i class="fas <?php echo htmlspecialchars($progressSort['icon']); ?>" aria-hidden="true"></i>
                                    <span class="visually-hidden"><?php echo htmlspecialchars($progressSort['state']); ?></span>
                                </a>
                            </th>
                            <th scope="col" aria-sort="<?php echo htmlspecialchars($healthSort['aria_sort']); ?>">
                                <a class="admin-table-sort<?php echo $healthSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['sort' => 'health', 'dir' => $healthSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($pt['sort_by'] . ' ' . $pt['health']); ?>">
                                    <span><?php echo htmlspecialchars($pt['health']); ?></span>
                                    <i class="fas <?php echo htmlspecialchars($healthSort['icon']); ?>" aria-hidden="true"></i>
                                    <span class="visually-hidden"><?php echo htmlspecialchars($healthSort['state']); ?></span>
                                </a>
                            </th>
                            <th scope="col" aria-sort="<?php echo htmlspecialchars($dueDateSort['aria_sort']); ?>">
                                <a class="admin-table-sort<?php echo $dueDateSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildProjectsUrl(['sort' => 'due_date', 'dir' => $dueDateSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($pt['sort_by'] . ' ' . $pt['due_date']); ?>">
                                    <span><?php echo htmlspecialchars($pt['due_date']); ?></span>
                                    <i class="fas <?php echo htmlspecialchars($dueDateSort['icon']); ?>" aria-hidden="true"></i>
                                    <span class="visually-hidden"><?php echo htmlspecialchars($dueDateSort['state']); ?></span>
                                </a>
                            </th>
                            <th scope="col"><?php echo htmlspecialchars($pt['budget']); ?></th>
                            <th scope="col" class="text-end"><?php echo htmlspecialchars($pt['actions']); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td class="admin-row-id"><?php echo (int)($project['id'] ?? 0); ?></td>
                                <td>
                                    <div class="admin-table-primary">
                                        <a class="text-decoration-none fw-semibold" href="/projects/<?php echo (int)$project['id']; ?>">
                                            <?php echo htmlspecialchars((string)($project['name'] ?? '-')); ?>
                                        </a>
                                        <span class="admin-table-subtitle">
                                            <?php echo htmlspecialchars((string)($project['code'] ?? '-')); ?> •
                                            <?php echo htmlspecialchars((string)($project['status_label'] ?? '-')); ?> •
                                            <?php echo htmlspecialchars((string)($project['priority_label'] ?? '-')); ?>
                                        </span>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars((string)($project['customer_name'] ?? '-')); ?></td>
                                <td><?php echo htmlspecialchars((string)($project['owner_name'] ?? 'Core team')); ?></td>
                                <td style="min-width: 170px;">
                                    <div class="project-progress">
                                        <div class="project-progress__bar"><span style="width: <?php echo max(0, min(100, (int)$project['progress'])); ?>%"></span></div>
                                        <small><?php echo (int)$project['progress']; ?>%</small>
                                    </div>
                                </td>
                                <td><span class="project-health-pill project-health-pill--<?php echo htmlspecialchars((string)$project['health']); ?>"><?php echo htmlspecialchars((string)$project['health_label']); ?></span></td>
                                <td class="text-muted small"><?php echo htmlspecialchars(Locale::formatDate($project['due_date'] ?? '', '-')); ?></td>
                                <td><?php echo $project['budget'] !== null ? htmlspecialchars(number_format((float)$project['budget'], 2, ',', '.')) : '-'; ?></td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-secondary" href="/projects/<?php echo (int)$project['id']; ?>"><?php echo htmlspecialchars($pt['details']); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="dashboard-empty-state">
                <i class="fas fa-diagram-project"></i>
                <p class="mb-0"><?php echo htmlspecialchars($pt['empty']); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (($totalPages ?? 1) > 1): ?>
    <nav aria-label="<?php echo htmlspecialchars($pt['pagination']); ?>" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item<?php echo ($page ?? 1) <= 1 ? ' disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($page ?? 1) <= 1 ? '#' : htmlspecialchars($buildProjectsUrl(['page' => (($page ?? 1) - 1)])); ?>"><?php echo htmlspecialchars($pt['previous']); ?></a>
            </li>
            <?php for ($i = 1; $i <= ($totalPages ?? 1); $i++): ?>
                <li class="page-item<?php echo $i === ($page ?? 1) ? ' active' : ''; ?>">
                    <a class="page-link" href="<?php echo htmlspecialchars($buildProjectsUrl(['page' => $i])); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item<?php echo ($page ?? 1) >= ($totalPages ?? 1) ? ' disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($page ?? 1) >= ($totalPages ?? 1) ? '#' : htmlspecialchars($buildProjectsUrl(['page' => (($page ?? 1) + 1)])); ?>"><?php echo htmlspecialchars($pt['next']); ?></a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
