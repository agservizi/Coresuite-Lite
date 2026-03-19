<?php
use Core\Auth;
use Core\Locale;
use Core\RolePermissions;

$searchText = [
    'it' => ['page_title' => 'Ricerca globale', 'all' => 'Tutto', 'projects' => 'Progetti', 'tickets' => 'Ticket', 'documents' => 'Documenti', 'customers' => 'Clienti', 'sales' => 'Area commerciale', 'eyebrow' => 'Global search', 'title' => 'Trova velocemente progetti, ticket, documenti, clienti e opportunita commerciali', 'lead' => 'Una vista unica per navigare il workspace senza cambiare modulo e con accesso rapido ai risultati piu utili.', 'results' => 'risultati', 'placeholder' => 'Cerca progetti, ticket, clienti, documenti, deal...', 'submit' => 'Cerca nel workspace', 'empty_idle' => 'Inserisci una ricerca per esplorare il workspace in modo trasversale.', 'empty_prefix' => 'Nessun risultato trovato per', 'projects_sub' => 'Roadmap, delivery e portfolio operativo', 'tickets_sub' => 'Richieste e follow-up correlati', 'documents_sub' => 'File e materiale di archivio', 'customers_sub' => 'Contatti cliente e profili workspace', 'sales_sub' => 'Aziende, contatti, lead, deal e documenti commerciali', 'found' => 'trovati', 'empty_projects' => 'Nessun progetto in questa ricerca.', 'empty_tickets' => 'Nessun ticket in questa ricerca.', 'empty_documents' => 'Nessun documento in questa ricerca.', 'empty_customers' => 'Nessun cliente in questa ricerca.', 'empty_sales' => 'Nessun risultato commerciale in questa ricerca.'],
    'en' => ['page_title' => 'Global search', 'all' => 'All', 'projects' => 'Projects', 'tickets' => 'Tickets', 'documents' => 'Documents', 'customers' => 'Customers', 'sales' => 'Sales hub', 'eyebrow' => 'Global search', 'title' => 'Quickly find projects, tickets, documents, customers, and sales opportunities', 'lead' => 'A single view to navigate the workspace without changing module and with quick access to the most useful results.', 'results' => 'results', 'placeholder' => 'Search projects, tickets, customers, documents, deals...', 'submit' => 'Search workspace', 'empty_idle' => 'Enter a search to explore the workspace across modules.', 'empty_prefix' => 'No results found for', 'projects_sub' => 'Roadmap, delivery, and operational portfolio', 'tickets_sub' => 'Related requests and follow-ups', 'documents_sub' => 'Files and archive material', 'customers_sub' => 'Customer contacts and workspace profiles', 'sales_sub' => 'Companies, contacts, leads, deals, and commercial documents', 'found' => 'found', 'empty_projects' => 'No projects in this search.', 'empty_tickets' => 'No tickets in this search.', 'empty_documents' => 'No documents in this search.', 'empty_customers' => 'No customers in this search.', 'empty_sales' => 'No sales results in this search.'],
    'fr' => ['page_title' => 'Recherche globale', 'all' => 'Tout', 'projects' => 'Projets', 'tickets' => 'Tickets', 'documents' => 'Documents', 'customers' => 'Clients', 'sales' => 'Hub commercial', 'eyebrow' => 'Recherche globale', 'title' => 'Trouvez rapidement projets, tickets, documents, clients et opportunites commerciales', 'lead' => 'Une vue unique pour naviguer dans le workspace sans changer de module et avec un acces rapide aux resultats les plus utiles.', 'results' => 'resultats', 'placeholder' => 'Rechercher projets, tickets, clients, documents, deals...', 'submit' => 'Rechercher dans le workspace', 'empty_idle' => 'Saisissez une recherche pour explorer le workspace de facon transversale.', 'empty_prefix' => 'Aucun resultat trouve pour', 'projects_sub' => 'Roadmap, delivery et portefeuille operationnel', 'tickets_sub' => 'Demandes et suivis associes', 'documents_sub' => 'Fichiers et materiel archive', 'customers_sub' => 'Contacts client et profils workspace', 'sales_sub' => 'Societes, contacts, leads, deals et documents commerciaux', 'found' => 'trouves', 'empty_projects' => 'Aucun projet dans cette recherche.', 'empty_tickets' => 'Aucun ticket dans cette recherche.', 'empty_documents' => 'Aucun document dans cette recherche.', 'empty_customers' => 'Aucun client dans cette recherche.', 'empty_sales' => 'Aucun resultat commercial dans cette recherche.'],
    'es' => ['page_title' => 'Busqueda global', 'all' => 'Todo', 'projects' => 'Proyectos', 'tickets' => 'Tickets', 'documents' => 'Documentos', 'customers' => 'Clientes', 'sales' => 'Hub comercial', 'eyebrow' => 'Busqueda global', 'title' => 'Encuentra rapidamente proyectos, tickets, documentos, clientes y oportunidades comerciales', 'lead' => 'Una vista unica para navegar el workspace sin cambiar de modulo y con acceso rapido a los resultados mas utiles.', 'results' => 'resultados', 'placeholder' => 'Buscar proyectos, tickets, clientes, documentos, deals...', 'submit' => 'Buscar en el workspace', 'empty_idle' => 'Introduce una busqueda para explorar el workspace de forma transversal.', 'empty_prefix' => 'No se encontraron resultados para', 'projects_sub' => 'Roadmap, delivery y portfolio operativo', 'tickets_sub' => 'Solicitudes y seguimientos relacionados', 'documents_sub' => 'Archivos y material de archivo', 'customers_sub' => 'Contactos cliente y perfiles workspace', 'sales_sub' => 'Empresas, contactos, leads, deals y documentos comerciales', 'found' => 'encontrados', 'empty_projects' => 'No hay proyectos en esta busqueda.', 'empty_tickets' => 'No hay tickets en esta busqueda.', 'empty_documents' => 'No hay documentos en esta busqueda.', 'empty_customers' => 'No hay clientes en esta busqueda.', 'empty_sales' => 'No hay resultados comerciales en esta busqueda.'],
];
$srt = $searchText[Locale::current()] ?? $searchText['it'];
$pageTitle = $srt['page_title'];
$query = (string)($query ?? '');
$scope = (string)($scope ?? 'all');
$results = (array)($results ?? []);
$counts = (array)($counts ?? []);
$totalCount = (int)($totalCount ?? 0);

