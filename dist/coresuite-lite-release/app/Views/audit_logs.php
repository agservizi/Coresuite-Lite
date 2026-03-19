<?php
use Core\Locale;

$auditText = [
    'it' => [
        'page_title' => 'Audit Logs',
        'eyebrow' => 'Audit log center',
        'title' => 'Storico eventi, attori e oggetti del workspace',
        'lead' => 'Una vista unica per tracciare cosa è successo, su quale entita e da parte di chi, con filtri rapidi e lettura immediata.',
        'back_to_reports' => 'Torna ai reports',
        'events' => 'eventi',
        'filtered_events' => 'Eventi filtrati',
        'filtered_events_meta' => 'totale storico per il filtro corrente',
        'last_7_days' => 'Ultimi 7 giorni',
        'last_7_days_meta' => 'attivita recente registrata',
        'unique_actors' => 'Attori unici',
        'unique_actors_meta' => 'utenti che hanno generato log',
        'in_page' => 'In pagina',
        'in_page_meta' => 'record caricati nella vista',
        'action_mix_eyebrow' => 'Action mix',
        'action_mix_title' => 'Le azioni piu frequenti',
        'action_mix_empty' => 'Nessuna azione registrata per questo filtro.',
        'entity_mix_eyebrow' => 'Entity mix',
        'entity_mix_title' => 'Oggetti piu coinvolti',
        'entity_mix_empty' => 'Nessuna entita registrata per questo filtro.',
        'stream_eyebrow' => 'Audit stream',
        'stream_title' => 'Storico completo degli eventi',
        'search_placeholder' => 'Cerca attore, azione, entita, IP...',
        'all_actions' => 'Tutte le azioni',
        'action_create' => 'Create',
        'action_update' => 'Update',
        'action_delete' => 'Delete',
        'action_login' => 'Login',
        'action_logout' => 'Logout',
        'all_entities' => 'Tutte le entita',
        'entity_users' => 'Users',
        'entity_tickets' => 'Tickets',
        'entity_documents' => 'Documents',
        'table_event' => 'Evento',
        'table_actor' => 'Attore',
        'table_entity' => 'Entita',
        'table_ip' => 'IP',
        'table_timestamp' => 'Timestamp',
        'log_id' => 'ID log #',
        'system' => 'Sistema',
        'actor_id' => 'Actor ID ',
        'entity_fallback' => 'elemento',
        'event_fallback' => 'evento',
        'none' => '-',
        'empty' => 'Nessun evento audit trovato.',
        'pagination' => 'Paginazione',
        'previous' => 'Precedente',
        'next' => 'Successiva',
    ],
    'en' => [
        'page_title' => 'Audit Logs',
        'eyebrow' => 'Audit log center',
        'title' => 'History of events, actors, and workspace objects',
        'lead' => 'A single view to track what happened, on which entity, and by whom, with quick filters and instant readability.',
        'back_to_reports' => 'Back to reports',
        'events' => 'events',
        'filtered_events' => 'Filtered events',
        'filtered_events_meta' => 'historical total for the current filter',
        'last_7_days' => 'Last 7 days',
        'last_7_days_meta' => 'recent recorded activity',
        'unique_actors' => 'Unique actors',
        'unique_actors_meta' => 'users who generated logs',
        'in_page' => 'On page',
        'in_page_meta' => 'records loaded in the view',
        'action_mix_eyebrow' => 'Action mix',
        'action_mix_title' => 'Most frequent actions',
        'action_mix_empty' => 'No actions recorded for this filter.',
        'entity_mix_eyebrow' => 'Entity mix',
        'entity_mix_title' => 'Most involved objects',
        'entity_mix_empty' => 'No entities recorded for this filter.',
        'stream_eyebrow' => 'Audit stream',
        'stream_title' => 'Complete event history',
        'search_placeholder' => 'Search actor, action, entity, IP...',
        'all_actions' => 'All actions',
        'action_create' => 'Create',
        'action_update' => 'Update',
        'action_delete' => 'Delete',
        'action_login' => 'Login',
        'action_logout' => 'Logout',
        'all_entities' => 'All entities',
        'entity_users' => 'Users',
        'entity_tickets' => 'Tickets',
        'entity_documents' => 'Documents',
        'table_event' => 'Event',
        'table_actor' => 'Actor',
        'table_entity' => 'Entity',
        'table_ip' => 'IP',
        'table_timestamp' => 'Timestamp',
        'log_id' => 'Log ID #',
        'system' => 'System',
        'actor_id' => 'Actor ID ',
        'entity_fallback' => 'item',
        'event_fallback' => 'event',
        'none' => '-',
        'empty' => 'No audit events found.',
        'pagination' => 'Pagination',
        'previous' => 'Previous',
        'next' => 'Next',
    ],
    'fr' => [
        'page_title' => 'Journaux d audit',
        'eyebrow' => 'Centre d audit',
        'title' => 'Historique des evenements, acteurs et objets du workspace',
        'lead' => 'Une vue unique pour suivre ce qui s est passe, sur quelle entite et par qui, avec des filtres rapides et une lecture immediate.',
        'back_to_reports' => 'Retour aux rapports',
        'events' => 'evenements',
        'filtered_events' => 'Evenements filtres',
        'filtered_events_meta' => 'total historique pour le filtre courant',
        'last_7_days' => '7 derniers jours',
        'last_7_days_meta' => 'activite recente enregistree',
        'unique_actors' => 'Acteurs uniques',
        'unique_actors_meta' => 'utilisateurs ayant genere des logs',
        'in_page' => 'Dans la page',
        'in_page_meta' => 'enregistrements charges dans la vue',
        'action_mix_eyebrow' => 'Mix d actions',
        'action_mix_title' => 'Les actions les plus frequentes',
        'action_mix_empty' => 'Aucune action enregistree pour ce filtre.',
        'entity_mix_eyebrow' => 'Mix d entites',
        'entity_mix_title' => 'Objets les plus impliques',
        'entity_mix_empty' => 'Aucune entite enregistree pour ce filtre.',
        'stream_eyebrow' => 'Flux d audit',
        'stream_title' => 'Historique complet des evenements',
        'search_placeholder' => 'Rechercher acteur, action, entite, IP...',
        'all_actions' => 'Toutes les actions',
        'action_create' => 'Creation',
        'action_update' => 'Mise a jour',
        'action_delete' => 'Suppression',
        'action_login' => 'Connexion',
        'action_logout' => 'Deconnexion',
        'all_entities' => 'Toutes les entites',
        'entity_users' => 'Utilisateurs',
        'entity_tickets' => 'Tickets',
        'entity_documents' => 'Documents',
        'table_event' => 'Evenement',
        'table_actor' => 'Acteur',
        'table_entity' => 'Entite',
        'table_ip' => 'IP',
        'table_timestamp' => 'Horodatage',
        'log_id' => 'ID log #',
        'system' => 'Systeme',
        'actor_id' => 'ID acteur ',
        'entity_fallback' => 'element',
        'event_fallback' => 'evenement',
        'none' => '-',
        'empty' => 'Aucun evenement d audit trouve.',
        'pagination' => 'Pagination',
        'previous' => 'Precedente',
        'next' => 'Suivante',
    ],
    'es' => [
        'page_title' => 'Registros de auditoria',
        'eyebrow' => 'Centro de auditoria',
        'title' => 'Historial de eventos, actores y objetos del workspace',
        'lead' => 'Una vista unica para rastrear que ocurrio, sobre que entidad y por quien, con filtros rapidos y lectura inmediata.',
        'back_to_reports' => 'Volver a reportes',
        'events' => 'eventos',
        'filtered_events' => 'Eventos filtrados',
        'filtered_events_meta' => 'total historico para el filtro actual',
        'last_7_days' => 'Ultimos 7 dias',
        'last_7_days_meta' => 'actividad reciente registrada',
        'unique_actors' => 'Actores unicos',
        'unique_actors_meta' => 'usuarios que generaron logs',
        'in_page' => 'En pagina',
        'in_page_meta' => 'registros cargados en la vista',
        'action_mix_eyebrow' => 'Mix de acciones',
        'action_mix_title' => 'Las acciones mas frecuentes',
        'action_mix_empty' => 'No hay acciones registradas para este filtro.',
        'entity_mix_eyebrow' => 'Mix de entidades',
        'entity_mix_title' => 'Objetos mas involucrados',
        'entity_mix_empty' => 'No hay entidades registradas para este filtro.',
        'stream_eyebrow' => 'Flujo de auditoria',
        'stream_title' => 'Historial completo de eventos',
        'search_placeholder' => 'Buscar actor, accion, entidad, IP...',
        'all_actions' => 'Todas las acciones',
        'action_create' => 'Creacion',
        'action_update' => 'Actualizacion',
        'action_delete' => 'Eliminacion',
        'action_login' => 'Login',
        'action_logout' => 'Logout',
        'all_entities' => 'Todas las entidades',
        'entity_users' => 'Usuarios',
        'entity_tickets' => 'Tickets',
        'entity_documents' => 'Documentos',
        'table_event' => 'Evento',
        'table_actor' => 'Actor',
        'table_entity' => 'Entidad',
        'table_ip' => 'IP',
        'table_timestamp' => 'Timestamp',
        'log_id' => 'ID log #',
        'system' => 'Sistema',
        'actor_id' => 'Actor ID ',
        'entity_fallback' => 'elemento',
        'event_fallback' => 'evento',
        'none' => '-',
        'empty' => 'No se encontraron eventos de auditoria.',
        'pagination' => 'Paginacion',
        'previous' => 'Anterior',
        'next' => 'Siguiente',
    ],
];

