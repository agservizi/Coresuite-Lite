<?php
use Core\Auth;
use Core\Locale;
use Core\RolePermissions;

$locale = Locale::current();
$documentsText = [
    'it' => [
        'page_title' => 'Documenti',
        'hero_title' => 'Archivio clienti piu ordinato e leggibile',
        'hero_lead' => 'Una libreria centrale per trovare rapidamente file, formati e dimensioni senza perdere contesto operativo.',
        'open_board' => 'Apri documents board',
        'new_document' => 'Nuovo documento',
        'visible_files' => 'file visibili',
        'current_archive' => 'Archivio corrente',
        'documents_in_list' => 'documenti disponibili in elenco',
        'total_size' => 'Peso totale',
        'visible_volume' => 'volume visibile nella pagina',
        'pdf' => 'PDF',
        'pdf_meta' => 'documenti in formato PDF',
        'images' => 'Immagini',
        'images_meta' => 'asset visuali presenti',
        'library_view' => 'Library view',
        'customer_library' => 'Archivio documentale clienti',
        'search_placeholder' => 'Cerca file o cliente',
        'all_types' => 'Tutti i tipi',
        'office' => 'Office',
        'all_customers' => 'Tutti i clienti',
        'file_name' => 'Nome file',
        'size' => 'Dimensione',
        'date' => 'Data',
        'actions' => 'Azioni',
        'document_in_archive' => 'Documento in archivio',
        'download' => 'Scarica',
        'delete_confirm' => 'Eliminare il documento?',
        'no_documents' => 'Nessun documento disponibile.',
        'pagination' => 'Paginazione',
        'previous' => 'Precedente',
        'next' => 'Successiva',
    ],
    'en' => [
        'page_title' => 'Documents',
        'hero_title' => 'A cleaner and easier-to-read customer archive',
        'hero_lead' => 'A central library to quickly find files, formats and sizes without losing operational context.',
        'open_board' => 'Open documents board',
        'new_document' => 'New document',
        'visible_files' => 'visible files',
        'current_archive' => 'Current archive',
        'documents_in_list' => 'documents available in the list',
        'total_size' => 'Total size',
        'visible_volume' => 'visible volume on this page',
        'pdf' => 'PDF',
        'pdf_meta' => 'documents in PDF format',
        'images' => 'Images',
        'images_meta' => 'visual assets available',
        'library_view' => 'Library view',
        'customer_library' => 'Customer document archive',
        'search_placeholder' => 'Search file or customer',
        'all_types' => 'All types',
        'office' => 'Office',
        'all_customers' => 'All customers',
        'file_name' => 'File name',
        'size' => 'Size',
        'date' => 'Date',
        'actions' => 'Actions',
        'document_in_archive' => 'Document in archive',
        'download' => 'Download',
        'delete_confirm' => 'Delete this document?',
        'no_documents' => 'No documents available.',
        'pagination' => 'Pagination',
        'previous' => 'Previous',
        'next' => 'Next',
    ],
    'fr' => [
        'page_title' => 'Documents',
        'hero_title' => 'Archive clients plus ordonnee et lisible',
        'hero_lead' => 'Une bibliotheque centrale pour retrouver rapidement fichiers, formats et tailles sans perdre le contexte operationnel.',
        'open_board' => 'Ouvrir le board documents',
        'new_document' => 'Nouveau document',
        'visible_files' => 'fichiers visibles',
        'current_archive' => 'Archive courante',
        'documents_in_list' => 'documents disponibles dans la liste',
        'total_size' => 'Poids total',
        'visible_volume' => 'volume visible sur la page',
        'pdf' => 'PDF',
        'pdf_meta' => 'documents au format PDF',
        'images' => 'Images',
        'images_meta' => 'ressources visuelles presentes',
        'library_view' => 'Vue bibliotheque',
        'customer_library' => 'Archive documentaire clients',
        'search_placeholder' => 'Rechercher fichier ou client',
        'all_types' => 'Tous les types',
        'office' => 'Office',
        'all_customers' => 'Tous les clients',
        'file_name' => 'Nom du fichier',
        'size' => 'Taille',
        'date' => 'Date',
        'actions' => 'Actions',
        'document_in_archive' => 'Document dans l archive',
        'download' => 'Telecharger',
        'delete_confirm' => 'Supprimer le document ?',
        'no_documents' => 'Aucun document disponible.',
        'pagination' => 'Pagination',
        'previous' => 'Precedent',
        'next' => 'Suivante',
    ],
    'es' => [
        'page_title' => 'Documentos',
        'hero_title' => 'Archivo de clientes mas ordenado y legible',
        'hero_lead' => 'Una biblioteca central para encontrar rapidamente archivos, formatos y tamanos sin perder el contexto operativo.',
        'open_board' => 'Abrir board de documentos',
        'new_document' => 'Nuevo documento',
        'visible_files' => 'archivos visibles',
        'current_archive' => 'Archivo actual',
        'documents_in_list' => 'documentos disponibles en la lista',
        'total_size' => 'Peso total',
        'visible_volume' => 'volumen visible en la pagina',
        'pdf' => 'PDF',
        'pdf_meta' => 'documentos en formato PDF',
        'images' => 'Imagenes',
        'images_meta' => 'recursos visuales presentes',
        'library_view' => 'Vista de biblioteca',
        'customer_library' => 'Archivo documental de clientes',
        'search_placeholder' => 'Buscar archivo o cliente',
        'all_types' => 'Todos los tipos',
        'office' => 'Office',
        'all_customers' => 'Todos los clientes',
        'file_name' => 'Nombre del archivo',
        'size' => 'Tamano',
        'date' => 'Fecha',
        'actions' => 'Acciones',
        'document_in_archive' => 'Documento en archivo',
        'download' => 'Descargar',
        'delete_confirm' => 'Eliminar el documento?',
        'no_documents' => 'No hay documentos disponibles.',
        'pagination' => 'Paginacion',
        'previous' => 'Anterior',
        'next' => 'Siguiente',
    ],
];
$dt = $documentsText[$locale] ?? $documentsText['it'];
$pageTitle = $dt['page_title'];