$searchScopes = [
    'all' => $srt['all'],
    'tickets' => $srt['tickets'],
    'documents' => $srt['documents'],
];

if (RolePermissions::canCurrent('projects_view')) {
    $searchScopes['projects'] = $srt['projects'];
}

if ((Auth::isAdmin() || Auth::isOperator()) && RolePermissions::canCurrent('customers_view')) {
    $searchScopes['customers'] = $srt['customers'];
}
if (!Auth::isCustomer() && RolePermissions::canCurrent('sales_view')) {
    $searchScopes['sales'] = $srt['sales'];
}

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($srt['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($srt['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($srt['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <span class="admin-section-chip"><i class="fas fa-magnifying-glass"></i><?php echo $totalCount; ?> <?php echo htmlspecialchars($srt['results']); ?></span>
    </div>
</section>

<div class="card admin-data-card mb-4">
    <div class="card-body">
        <form method="GET" action="/search" class="search-workspace-form">
            <div class="search-workspace-form__field">
                <i class="fas fa-magnifying-glass"></i>
                <input type="search" name="q" value="<?php echo htmlspecialchars($query); ?>" placeholder="<?php echo htmlspecialchars($srt['placeholder']); ?>">
            </div>
            <button class="btn btn-primary" type="submit"><?php echo htmlspecialchars($srt['submit']); ?></button>
        </form>
        <div class="admin-pillbar mt-3">
            <?php foreach ($searchScopes as $scopeKey => $scopeLabel): ?>
                <a class="admin-pill <?php echo $scope === $scopeKey ? 'is-active' : ''; ?>" href="/search?<?php echo http_build_query(array_filter(['q' => $query, 'scope' => $scopeKey])); ?>">
                    <?php echo htmlspecialchars($scopeLabel); ?>
                    <span class="search-scope-count"><?php echo (int)($scopeKey === 'all' ? $totalCount : ($counts[$scopeKey] ?? 0)); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php if ($query === ''): ?>
    <div class="dashboard-empty-state">
        <i class="fas fa-compass"></i>
        <p class="mb-0"><?php echo htmlspecialchars($srt['empty_idle']); ?></p>
    </div>
<?php elseif ($totalCount === 0): ?>
    <div class="dashboard-empty-state">
        <i class="fas fa-search-minus"></i>
        <p class="mb-0"><?php echo htmlspecialchars($srt['empty_prefix']); ?> "<?php echo htmlspecialchars($query); ?>".</p>
    </div>
<?php else: ?>
    <div class="search-results-grid">
        <?php if (RolePermissions::canCurrent('projects_view') && ($scope === 'all' || $scope === 'projects')): ?>
            <section class="card admin-data-card search-results-card">
                <div class="card-header border-0">
                    <div>
                        <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($srt['projects']); ?></p>
                        <span><?php echo htmlspecialchars($srt['projects_sub']); ?></span>
                    </div>
                    <span class="badge rounded-pill dashboard-soft-badge"><?php echo (int)($counts['projects'] ?? 0); ?> <?php echo htmlspecialchars($srt['found']); ?></span>
                </div>
                <div class="card-body">
                    <?php if (!empty($results['projects'])): ?>
                        <div class="search-result-list">
                            <?php foreach ($results['projects'] as $project): ?>
                                <a class="search-result-item dashboard-hoverlift" href="/projects/<?php echo (int)$project['id']; ?>">
                                    <div class="search-result-item__top">
                                        <strong><?php echo htmlspecialchars((string)($project['name'] ?? $srt['projects'])); ?></strong>
                                        <span class="search-result-item__meta"><?php echo (int)($project['progress'] ?? 0); ?>%</span>
                                    </div>
                                    <div class="search-result-item__sub">
                                        <span><?php echo htmlspecialchars((string)($project['code'] ?? '-')); ?></span>
                                        <?php if (!empty($project['customer_name'])): ?><span><?php echo htmlspecialchars((string)$project['customer_name']); ?></span><?php endif; ?>
                                    </div>
                                    <small><?php echo htmlspecialchars((string)($project['status'] ?? 'planning')); ?> • <?php echo htmlspecialchars(Locale::formatDateTime($project['updated_at'] ?? '')); ?></small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="dashboard-empty-state">
                            <i class="fas fa-diagram-project"></i>
                            <p class="mb-0"><?php echo htmlspecialchars($srt['empty_projects']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($scope === 'all' || $scope === 'tickets'): ?>
            <section class="card admin-data-card search-results-card">
                <div class="card-header border-0">
                    <div>
                        <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($srt['tickets']); ?></p>
                        <span><?php echo htmlspecialchars($srt['tickets_sub']); ?></span>
                    </div>
                    <span class="badge rounded-pill dashboard-soft-badge"><?php echo (int)($counts['tickets'] ?? 0); ?> <?php echo htmlspecialchars($srt['found']); ?></span>
                </div>
                <div class="card-body">
                    <?php if (!empty($results['tickets'])): ?>
                        <div class="search-result-list">
                            <?php foreach ($results['tickets'] as $ticket): ?>
                                <a class="search-result-item dashboard-hoverlift" href="/tickets/<?php echo (int)$ticket['id']; ?>">
                                    <div class="search-result-item__top">
                                        <strong><?php echo htmlspecialchars((string)($ticket['subject'] ?? $srt['tickets'])); ?></strong>
                                        <span class="search-result-item__meta"><?php echo htmlspecialchars((string)($ticket['priority'] ?? 'medium')); ?></span>
                                    </div>
                                    <div class="search-result-item__sub">
                                        <span><?php echo htmlspecialchars((string)($ticket['category'] ?? '-')); ?></span>
                                        <?php if (!empty($ticket['customer_name'])): ?><span><?php echo htmlspecialchars((string)$ticket['customer_name']); ?></span><?php endif; ?>
                                    </div>
                                    <small><?php echo htmlspecialchars((string)($ticket['status'] ?? 'open')); ?> • <?php echo htmlspecialchars(Locale::formatDateTime($ticket['created_at'] ?? '')); ?></small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="dashboard-empty-state">
                            <i class="fas fa-ticket-alt"></i>
                            <p class="mb-0"><?php echo htmlspecialchars($srt['empty_tickets']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($scope === 'all' || $scope === 'documents'): ?>
            <section class="card admin-data-card search-results-card">
                <div class="card-header border-0">
                    <div>
                        <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($srt['documents']); ?></p>
                        <span><?php echo htmlspecialchars($srt['documents_sub']); ?></span>
                    </div>
                    <span class="badge rounded-pill dashboard-soft-badge"><?php echo (int)($counts['documents'] ?? 0); ?> <?php echo htmlspecialchars($srt['found']); ?></span>
                </div>
                <div class="card-body">
                    <?php if (!empty($results['documents'])): ?>
                        <div class="search-result-list">
                            <?php foreach ($results['documents'] as $document): ?>
                                <a class="search-result-item dashboard-hoverlift" href="/documents/<?php echo (int)$document['id']; ?>/download">
                                    <div class="search-result-item__top">
                                        <strong><?php echo htmlspecialchars((string)($document['filename_original'] ?? $srt['documents'])); ?></strong>
                                        <span class="search-result-item__meta"><?php echo round(((int)($document['size'] ?? 0)) / 1024, 1); ?> KB</span>
                                    </div>
                                    <div class="search-result-item__sub">
                                        <span><?php echo htmlspecialchars((string)($document['mime'] ?? '-')); ?></span>
                                        <?php if (!empty($document['customer_name'])): ?><span><?php echo htmlspecialchars((string)$document['customer_name']); ?></span><?php endif; ?>
                                    </div>
                                    <small><?php echo htmlspecialchars(Locale::formatDateTime($document['created_at'] ?? '')); ?></small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="dashboard-empty-state">
                            <i class="fas fa-file-lines"></i>
                            <p class="mb-0"><?php echo htmlspecialchars($srt['empty_documents']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ((Auth::isAdmin() || Auth::isOperator()) && RolePermissions::canCurrent('customers_view') && ($scope === 'all' || $scope === 'customers')): ?>
            <section class="card admin-data-card search-results-card">
                <div class="card-header border-0">
                    <div>
                        <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($srt['customers']); ?></p>
                        <span><?php echo htmlspecialchars($srt['customers_sub']); ?></span>
                    </div>
                    <span class="badge rounded-pill dashboard-soft-badge"><?php echo (int)($counts['customers'] ?? 0); ?> <?php echo htmlspecialchars($srt['found']); ?></span>
                </div>
                <div class="card-body">
                    <?php if (!empty($results['customers'])): ?>
                        <div class="search-result-list">
                            <?php foreach ($results['customers'] as $customer): ?>
                                <a class="search-result-item dashboard-hoverlift" href="/admin/users?<?php echo http_build_query(['q' => (string)($customer['email'] ?? $customer['name'] ?? ''), 'role' => 'customer']); ?>">
                                    <div class="search-result-item__top">
                                        <strong><?php echo htmlspecialchars((string)($customer['name'] ?? $srt['customers'])); ?></strong>
                                        <span class="search-result-item__meta"><?php echo htmlspecialchars((string)($customer['status'] ?? 'active')); ?></span>
                                    </div>
                                    <div class="search-result-item__sub">
                                        <span><?php echo htmlspecialchars((string)($customer['email'] ?? '-')); ?></span>
                                        <?php if (!empty($customer['phone'])): ?><span><?php echo htmlspecialchars((string)$customer['phone']); ?></span><?php endif; ?>
                                    </div>
                                    <small><?php echo htmlspecialchars(Locale::formatDateTime($customer['created_at'] ?? '')); ?></small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="dashboard-empty-state">
                            <i class="fas fa-users"></i>
                            <p class="mb-0"><?php echo htmlspecialchars($srt['empty_customers']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!Auth::isCustomer() && RolePermissions::canCurrent('sales_view') && ($scope === 'all' || $scope === 'sales')): ?>
            <section class="card admin-data-card search-results-card">
                <div class="card-header border-0">
                    <div>
                        <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($srt['sales']); ?></p>
                        <span><?php echo htmlspecialchars($srt['sales_sub']); ?></span>
                    </div>
                    <span class="badge rounded-pill dashboard-soft-badge"><?php echo (int)($counts['sales'] ?? 0); ?> <?php echo htmlspecialchars($srt['found']); ?></span>
                </div>
                <div class="card-body">
                    <?php if (!empty($results['sales'])): ?>
                        <div class="search-result-list">
                            <?php foreach ($results['sales'] as $salesItem): ?>
                                <a class="search-result-item dashboard-hoverlift" href="<?php echo htmlspecialchars((string)($salesItem['href'] ?? '/sales')); ?>">
                                    <div class="search-result-item__top">
                                        <strong><?php echo htmlspecialchars((string)($salesItem['title'] ?? $srt['sales'])); ?></strong>
                                        <span class="search-result-item__meta"><?php echo htmlspecialchars((string)($salesItem['meta'] ?? '-')); ?></span>
                                    </div>
                                    <div class="search-result-item__sub">
                                        <span><?php echo htmlspecialchars((string)($salesItem['subtitle'] ?? '-')); ?></span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="dashboard-empty-state">
                            <i class="fas fa-briefcase"></i>
                            <p class="mb-0"><?php echo htmlspecialchars($srt['empty_sales']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