$at = $auditText[Locale::current()] ?? $auditText['it'];
$pageTitle = $at['page_title'];
$logs = (array)($logs ?? []);
$search = (string)($search ?? '');
$actionFilter = (string)($actionFilter ?? '');
$entityFilter = (string)($entityFilter ?? '');
$summary = (array)($summary ?? []);
$actionMix = (array)($actionMix ?? []);
$entityMix = (array)($entityMix ?? []);

$totalEvents = (int)($summary['total_events'] ?? 0);
$recentEvents = (int)($summary['recent_events'] ?? 0);
$activeActors = (int)($summary['active_actors'] ?? 0);
$visibleCount = count($logs);

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($at['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($at['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($at['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/reports" class="btn btn-outline-secondary"><?php echo htmlspecialchars($at['back_to_reports']); ?></a>
        <span class="admin-section-chip"><i class="fas fa-shield-alt"></i><?php echo $totalEvents; ?> <?php echo htmlspecialchars($at['events']); ?></span>
    </div>
</section>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($at['filtered_events']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $totalEvents; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($at['filtered_events_meta']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($at['last_7_days']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $recentEvents; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($at['last_7_days_meta']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($at['unique_actors']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $activeActors; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($at['unique_actors_meta']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($at['in_page']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $visibleCount; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($at['in_page_meta']); ?></span>
            </div>
        </div>
    </div>
</div>

<div class="audit-log-grid mb-4">
    <section class="card admin-data-card">
        <div class="card-header border-0">
            <div>
                <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($at['action_mix_eyebrow']); ?></p>
                <span><?php echo htmlspecialchars($at['action_mix_title']); ?></span>
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($actionMix)): ?>
                <div class="audit-log-stack">
                    <?php foreach ($actionMix as $item): ?>
                        <div class="audit-log-pillline">
                            <strong><?php echo htmlspecialchars((string)($item['action_label'] ?? ($item['action'] ?? $at['event_fallback']))); ?></strong>
                            <span><?php echo (int)($item['total'] ?? 0); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="dashboard-empty-state">
                    <i class="fas fa-wave-square"></i>
                    <p class="mb-0"><?php echo htmlspecialchars($at['action_mix_empty']); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="card admin-data-card">
        <div class="card-header border-0">
            <div>
                <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($at['entity_mix_eyebrow']); ?></p>
                <span><?php echo htmlspecialchars($at['entity_mix_title']); ?></span>
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($entityMix)): ?>
                <div class="audit-log-stack">
                    <?php foreach ($entityMix as $item): ?>
                        <div class="audit-log-pillline audit-log-pillline--soft">
                            <strong><?php echo htmlspecialchars((string)($item['entity_label'] ?? ($item['entity'] ?? $at['entity_fallback']))); ?></strong>
                            <span><?php echo (int)($item['total'] ?? 0); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="dashboard-empty-state">
                    <i class="fas fa-cubes"></i>
                    <p class="mb-0"><?php echo htmlspecialchars($at['entity_mix_empty']); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
 </div>

<div class="card admin-data-card">
    <div class="card-header border-0 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($at['stream_eyebrow']); ?></p>
            <span><?php echo htmlspecialchars($at['stream_title']); ?></span>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="admin-filter-shell">
            <div class="admin-filter-shell__top">
                <form method="GET" action="/audit-logs" class="admin-searchbar">
                    <input class="form-control" type="text" name="q" placeholder="<?php echo htmlspecialchars($at['search_placeholder']); ?>" value="<?php echo htmlspecialchars($search); ?>">
                    <?php if ($actionFilter !== ''): ?><input type="hidden" name="action" value="<?php echo htmlspecialchars($actionFilter); ?>"><?php endif; ?>
                    <?php if ($entityFilter !== ''): ?><input type="hidden" name="entity" value="<?php echo htmlspecialchars($entityFilter); ?>"><?php endif; ?>
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="admin-filter-shell__groups">
                <div class="admin-pillbar">
                    <a class="admin-pill <?php echo $actionFilter === '' ? 'is-active' : ''; ?>" href="/audit-logs<?php echo $search !== '' || $entityFilter !== '' ? '?' . http_build_query(array_filter(['q' => $search, 'entity' => $entityFilter])) : ''; ?>"><?php echo htmlspecialchars($at['all_actions']); ?></a>
                    <a class="admin-pill <?php echo $actionFilter === 'create' ? 'is-active' : ''; ?>" href="/audit-logs?<?php echo http_build_query(array_filter(['q' => $search, 'action' => 'create', 'entity' => $entityFilter])); ?>"><?php echo htmlspecialchars($at['action_create']); ?></a>
                    <a class="admin-pill <?php echo $actionFilter === 'update' ? 'is-active' : ''; ?>" href="/audit-logs?<?php echo http_build_query(array_filter(['q' => $search, 'action' => 'update', 'entity' => $entityFilter])); ?>"><?php echo htmlspecialchars($at['action_update']); ?></a>
                    <a class="admin-pill <?php echo $actionFilter === 'delete' ? 'is-active' : ''; ?>" href="/audit-logs?<?php echo http_build_query(array_filter(['q' => $search, 'action' => 'delete', 'entity' => $entityFilter])); ?>"><?php echo htmlspecialchars($at['action_delete']); ?></a>
                    <a class="admin-pill <?php echo $actionFilter === 'login' ? 'is-active' : ''; ?>" href="/audit-logs?<?php echo http_build_query(array_filter(['q' => $search, 'action' => 'login', 'entity' => $entityFilter])); ?>"><?php echo htmlspecialchars($at['action_login']); ?></a>
                    <a class="admin-pill <?php echo $actionFilter === 'logout' ? 'is-active' : ''; ?>" href="/audit-logs?<?php echo http_build_query(array_filter(['q' => $search, 'action' => 'logout', 'entity' => $entityFilter])); ?>"><?php echo htmlspecialchars($at['action_logout']); ?></a>
                </div>
                <div class="admin-pillbar">
                    <a class="admin-pill <?php echo $entityFilter === '' ? 'is-active' : ''; ?>" href="/audit-logs<?php echo $search !== '' || $actionFilter !== '' ? '?' . http_build_query(array_filter(['q' => $search, 'action' => $actionFilter])) : ''; ?>"><?php echo htmlspecialchars($at['all_entities']); ?></a>
                    <a class="admin-pill <?php echo $entityFilter === 'user' ? 'is-active' : ''; ?>" href="/audit-logs?<?php echo http_build_query(array_filter(['q' => $search, 'action' => $actionFilter, 'entity' => 'user'])); ?>"><?php echo htmlspecialchars($at['entity_users']); ?></a>
                    <a class="admin-pill <?php echo $entityFilter === 'ticket' ? 'is-active' : ''; ?>" href="/audit-logs?<?php echo http_build_query(array_filter(['q' => $search, 'action' => $actionFilter, 'entity' => 'ticket'])); ?>"><?php echo htmlspecialchars($at['entity_tickets']); ?></a>
                    <a class="admin-pill <?php echo $entityFilter === 'document' ? 'is-active' : ''; ?>" href="/audit-logs?<?php echo http_build_query(array_filter(['q' => $search, 'action' => $actionFilter, 'entity' => 'document'])); ?>"><?php echo htmlspecialchars($at['entity_documents']); ?></a>
                </div>
            </div>
        </div>
        <div class="table-responsive admin-table-wrap">
            <table class="table table-hover align-middle mb-0 admin-enhanced-table">
                <thead class="table-light">
                    <tr>
                        <th><?php echo htmlspecialchars($at['table_event']); ?></th>
                        <th><?php echo htmlspecialchars($at['table_actor']); ?></th>
                        <th><?php echo htmlspecialchars($at['table_entity']); ?></th>
                        <th>IP</th>
                        <th><?php echo htmlspecialchars($at['table_timestamp']); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        <span class="fw-semibold"><?php echo htmlspecialchars((string)($log['action_label'] ?? ($log['action'] ?? $at['event_fallback']))); ?></span>
                                        <span class="admin-table-subtitle"><?php echo htmlspecialchars($at['log_id']); ?><?php echo (int)($log['id'] ?? 0); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-table-primary">
                                        <span class="fw-semibold"><?php echo htmlspecialchars((string)($log['actor_name'] ?? $at['system'])); ?></span>
                                        <span class="admin-table-subtitle"><?php echo htmlspecialchars((string)($log['actor_email'] ?? ($at['actor_id'] . (int)($log['actor_id'] ?? 0)))); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-table-primary">
                                        <span class="fw-semibold"><?php echo htmlspecialchars((string)($log['entity_label'] ?? ($log['entity'] ?? $at['entity_fallback']))); ?> #<?php echo (int)($log['entity_id'] ?? 0); ?></span>
                                        <span class="admin-table-subtitle"><?php echo htmlspecialchars(substr((string)($log['user_agent'] ?? $at['none']), 0, 80)); ?></span>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars((string)($log['ip'] ?? $at['none'])); ?></td>
                                <td><?php echo htmlspecialchars(Locale::formatDateTime($log['created_at'] ?? '')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-0 border-0">
                                <div class="dashboard-empty-state m-3">
                                    <i class="fas fa-database"></i>
                                    <p class="mb-0"><?php echo htmlspecialchars($at['empty']); ?></p>
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
    <?php
    $queryBase = [];
    if ($search !== '') $queryBase['q'] = $search;
    if ($actionFilter !== '') $queryBase['action'] = $actionFilter;
    if ($entityFilter !== '') $queryBase['entity'] = $entityFilter;
    $qs = ($queryBase ? '&' . http_build_query($queryBase) : '');
    ?>
    <nav aria-label="<?php echo htmlspecialchars($at['pagination']); ?>" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item<?php echo $currentPage <= 1 ? ' disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $currentPage <= 1 ? '#' : '/audit-logs?page=' . ($currentPage - 1) . $qs; ?>"><?php echo htmlspecialchars($at['previous']); ?></a>
            </li>
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <li class="page-item<?php echo $p == $currentPage ? ' active' : ''; ?>">
                    <a class="page-link" href="/audit-logs?page=<?php echo $p . $qs; ?>"><?php echo $p; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item<?php echo $currentPage >= $totalPages ? ' disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $currentPage >= $totalPages ? '#' : '/audit-logs?page=' . ($currentPage + 1) . $qs; ?>"><?php echo htmlspecialchars($at['next']); ?></a>
            </li>
        </ul>
    </nav>
<?php endif; ?>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
