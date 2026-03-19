<?php
use Core\Locale;

$locale = Locale::current();
$customersText = [
    'it' => [
        'page_title' => 'Customers',
        'hero_title' => 'Vista clienti orientata a operazioni, storico e materiali',
        'hero_lead' => 'Una sezione dedicata per trovare rapidamente clienti, aprire il loro workspace e capire ticket, documenti e attivita correlate.',
        'new_customer' => 'Nuovo cliente',
        'export_csv' => 'Esporta CSV',
        'visible' => 'visibili',
        'customer_index' => 'Customer index',
        'customer_list' => 'Lista clienti',
        'registered' => 'Registrato',
        'search_placeholder' => 'Cerca cliente, email o telefono',
        'all_statuses' => 'Tutti gli stati',
        'active' => 'Attivi',
        'suspended' => 'Sospesi',
        'inactive' => 'Inattivi',
        'tickets' => 'ticket',
        'open' => 'aperti',
        'documents' => 'documenti',
        'phone_unavailable' => 'Telefono non disponibile',
        'email' => 'Email',
        'phone' => 'Telefono',
        'status' => 'Stato',
        'activity' => 'Attivita',
        'open_workspace' => 'Apri workspace',
        'empty' => 'Nessun cliente trovato con i filtri correnti.',
        'kpi_visible' => 'Clienti visibili',
        'kpi_active' => 'Clienti attivi',
        'kpi_suspended' => 'Clienti sospesi',
        'kpi_open_tickets' => 'Ticket aperti',
        'pagination' => 'Paginazione',
        'previous' => 'Precedente',
        'next' => 'Successiva',
        'sort_by' => 'Ordina per',
        'sort_none' => 'Nessun ordinamento applicato',
        'sort_asc' => 'Ordinamento crescente attivo',
        'sort_desc' => 'Ordinamento decrescente attivo',
    ],
    'en' => [
        'page_title' => 'Customers',
        'hero_title' => 'Customer view focused on operations, history and materials',
        'hero_lead' => 'A dedicated section to quickly find customers, open their workspace and understand related tickets, documents and activity.',
        'new_customer' => 'New customer',
        'export_csv' => 'Export CSV',
        'visible' => 'visible',
        'customer_index' => 'Customer index',
        'customer_list' => 'Customer list',
        'registered' => 'Created',
        'search_placeholder' => 'Search customer, email or phone',
        'all_statuses' => 'All statuses',
        'active' => 'Active',
        'suspended' => 'Suspended',
        'inactive' => 'Inactive',
        'tickets' => 'tickets',
        'open' => 'open',
        'documents' => 'documents',
        'phone_unavailable' => 'Phone not available',
        'email' => 'Email',
        'phone' => 'Phone',
        'status' => 'Status',
        'activity' => 'Activity',
        'open_workspace' => 'Open workspace',
        'empty' => 'No customers found with the current filters.',
        'kpi_visible' => 'Visible customers',
        'kpi_active' => 'Active customers',
        'kpi_suspended' => 'Suspended customers',
        'kpi_open_tickets' => 'Open tickets',
        'pagination' => 'Pagination',
        'previous' => 'Previous',
        'next' => 'Next',
        'sort_by' => 'Sort by',
        'sort_none' => 'No sorting applied',
        'sort_asc' => 'Ascending sort active',
        'sort_desc' => 'Descending sort active',
    ],
    'fr' => [
        'page_title' => 'Customers',
        'hero_title' => 'Vue clients orientee vers les operations, l historique et les contenus',
        'hero_lead' => 'Une section dediee pour trouver rapidement des clients, ouvrir leur workspace et comprendre les tickets, documents et activites associes.',
        'new_customer' => 'Nouveau client',
        'export_csv' => 'Exporter CSV',
        'visible' => 'visibles',
        'customer_index' => 'Index clients',
        'customer_list' => 'Liste des clients',
        'registered' => 'Cree le',
        'search_placeholder' => 'Rechercher client, email ou telephone',
        'all_statuses' => 'Tous les statuts',
        'active' => 'Actifs',
        'suspended' => 'Suspendus',
        'inactive' => 'Inactifs',
        'tickets' => 'tickets',
        'open' => 'ouverts',
        'documents' => 'documents',
        'phone_unavailable' => 'Telephone non disponible',
        'email' => 'Email',
        'phone' => 'Telephone',
        'status' => 'Statut',
        'activity' => 'Activite',
        'open_workspace' => 'Ouvrir workspace',
        'empty' => 'Aucun client trouve avec les filtres actuels.',
        'kpi_visible' => 'Clients visibles',
        'kpi_active' => 'Clients actifs',
        'kpi_suspended' => 'Clients suspendus',
        'kpi_open_tickets' => 'Tickets ouverts',
        'pagination' => 'Pagination',
        'previous' => 'Precedent',
        'next' => 'Suivante',
        'sort_by' => 'Trier par',
        'sort_none' => 'Aucun tri applique',
        'sort_asc' => 'Tri croissant actif',
        'sort_desc' => 'Tri decroissant actif',
    ],
    'es' => [
        'page_title' => 'Customers',
        'hero_title' => 'Vista de clientes orientada a operaciones, historial y materiales',
        'hero_lead' => 'Una seccion dedicada para encontrar rapidamente clientes, abrir su workspace y entender tickets, documentos y actividad relacionada.',
        'new_customer' => 'Nuevo cliente',
        'export_csv' => 'Exportar CSV',
        'visible' => 'visibles',
        'customer_index' => 'Indice de clientes',
        'customer_list' => 'Lista de clientes',
        'registered' => 'Creado',
        'search_placeholder' => 'Buscar cliente, email o telefono',
        'all_statuses' => 'Todos los estados',
        'active' => 'Activos',
        'suspended' => 'Suspendidos',
        'inactive' => 'Inactivos',
        'tickets' => 'tickets',
        'open' => 'abiertos',
        'documents' => 'documentos',
        'phone_unavailable' => 'Telefono no disponible',
        'email' => 'Email',
        'phone' => 'Telefono',
        'status' => 'Estado',
        'activity' => 'Actividad',
        'open_workspace' => 'Abrir workspace',
        'empty' => 'No se encontraron clientes con los filtros actuales.',
        'kpi_visible' => 'Clientes visibles',
        'kpi_active' => 'Clientes activos',
        'kpi_suspended' => 'Clientes suspendidos',
        'kpi_open_tickets' => 'Tickets abiertos',
        'pagination' => 'Paginacion',
        'previous' => 'Anterior',
        'next' => 'Siguiente',
        'sort_by' => 'Ordenar por',
        'sort_none' => 'Sin orden aplicado',
        'sort_asc' => 'Orden ascendente activo',
        'sort_desc' => 'Orden descendente activo',
    ],
];
$ct = $customersText[$locale] ?? $customersText['it'];
$pageTitle = $ct['page_title'];
$customers = (array)($customers ?? []);
$search = (string)($search ?? '');
$statusFilter = (string)($statusFilter ?? '');
$sortBy = (string)($sortBy ?? '');
$sortDir = (string)($sortDir ?? 'desc');
$customerSummary = (array)($customerSummary ?? []);
$queryBase = [];
if ($search !== '') $queryBase['q'] = $search;
if ($statusFilter !== '') $queryBase['status'] = $statusFilter;
if ($sortBy !== '') $queryBase['sort'] = $sortBy;
if ($sortDir !== '') $queryBase['dir'] = $sortDir;
$queryString = http_build_query($queryBase);
$querySuffix = $queryString !== '' ? '&' . $queryString : '';
$buildCustomersQuery = static function (array $overrides = []) use ($search, $statusFilter, $sortBy, $sortDir): string {
    $query = [
        'q' => $search,
        'status' => $statusFilter,
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
$buildCustomersUrl = static function (array $overrides = []) use ($buildCustomersQuery): string {
    $query = $buildCustomersQuery($overrides);
    return '/customers' . ($query !== '' ? '?' . $query : '');
};
$sortMeta = static function (string $column) use ($sortBy, $sortDir, $ct): array {
    $isActive = $sortBy === $column;

    return [
        'is_active' => $isActive,
        'direction' => $isActive ? $sortDir : null,
        'next_direction' => $isActive && $sortDir === 'asc' ? 'desc' : 'asc',
        'aria_sort' => $isActive ? ($sortDir === 'asc' ? 'ascending' : 'descending') : 'none',
        'icon' => !$isActive ? 'fa-sort' : ($sortDir === 'asc' ? 'fa-sort-up' : 'fa-sort-down'),
        'state' => !$isActive ? $ct['sort_none'] : ($sortDir === 'asc' ? $ct['sort_asc'] : $ct['sort_desc']),
    ];
};
$statusLabels = [
    'active' => $ct['active'],
    'suspended' => $ct['suspended'],
    'inactive' => $ct['inactive'],
];

$nameSort = $sortMeta('name');
$statusSort = $sortMeta('status');
$ticketsTotalSort = $sortMeta('tickets_total');
$ticketsOpenSort = $sortMeta('tickets_open');
$documentsSort = $sortMeta('documents_total');
$createdAtSort = $sortMeta('created_at');

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow">Customer workspace</div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($ct['hero_title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($ct['hero_lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/admin/users/create" class="btn btn-primary"><i class="fas fa-user-plus me-2"></i><?php echo htmlspecialchars($ct['new_customer']); ?></a>
        <a href="<?php echo htmlspecialchars($buildCustomersUrl(['format' => 'csv', 'page' => null])); ?>" class="btn btn-outline-secondary"><i class="fas fa-file-arrow-down me-2"></i><?php echo htmlspecialchars($ct['export_csv']); ?></a>
        <span class="admin-section-chip"><i class="fas fa-users"></i><?php echo count($customers); ?> <?php echo htmlspecialchars($ct['visible']); ?></span>
    </div>
</section>

<div class="row g-3 mb-4 admin-kpi-grid">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($ct['kpi_visible']); ?></span>
                <strong class="admin-stat-card__value"><?php echo (int)($customerSummary['visible_total'] ?? count($customers)); ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($ct['customer_list']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($ct['kpi_active']); ?></span>
                <strong class="admin-stat-card__value"><?php echo (int)($customerSummary['active_total'] ?? 0); ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($ct['active']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($ct['kpi_suspended']); ?></span>
                <strong class="admin-stat-card__value"><?php echo (int)($customerSummary['suspended_total'] ?? 0); ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($ct['suspended']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($ct['kpi_open_tickets']); ?></span>
                <strong class="admin-stat-card__value"><?php echo (int)($customerSummary['tickets_open_total'] ?? 0); ?></strong>
                <span class="admin-stat-card__meta"><?php echo (int)($customerSummary['documents_total'] ?? 0); ?> <?php echo htmlspecialchars($ct['documents']); ?></span>
            </div>
        </div>
    </div>
</div>

<div class="card admin-data-card mb-4">
    <div class="card-header border-0">
        <div>
            <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($ct['customer_index']); ?></p>
            <span><?php echo htmlspecialchars($ct['customer_list']); ?></span>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="admin-filter-shell">
            <div class="admin-filter-shell__top">
                <form method="GET" action="/customers" class="admin-searchbar">
                    <input class="form-control" type="text" name="q" placeholder="<?php echo htmlspecialchars($ct['search_placeholder']); ?>" value="<?php echo htmlspecialchars($search); ?>">
                    <?php if ($statusFilter !== ''): ?><input type="hidden" name="status" value="<?php echo htmlspecialchars($statusFilter); ?>"><?php endif; ?>
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="admin-filter-shell__groups">
                <div class="admin-pillbar">
                    <a class="admin-pill <?php echo $statusFilter === '' ? 'is-active' : ''; ?>" href="/customers<?php echo $search !== '' ? '?' . http_build_query(['q' => $search]) : ''; ?>"><?php echo htmlspecialchars($ct['all_statuses']); ?></a>
                    <a class="admin-pill <?php echo $statusFilter === 'active' ? 'is-active' : ''; ?>" href="/customers?<?php echo http_build_query(array_filter(['q' => $search, 'status' => 'active'])); ?>"><?php echo htmlspecialchars($ct['active']); ?></a>
                    <a class="admin-pill <?php echo $statusFilter === 'suspended' ? 'is-active' : ''; ?>" href="/customers?<?php echo http_build_query(array_filter(['q' => $search, 'status' => 'suspended'])); ?>"><?php echo htmlspecialchars($ct['suspended']); ?></a>
                </div>
            </div>
        </div>

        <div class="table-responsive admin-table-wrap customer-index-table-wrap">
            <table class="table table-hover align-middle admin-enhanced-table customer-index-table mb-0">
                <thead>
                    <tr>
                        <th scope="col" aria-sort="<?php echo htmlspecialchars($nameSort['aria_sort']); ?>">
                            <a class="admin-table-sort<?php echo $nameSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildCustomersUrl(['sort' => 'name', 'dir' => $nameSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($ct['sort_by'] . ' ' . $ct['customer_list']); ?>">
                                <span><?php echo htmlspecialchars($ct['customer_list']); ?></span>
                                <i class="fas <?php echo htmlspecialchars($nameSort['icon']); ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?php echo htmlspecialchars($nameSort['state']); ?></span>
                            </a>
                        </th>
                        <th><?php echo htmlspecialchars($ct['email']); ?></th>
                        <th><?php echo htmlspecialchars($ct['phone']); ?></th>
                        <th scope="col" aria-sort="<?php echo htmlspecialchars($statusSort['aria_sort']); ?>">
                            <a class="admin-table-sort<?php echo $statusSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildCustomersUrl(['sort' => 'status', 'dir' => $statusSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($ct['sort_by'] . ' ' . $ct['status']); ?>">
                                <span><?php echo htmlspecialchars($ct['status']); ?></span>
                                <i class="fas <?php echo htmlspecialchars($statusSort['icon']); ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?php echo htmlspecialchars($statusSort['state']); ?></span>
                            </a>
                        </th>
                        <th scope="col" aria-sort="<?php echo htmlspecialchars($ticketsTotalSort['aria_sort']); ?>">
                            <a class="admin-table-sort<?php echo $ticketsTotalSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildCustomersUrl(['sort' => 'tickets_total', 'dir' => $ticketsTotalSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($ct['sort_by'] . ' ' . $ct['tickets']); ?>">
                                <span><?php echo htmlspecialchars($ct['activity']); ?></span>
                                <i class="fas <?php echo htmlspecialchars($ticketsTotalSort['icon']); ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?php echo htmlspecialchars($ticketsTotalSort['state']); ?></span>
                            </a>
                        </th>
                        <th scope="col" aria-sort="<?php echo htmlspecialchars($createdAtSort['aria_sort']); ?>">
                            <a class="admin-table-sort<?php echo $createdAtSort['is_active'] ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($buildCustomersUrl(['sort' => 'created_at', 'dir' => $createdAtSort['next_direction'], 'page' => null])); ?>" aria-label="<?php echo htmlspecialchars($ct['sort_by'] . ' ' . $ct['registered']); ?>">
                                <span><?php echo htmlspecialchars($ct['registered']); ?></span>
                                <i class="fas <?php echo htmlspecialchars($createdAtSort['icon']); ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?php echo htmlspecialchars($createdAtSort['state']); ?></span>
                            </a>
                        </th>
                        <th class="text-end"><?php echo htmlspecialchars($ct['open_workspace']); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        <strong><?php echo htmlspecialchars((string)$customer['name']); ?></strong>
                                        <span class="admin-table-subtitle">#<?php echo (int)$customer['id']; ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="customer-index-table__email"><?php echo htmlspecialchars((string)$customer['email']); ?></span>
                                </td>
                                <td>
                                    <span class="admin-table-subtitle"><?php echo !empty($customer['phone']) ? htmlspecialchars((string)$customer['phone']) : htmlspecialchars($ct['phone_unavailable']); ?></span>
                                </td>
                                <td>
                                    <span class="badge <?php echo ($customer['status'] ?? 'active') === 'active' ? 'bg-success' : 'bg-secondary'; ?> customer-index-table__status">
                                        <?php echo htmlspecialchars($statusLabels[(string)($customer['status'] ?? 'active')] ?? (string)($customer['status'] ?? 'active')); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="customer-index-table__stats">
                                        <span><?php echo (int)($customer['tickets_total'] ?? 0); ?> <?php echo htmlspecialchars($ct['tickets']); ?></span>
                                        <span><?php echo (int)($customer['tickets_open'] ?? 0); ?> <?php echo htmlspecialchars($ct['open']); ?></span>
                                        <span><?php echo (int)($customer['documents_total'] ?? 0); ?> <?php echo htmlspecialchars($ct['documents']); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="admin-table-subtitle"><?php echo htmlspecialchars(Locale::formatDateTime($customer['created_at'] ?? '')); ?></span>
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-outline-secondary btn-sm" href="/customers/<?php echo (int)$customer['id']; ?>">
                                        <?php echo htmlspecialchars($ct['open_workspace']); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="dashboard-empty-state customer-index-table__empty">
                                    <i class="fas fa-users"></i>
                                    <p class="mb-0"><?php echo htmlspecialchars($ct['empty']); ?></p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (($totalPages ?? 1) > 1): ?>
    <nav aria-label="<?php echo htmlspecialchars($ct['pagination']); ?>" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item<?php echo ($page ?? 1) <= 1 ? ' disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($page ?? 1) <= 1 ? '#' : '/customers?page=' . (($page ?? 1) - 1) . $querySuffix; ?>"><?php echo htmlspecialchars($ct['previous']); ?></a>
            </li>
            <?php for ($i = 1; $i <= ($totalPages ?? 1); $i++): ?>
                <li class="page-item<?php echo $i === ($page ?? 1) ? ' active' : ''; ?>">
                    <a class="page-link" href="/customers?page=<?php echo $i . $querySuffix; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item<?php echo ($page ?? 1) >= ($totalPages ?? 1) ? ' disabled' : ''; ?>">
                <a class="page-link" href="<?php echo ($page ?? 1) >= ($totalPages ?? 1) ? '#' : '/customers?page=' . (($page ?? 1) + 1) . $querySuffix; ?>"><?php echo htmlspecialchars($ct['next']); ?></a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
