<?php
use Core\Locale;
use Core\RolePermissions;

$documentsBoardText = [
    'it' => [
        'page_title' => 'Documents Board',
        'eyebrow' => 'Documents board',
        'title' => 'Vista documentale orientata ai tipi di contenuto',
        'lead' => 'Un workspace visivo per monitorare il patrimonio documentale per formato e ultimi caricamenti, con accesso diretto ai file piu importanti.',
        'table_view' => 'Vista tabellare',
        'new_document' => 'Nuovo documento',
        'columns' => [
            'pdf' => 'PDF',
            'image' => 'Immagini',
            'office' => 'Office',
            'recent' => 'Ultimi upload',
        ],
        'documents_count' => 'documenti',
        'shared_archive' => 'Archivio condiviso',
        'document_fallback' => 'Documento',
        'column_empty' => 'Nessun documento in questa colonna.',
        'size_unit' => 'KB',
    ],
    'en' => [
        'page_title' => 'Documents Board',
        'eyebrow' => 'Documents board',
        'title' => 'Document view organized by content type',
        'lead' => 'A visual workspace to monitor document assets by format and latest uploads, with direct access to the most important files.',
        'table_view' => 'Table view',
        'new_document' => 'New document',
        'columns' => [
            'pdf' => 'PDF',
            'image' => 'Images',
            'office' => 'Office',
            'recent' => 'Latest uploads',
        ],
        'documents_count' => 'documents',
        'shared_archive' => 'Shared archive',
        'document_fallback' => 'Document',
        'column_empty' => 'No documents in this column.',
        'size_unit' => 'KB',
    ],
    'fr' => [
        'page_title' => 'Board documents',
        'eyebrow' => 'Board documents',
        'title' => 'Vue documentaire orientee par type de contenu',
        'lead' => 'Un workspace visuel pour suivre le patrimoine documentaire par format et derniers televersements, avec acces direct aux fichiers les plus importants.',
        'table_view' => 'Vue tableau',
        'new_document' => 'Nouveau document',
        'columns' => [
            'pdf' => 'PDF',
            'image' => 'Images',
            'office' => 'Office',
            'recent' => 'Derniers uploads',
        ],
        'documents_count' => 'documents',
        'shared_archive' => 'Archive partagee',
        'document_fallback' => 'Document',
        'column_empty' => 'Aucun document dans cette colonne.',
        'size_unit' => 'KB',
    ],
    'es' => [
        'page_title' => 'Board de documentos',
        'eyebrow' => 'Board de documentos',
        'title' => 'Vista documental orientada por tipo de contenido',
        'lead' => 'Un workspace visual para supervisar el patrimonio documental por formato y ultimas cargas, con acceso directo a los archivos mas importantes.',
        'table_view' => 'Vista tabular',
        'new_document' => 'Nuevo documento',
        'columns' => [
            'pdf' => 'PDF',
            'image' => 'Imagenes',
            'office' => 'Office',
            'recent' => 'Ultimas cargas',
        ],
        'documents_count' => 'documentos',
        'shared_archive' => 'Archivo compartido',
        'document_fallback' => 'Documento',
        'column_empty' => 'No hay documentos en esta columna.',
        'size_unit' => 'KB',
    ],
];

$dbt = $documentsBoardText[Locale::current()] ?? $documentsBoardText['it'];
$pageTitle = $dbt['page_title'];

$boardDocuments = (array)($boardDocuments ?? []);
$columns = [
    'pdf' => ['label' => $dbt['columns']['pdf'], 'icon' => 'fa-file-pdf', 'badge' => 'bg-danger'],
    'image' => ['label' => $dbt['columns']['image'], 'icon' => 'fa-image', 'badge' => 'bg-info text-dark'],
    'office' => ['label' => $dbt['columns']['office'], 'icon' => 'fa-file-word', 'badge' => 'bg-primary'],
    'recent' => ['label' => $dbt['columns']['recent'], 'icon' => 'fa-clock', 'badge' => 'bg-success'],
];

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($dbt['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($dbt['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($dbt['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="/documents" class="btn btn-outline-secondary"><?php echo htmlspecialchars($dbt['table_view']); ?></a>
        <?php if (RolePermissions::canCurrent('documents_upload')): ?>
            <a href="/documents/upload" class="btn btn-primary"><i class="fas fa-upload me-2"></i><?php echo htmlspecialchars($dbt['new_document']); ?></a>
        <?php endif; ?>
    </div>
</section>

<div class="documents-board">
    <?php foreach ($columns as $key => $column): ?>
        <?php $items = (array)($boardDocuments[$key] ?? []); ?>
        <section class="documents-board__column dashboard-reveal is-visible">
            <header class="documents-board__head">
                <div>
                    <span class="documents-board__title"><i class="fas <?php echo htmlspecialchars((string)$column['icon']); ?> me-2"></i><?php echo htmlspecialchars((string)$column['label']); ?></span>
                    <small><?php echo count($items); ?> <?php echo htmlspecialchars($dbt['documents_count']); ?></small>
                </div>
                <span class="badge <?php echo htmlspecialchars((string)$column['badge']); ?>"><?php echo count($items); ?></span>
            </header>
            <div class="documents-board__body">
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <?php
                        $sizeLabel = round(((int)($item['size'] ?? 0)) / 1024, 1) . ' ' . $dbt['size_unit'];
                        $mimeLabel = (string)($item['mime'] ?? '-');
                        $customerLabel = (string)($item['customer_name'] ?? $dbt['shared_archive']);
                        ?>
                        <a class="documents-board__card dashboard-hoverlift" href="/documents/<?php echo (int)$item['id']; ?>/download">
                            <div class="documents-board__card-top">
                                <strong><?php echo htmlspecialchars((string)($item['filename_original'] ?? $dbt['document_fallback'])); ?></strong>
                                <span class="documents-board__size"><?php echo htmlspecialchars($sizeLabel); ?></span>
                            </div>
                            <div class="documents-board__meta">
                                <span class="documents-board__chip"><?php echo htmlspecialchars($mimeLabel); ?></span>
                                <span class="documents-board__chip"><?php echo htmlspecialchars($customerLabel); ?></span>
                            </div>
                            <small><?php echo htmlspecialchars(Locale::formatDateTime($item['created_at'] ?? '')); ?></small>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="documents-board__empty"><?php echo htmlspecialchars($dbt['column_empty']); ?></div>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