$documents = (array)($documents ?? []);
$totalDocuments = count($documents);
$totalSize = 0;
$pdfCount = 0;
$imageCount = 0;

foreach ($documents as $docCounter) {
    $mimeCounter = (string)($docCounter['mime'] ?? '');
    $totalSize += (int)($docCounter['size'] ?? 0);

    if (strpos($mimeCounter, 'pdf') !== false) {
        $pdfCount++;
    }

    if (strpos($mimeCounter, 'image/') === 0) {
        $imageCount++;
    }
}

$sizeLabel = $totalSize > 0 ? number_format($totalSize / 1024 / 1024, 1, ',', '.') . ' MB' : '0 MB';
$search = (string)($search ?? '');
$typeFilter = (string)($typeFilter ?? '');
$customerFilter = (int)($customerFilter ?? 0);
$documentQueryBase = [];
if ($search !== '') $documentQueryBase['q'] = $search;
if ($typeFilter !== '') $documentQueryBase['type'] = $typeFilter;
if ($customerFilter > 0) $documentQueryBase['customer'] = $customerFilter;
$documentQueryString = http_build_query($documentQueryBase);
$documentQuerySuffix = $documentQueryString !== '' ? '&' . $documentQueryString : '';

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow">Document hub</div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($dt['hero_title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($dt['hero_lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/documents/board" class="btn btn-outline-secondary"><?php echo htmlspecialchars($dt['open_board']); ?></a>
        <?php if (RolePermissions::canCurrent('documents_upload')): ?>
            <a href="/documents/upload" class="btn btn-primary"><i class="fas fa-upload me-2"></i><?php echo htmlspecialchars($dt['new_document']); ?></a>
        <?php endif; ?>
        <span class="admin-section-chip"><i class="fas fa-folder-open"></i><?php echo $totalDocuments; ?> <?php echo htmlspecialchars($dt['visible_files']); ?></span>
    </div>
</section>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($dt['current_archive']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $totalDocuments; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($dt['documents_in_list']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($dt['total_size']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $sizeLabel; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($dt['visible_volume']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($dt['pdf']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $pdfCount; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($dt['pdf_meta']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xxl-3">
        <div class="card admin-stat-card h-100">
            <div class="card-body">
                <span class="admin-stat-card__label"><?php echo htmlspecialchars($dt['images']); ?></span>
                <strong class="admin-stat-card__value"><?php echo $imageCount; ?></strong>
                <span class="admin-stat-card__meta"><?php echo htmlspecialchars($dt['images_meta']); ?></span>
            </div>
        </div>
    </div>
</div>

<div class="card admin-data-card">
    <div class="card-header border-0">
        <div>
            <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($dt['library_view']); ?></p>
            <span><?php echo htmlspecialchars($dt['customer_library']); ?></span>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="admin-filter-shell">
            <div class="admin-filter-shell__top">
                <form method="GET" action="/documents" class="admin-searchbar">
                    <input class="form-control" type="text" name="q" placeholder="<?php echo htmlspecialchars($dt['search_placeholder']); ?>" value="<?php echo htmlspecialchars($search); ?>">
                    <?php if ($typeFilter !== ''): ?><input type="hidden" name="type" value="<?php echo htmlspecialchars($typeFilter); ?>"><?php endif; ?>
                    <?php if ($customerFilter > 0): ?><input type="hidden" name="customer" value="<?php echo $customerFilter; ?>"><?php endif; ?>
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="admin-filter-shell__groups">
                <div class="admin-pillbar">
                    <a class="admin-pill <?php echo $typeFilter === '' ? 'is-active' : ''; ?>" href="/documents<?php echo $search !== '' || $customerFilter > 0 ? '?' . http_build_query(array_filter(['q' => $search, 'customer' => $customerFilter ?: null])) : ''; ?>"><?php echo htmlspecialchars($dt['all_types']); ?></a>
                    <a class="admin-pill <?php echo $typeFilter === 'pdf' ? 'is-active' : ''; ?>" href="/documents?<?php echo http_build_query(array_filter(['q' => $search, 'type' => 'pdf', 'customer' => $customerFilter ?: null])); ?>"><?php echo htmlspecialchars($dt['pdf']); ?></a>
                    <a class="admin-pill <?php echo $typeFilter === 'image' ? 'is-active' : ''; ?>" href="/documents?<?php echo http_build_query(array_filter(['q' => $search, 'type' => 'image', 'customer' => $customerFilter ?: null])); ?>"><?php echo htmlspecialchars($dt['images']); ?></a>
                    <a class="admin-pill <?php echo $typeFilter === 'office' ? 'is-active' : ''; ?>" href="/documents?<?php echo http_build_query(array_filter(['q' => $search, 'type' => 'office', 'customer' => $customerFilter ?: null])); ?>"><?php echo htmlspecialchars($dt['office']); ?></a>
                </div>
                <?php if (!empty($customers ?? [])): ?>
                    <div class="admin-pillbar">
                        <a class="admin-pill <?php echo $customerFilter === 0 ? 'is-active' : ''; ?>" href="/documents<?php echo $search !== '' || $typeFilter !== '' ? '?' . http_build_query(array_filter(['q' => $search, 'type' => $typeFilter])) : ''; ?>"><?php echo htmlspecialchars($dt['all_customers']); ?></a>
                        <?php foreach (($customers ?? []) as $customer): ?>
                            <a class="admin-pill <?php echo $customerFilter === (int)$customer['id'] ? 'is-active' : ''; ?>" href="/documents?<?php echo http_build_query(array_filter(['q' => $search, 'type' => $typeFilter, 'customer' => (int)$customer['id']])); ?>">
                                <?php echo htmlspecialchars((string)$customer['name']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill dashboard-soft-badge"><?php echo htmlspecialchars($dt['pdf']); ?> <?php echo $pdfCount; ?></span>
                    <span class="badge rounded-pill dashboard-soft-badge"><?php echo htmlspecialchars($dt['images']); ?> <?php echo $imageCount; ?></span>
                </div>
            </div>
        </div>
        <div class="table-responsive admin-table-wrap">
            <table class="table table-hover align-middle mb-0 admin-enhanced-table">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th><?php echo htmlspecialchars($dt['file_name']); ?></th>
                        <th>MIME</th>
                        <th><?php echo htmlspecialchars($dt['size']); ?></th>
                        <th><?php echo htmlspecialchars($dt['date']); ?></th>
                        <th class="text-end"><?php echo htmlspecialchars($dt['actions']); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($documents)): ?>
                        <?php foreach ($documents as $doc): ?>
                            <?php $sizeKB = round(((int)($doc['size'] ?? 0)) / 1024, 1); ?>
                            <tr>
                                <td class="admin-row-id"><?php echo (int)($doc['id'] ?? 0); ?></td>
                                <td>
                                    <div class="admin-table-primary">
                                        <span class="fw-semibold"><?php echo htmlspecialchars((string)($doc['filename_original'] ?? '-')); ?></span>
                                        <span class="admin-table-subtitle">
                                            <?php echo !empty($doc['customer_name']) ? htmlspecialchars((string)$doc['customer_name']) : htmlspecialchars($dt['document_in_archive']); ?>
                                        </span>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars((string)($doc['mime'] ?? '-')); ?></span></td>
                                <td><?php echo $sizeKB; ?> KB</td>
                                <td class="text-muted small"><?php echo htmlspecialchars(Locale::formatDateTime($doc['created_at'] ?? '', '-')); ?></td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a class="btn btn-sm btn-outline-secondary" href="/documents/<?php echo (int)($doc['id'] ?? 0); ?>/download">
                                            <i class="fas fa-download me-1"></i><?php echo htmlspecialchars($dt['download']); ?>
                                        </a>
                                        <?php if (RolePermissions::canCurrent('documents_upload')): ?>
                                            <form method="POST" action="/documents/<?php echo (int)($doc['id'] ?? 0); ?>/delete" onsubmit="return confirm('<?php echo htmlspecialchars($dt['delete_confirm'], ENT_QUOTES); ?>')">
                                                <?php echo CSRF::field(); ?>
                                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-0 border-0">
                                <div class="dashboard-empty-state m-3">
                                    <i class="fas fa-folder-open"></i>
                                    <p class="mb-0"><?php echo htmlspecialchars($dt['no_documents']); ?></p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$currentPage = $page ?? 1;
$totalPages = $totalPages ?? 1;
if ($totalPages > 1):
?>
    <nav aria-label="<?php echo htmlspecialchars($dt['pagination']); ?>" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item<?php echo $currentPage <= 1 ? ' disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $currentPage <= 1 ? '#' : '/documents?page=' . ($currentPage - 1) . $documentQuerySuffix; ?>"><?php echo htmlspecialchars($dt['previous']); ?></a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item<?php echo $i === $currentPage ? ' active' : ''; ?>">
                    <a class="page-link" href="/documents?page=<?php echo $i . $documentQuerySuffix; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item<?php echo $currentPage >= $totalPages ? ' disabled' : ''; ?>">
                <a class="page-link" href="<?php echo $currentPage >= $totalPages ? '#' : '/documents?page=' . ($currentPage + 1) . $documentQuerySuffix; ?>"><?php echo htmlspecialchars($dt['next']); ?></a>
            </li>
        </ul>
    </nav>
<?php
endif;

$content = ob_get_clean();

include __DIR__ . '/layout.php';
