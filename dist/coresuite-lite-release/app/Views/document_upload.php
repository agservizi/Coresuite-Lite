<?php
use Core\Locale;

$documentUploadText = [
    'it' => [
        'page_title' => 'Carica Documento',
        'eyebrow' => 'Upload center',
        'title' => 'Aggiungi un documento pronto per l archivio clienti',
        'lead' => 'Seleziona il cliente, carica il file corretto e arricchiscilo con note e tag per renderlo piu facile da ritrovare.',
        'back' => 'Torna ai documenti',
        'meta_archive' => 'Archive ready',
        'meta_searchable' => 'Searchable metadata',
        'meta_delivery' => 'Client delivery',
        'step_1_title' => 'Destinazione',
        'step_1_subtitle' => 'Cliente e file',
        'step_2_title' => 'Contesto',
        'step_2_subtitle' => 'Descrizione e tag',
        'step_3_title' => 'Archivio',
        'step_3_subtitle' => 'Verifica finale',
        'card_eyebrow' => 'Upload form',
        'card_title' => 'Metadati documento',
        'status_archive' => 'Archive intake',
        'status_size' => '10 MB max',
        'section_1_title' => 'Scegli correttamente destinazione e file',
        'section_1_lead' => 'Il documento deve finire subito nel workspace cliente corretto e nel formato giusto.',
        'customer' => 'Cliente',
        'customer_placeholder' => 'Seleziona cliente',
        'file' => 'File',
        'file_help' => 'Formati supportati: PDF, JPG, PNG, DOC, DOCX. Dimensione massima 10 MB.',
        'section_2_title' => 'Aggiungi contesto utile alla ricerca',
        'section_2_lead' => 'Descrizione e tag rendono l archivio piu leggibile e piu facile da usare nel tempo.',
        'description' => 'Descrizione opzionale',
        'description_placeholder' => 'Aggiungi una breve nota per contestualizzare il documento.',
        'tags' => 'Tag',
        'tags_placeholder' => 'fattura, 2026, cliente',
        'tags_help' => 'Usa tag separati da virgola per migliorare la ricerca interna.',
        'submit' => 'Carica documento',
        'cancel' => 'Annulla',
        'summary_eyebrow' => 'Archive summary',
        'summary_title' => 'Cosa stai definendo',
        'visibility' => 'Visibility',
        'visibility_value' => 'Client scoped',
        'indexing' => 'Indexing',
        'indexing_value' => 'Tag driven',
        'summary_customer' => 'Cliente',
        'summary_customer_value' => 'Determina la visibilita del documento',
        'summary_format' => 'Formato',
        'summary_format_value' => 'Influenza ricerca, anteprima e download',
        'summary_tags' => 'Tag',
        'summary_tags_value' => 'Aiutano a ritrovare il file in modo trasversale',
        'checklist_eyebrow' => 'Checklist',
        'checklist_title' => 'Caricamento efficace',
        'tip_customer' => 'Associa sempre il file al cliente corretto.',
        'tip_filename' => 'Preferisci nomi file chiari e riconoscibili.',
        'tip_tags' => 'Usa tag coerenti per anno, tipo o progetto.',
        'note_eyebrow' => 'Archive note',
        'note_title' => 'Pattern consigliato',
        'naming' => 'Naming',
        'naming_value' => 'Usa uno schema tipo `tipo-cliente-anno` per mantenere ordine e coerenza.',
        'retrieval' => 'Retrieval',
        'retrieval_value' => 'Descrizione e tag lavorano insieme per far emergere il file in ricerca e board.',
    ],
    'en' => [
        'page_title' => 'Upload Document',
        'eyebrow' => 'Upload center',
        'title' => 'Add a document ready for the customer archive',
        'lead' => 'Select the customer, upload the right file, and enrich it with notes and tags to make it easier to find.',
        'back' => 'Back to documents',
        'meta_archive' => 'Archive ready',
        'meta_searchable' => 'Searchable metadata',
        'meta_delivery' => 'Client delivery',
        'step_1_title' => 'Destination',
        'step_1_subtitle' => 'Customer and file',
        'step_2_title' => 'Context',
        'step_2_subtitle' => 'Description and tags',
        'step_3_title' => 'Archive',
        'step_3_subtitle' => 'Final check',
        'card_eyebrow' => 'Upload form',
        'card_title' => 'Document metadata',
        'status_archive' => 'Archive intake',
        'status_size' => '10 MB max',
        'section_1_title' => 'Choose destination and file correctly',
        'section_1_lead' => 'The document should immediately land in the correct customer workspace and format.',
        'customer' => 'Customer',
        'customer_placeholder' => 'Select customer',
        'file' => 'File',
        'file_help' => 'Supported formats: PDF, JPG, PNG, DOC, DOCX. Maximum size 10 MB.',
        'section_2_title' => 'Add context useful for search',
        'section_2_lead' => 'Description and tags make the archive easier to read and use over time.',
        'description' => 'Optional description',
        'description_placeholder' => 'Add a short note to contextualize the document.',
        'tags' => 'Tags',
        'tags_placeholder' => 'invoice, 2026, customer',
        'tags_help' => 'Use comma-separated tags to improve internal search.',
        'submit' => 'Upload document',
        'cancel' => 'Cancel',
        'summary_eyebrow' => 'Archive summary',
        'summary_title' => 'What you are defining',
        'visibility' => 'Visibility',
        'visibility_value' => 'Client scoped',
        'indexing' => 'Indexing',
        'indexing_value' => 'Tag driven',
        'summary_customer' => 'Customer',
        'summary_customer_value' => 'Determines the document visibility',
        'summary_format' => 'Format',
        'summary_format_value' => 'Affects search, preview, and download',
        'summary_tags' => 'Tags',
        'summary_tags_value' => 'Help find the file across the workspace',
        'checklist_eyebrow' => 'Checklist',
        'checklist_title' => 'Effective upload',
        'tip_customer' => 'Always associate the file with the correct customer.',
        'tip_filename' => 'Prefer clear and recognizable filenames.',
        'tip_tags' => 'Use consistent tags for year, type, or project.',
        'note_eyebrow' => 'Archive note',
        'note_title' => 'Recommended pattern',
        'naming' => 'Naming',
        'naming_value' => 'Use a `type-customer-year` scheme to keep order and consistency.',
        'retrieval' => 'Retrieval',
        'retrieval_value' => 'Description and tags work together to surface the file in search and board.',
    ],
    'fr' => [
        'page_title' => 'Televerser un document',
        'eyebrow' => 'Centre d upload',
        'title' => 'Ajouter un document pret pour l archive client',
        'lead' => 'Selectionnez le client, chargez le bon fichier et enrichissez-le avec des notes et des tags pour le retrouver plus facilement.',
        'back' => 'Retour aux documents',
        'meta_archive' => 'Archive prete',
        'meta_searchable' => 'Metadonnees recherchables',
        'meta_delivery' => 'Livraison client',
        'step_1_title' => 'Destination',
        'step_1_subtitle' => 'Client et fichier',
        'step_2_title' => 'Contexte',
        'step_2_subtitle' => 'Description et tags',
        'step_3_title' => 'Archive',
        'step_3_subtitle' => 'Verification finale',
        'card_eyebrow' => 'Formulaire upload',
        'card_title' => 'Metadonnees document',
        'status_archive' => 'Entree archive',
        'status_size' => '10 MB max',
        'section_1_title' => 'Choisir correctement destination et fichier',
        'section_1_lead' => 'Le document doit arriver tout de suite dans le bon workspace client et dans le bon format.',
        'customer' => 'Client',
        'customer_placeholder' => 'Selectionner le client',
        'file' => 'Fichier',
        'file_help' => 'Formats pris en charge : PDF, JPG, PNG, DOC, DOCX. Taille maximale 10 MB.',
        'section_2_title' => 'Ajouter du contexte utile a la recherche',
        'section_2_lead' => 'Description et tags rendent l archive plus lisible et plus simple a utiliser dans le temps.',
        'description' => 'Description optionnelle',
        'description_placeholder' => 'Ajoutez une breve note pour contextualiser le document.',
        'tags' => 'Tags',
        'tags_placeholder' => 'facture, 2026, client',
        'tags_help' => 'Utilisez des tags separes par des virgules pour ameliorer la recherche interne.',
        'submit' => 'Televerser le document',
        'cancel' => 'Annuler',
        'summary_eyebrow' => 'Resume archive',
        'summary_title' => 'Ce que vous definissez',
        'visibility' => 'Visibilite',
        'visibility_value' => 'Scope client',
        'indexing' => 'Indexation',
        'indexing_value' => 'Basee sur les tags',
        'summary_customer' => 'Client',
        'summary_customer_value' => 'Determine la visibilite du document',
        'summary_format' => 'Format',
        'summary_format_value' => 'Influence la recherche, l apercu et le telechargement',
        'summary_tags' => 'Tags',
        'summary_tags_value' => 'Aident a retrouver le fichier de maniere transversale',
        'checklist_eyebrow' => 'Checklist',
        'checklist_title' => 'Upload efficace',
        'tip_customer' => 'Associez toujours le fichier au bon client.',
        'tip_filename' => 'Preferez des noms de fichiers clairs et reconnaissables.',
        'tip_tags' => 'Utilisez des tags coherents pour l annee, le type ou le projet.',
        'note_eyebrow' => 'Note archive',
        'note_title' => 'Pattern recommande',
        'naming' => 'Nommage',
        'naming_value' => 'Utilisez un schema `type-client-annee` pour garder ordre et coherence.',
        'retrieval' => 'Recherche',
        'retrieval_value' => 'Description et tags travaillent ensemble pour faire remonter le fichier dans la recherche et la board.',
    ],
    'es' => [
        'page_title' => 'Cargar documento',
        'eyebrow' => 'Centro de carga',
        'title' => 'Agrega un documento listo para el archivo de clientes',
        'lead' => 'Selecciona el cliente, carga el archivo correcto y enriquecelo con notas y tags para encontrarlo mas facilmente.',
        'back' => 'Volver a documentos',
        'meta_archive' => 'Archivo listo',
        'meta_searchable' => 'Metadatos buscables',
        'meta_delivery' => 'Entrega al cliente',
        'step_1_title' => 'Destino',
        'step_1_subtitle' => 'Cliente y archivo',
        'step_2_title' => 'Contexto',
        'step_2_subtitle' => 'Descripcion y tags',
        'step_3_title' => 'Archivo',
        'step_3_subtitle' => 'Revision final',
        'card_eyebrow' => 'Formulario de carga',
        'card_title' => 'Metadatos del documento',
        'status_archive' => 'Ingreso a archivo',
        'status_size' => '10 MB max',
        'section_1_title' => 'Elige correctamente destino y archivo',
        'section_1_lead' => 'El documento debe llegar enseguida al workspace cliente correcto y en el formato adecuado.',
        'customer' => 'Cliente',
        'customer_placeholder' => 'Selecciona cliente',
        'file' => 'Archivo',
        'file_help' => 'Formatos soportados: PDF, JPG, PNG, DOC, DOCX. Tamano maximo 10 MB.',
        'section_2_title' => 'Agrega contexto util para la busqueda',
        'section_2_lead' => 'Descripcion y tags hacen el archivo mas legible y facil de usar con el tiempo.',
        'description' => 'Descripcion opcional',
        'description_placeholder' => 'Agrega una breve nota para contextualizar el documento.',
        'tags' => 'Tags',
        'tags_placeholder' => 'factura, 2026, cliente',
        'tags_help' => 'Usa tags separados por comas para mejorar la busqueda interna.',
        'submit' => 'Cargar documento',
        'cancel' => 'Cancelar',
        'summary_eyebrow' => 'Resumen de archivo',
        'summary_title' => 'Que estas definiendo',
        'visibility' => 'Visibilidad',
        'visibility_value' => 'Alcance cliente',
        'indexing' => 'Indexacion',
        'indexing_value' => 'Guiada por tags',
        'summary_customer' => 'Cliente',
        'summary_customer_value' => 'Determina la visibilidad del documento',
        'summary_format' => 'Formato',
        'summary_format_value' => 'Influye en busqueda, vista previa y descarga',
        'summary_tags' => 'Tags',
        'summary_tags_value' => 'Ayudan a reencontrar el archivo de forma transversal',
        'checklist_eyebrow' => 'Checklist',
        'checklist_title' => 'Carga eficaz',
        'tip_customer' => 'Asocia siempre el archivo al cliente correcto.',
        'tip_filename' => 'Prefiere nombres de archivo claros y reconocibles.',
        'tip_tags' => 'Usa tags coherentes para ano, tipo o proyecto.',
        'note_eyebrow' => 'Nota de archivo',
        'note_title' => 'Patron recomendado',
        'naming' => 'Naming',
        'naming_value' => 'Usa un esquema `tipo-cliente-ano` para mantener orden y coherencia.',
        'retrieval' => 'Recuperacion',
        'retrieval_value' => 'Descripcion y tags trabajan juntos para hacer emerger el archivo en busqueda y board.',
    ],
];

$dut = $documentUploadText[Locale::current()] ?? $documentUploadText['it'];
$pageTitle = $dut['page_title'];

ob_start();
?>
<section class="admin-section-hero mb-4">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars($dut['eyebrow']); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars($dut['title']); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars($dut['lead']); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a class="btn btn-outline-secondary" href="/documents"><?php echo htmlspecialchars($dut['back']); ?></a>
    </div>
</section>

<div class="admin-form-shell">
    <div class="admin-form-meta mb-3">
        <span class="admin-form-meta__pill"><i class="fas fa-folder-tree"></i><?php echo htmlspecialchars($dut['meta_archive']); ?></span>
        <span class="admin-form-meta__pill"><i class="fas fa-tag"></i><?php echo htmlspecialchars($dut['meta_searchable']); ?></span>
        <span class="admin-form-meta__pill"><i class="fas fa-users"></i><?php echo htmlspecialchars($dut['meta_delivery']); ?></span>
    </div>

    <div class="admin-form-stepper mb-4">
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">1</span>
            <div>
                <strong><?php echo htmlspecialchars($dut['step_1_title']); ?></strong>
                <small><?php echo htmlspecialchars($dut['step_1_subtitle']); ?></small>
            </div>
        </div>
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">2</span>
            <div>
                <strong><?php echo htmlspecialchars($dut['step_2_title']); ?></strong>
                <small><?php echo htmlspecialchars($dut['step_2_subtitle']); ?></small>
            </div>
        </div>
        <div class="admin-form-step">
            <span class="admin-form-step__index">3</span>
            <div>
                <strong><?php echo htmlspecialchars($dut['step_3_title']); ?></strong>
                <small><?php echo htmlspecialchars($dut['step_3_subtitle']); ?></small>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
        <div class="card admin-form-card">
                <div class="card-header border-0">
                <div>
                    <p class="admin-panel-eyebrow mb-1"><?php echo htmlspecialchars($dut['card_eyebrow']); ?></p>
                    <span><?php echo htmlspecialchars($dut['card_title']); ?></span>
                </div>
                <div class="admin-form-card__status">
                    <span class="admin-form-card__status-pill"><?php echo htmlspecialchars($dut['status_archive']); ?></span>
                    <span class="admin-form-card__status-pill is-soft"><?php echo htmlspecialchars($dut['status_size']); ?></span>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="/documents" enctype="multipart/form-data" class="row g-3">
                    <?php echo CSRF::field(); ?>
                    <div class="col-12">
                        <div class="admin-form-section admin-form-section--boxed">
                            <p class="admin-form-section__eyebrow">Step 1</p>
                            <h3 class="admin-form-section__title"><?php echo htmlspecialchars($dut['section_1_title']); ?></h3>
                            <p class="admin-form-section__lead"><?php echo htmlspecialchars($dut['section_1_lead']); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($dut['customer']); ?></label>
                        <select name="customer_id" required class="form-select">
                            <option value=""><?php echo htmlspecialchars($dut['customer_placeholder']); ?></option>
                            <?php foreach (($customers ?? []) as $customer): ?>
                                <option value="<?php echo (int)$customer['id']; ?>"><?php echo htmlspecialchars((string)$customer['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><?php echo htmlspecialchars($dut['file']); ?></label>
                        <input class="form-control" type="file" name="file" required>
                        <div class="form-text"><?php echo htmlspecialchars($dut['file_help']); ?></div>
                    </div>
                    <div class="col-12">
                        <div class="admin-form-section admin-form-section--boxed">
                            <p class="admin-form-section__eyebrow">Step 2</p>
                            <h3 class="admin-form-section__title"><?php echo htmlspecialchars($dut['section_2_title']); ?></h3>
                            <p class="admin-form-section__lead"><?php echo htmlspecialchars($dut['section_2_lead']); ?></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?php echo htmlspecialchars($dut['description']); ?></label>
                        <textarea name="description" class="form-control" rows="5" placeholder="<?php echo htmlspecialchars($dut['description_placeholder']); ?>"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?php echo htmlspecialchars($dut['tags']); ?></label>
                        <input class="form-control" type="text" name="tags" placeholder="<?php echo htmlspecialchars($dut['tags_placeholder']); ?>">
                        <div class="form-text"><?php echo htmlspecialchars($dut['tags_help']); ?></div>
                    </div>
                    <div class="col-12 d-flex gap-2 flex-wrap">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-upload me-1"></i><?php echo htmlspecialchars($dut['submit']); ?></button>
                        <a class="btn btn-outline-secondary" href="/documents"><?php echo htmlspecialchars($dut['cancel']); ?></a>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div class="col-xl-4">
            <div class="admin-form-sidebar">
                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($dut['summary_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($dut['summary_title']); ?></h3>
                        <div class="admin-form-kpis mb-3">
                            <div class="admin-form-kpi">
                                <span><?php echo htmlspecialchars($dut['visibility']); ?></span>
                                <strong><?php echo htmlspecialchars($dut['visibility_value']); ?></strong>
                            </div>
                            <div class="admin-form-kpi">
                                <span><?php echo htmlspecialchars($dut['indexing']); ?></span>
                                <strong><?php echo htmlspecialchars($dut['indexing_value']); ?></strong>
                            </div>
                        </div>
                        <div class="admin-summary-stack">
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($dut['summary_customer']); ?></span>
                                <strong><?php echo htmlspecialchars($dut['summary_customer_value']); ?></strong>
                            </div>
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($dut['summary_format']); ?></span>
                                <strong><?php echo htmlspecialchars($dut['summary_format_value']); ?></strong>
                            </div>
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($dut['summary_tags']); ?></span>
                                <strong><?php echo htmlspecialchars($dut['summary_tags_value']); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($dut['checklist_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($dut['checklist_title']); ?></h3>
                        <ul class="dashboard-insights mt-0">
                            <li><i class="fas fa-user-tag"></i><?php echo htmlspecialchars($dut['tip_customer']); ?></li>
                            <li><i class="fas fa-file-alt"></i><?php echo htmlspecialchars($dut['tip_filename']); ?></li>
                            <li><i class="fas fa-tags"></i><?php echo htmlspecialchars($dut['tip_tags']); ?></li>
                        </ul>
                    </div>
                </div>
                <div class="card admin-data-card">
                    <div class="card-body">
                        <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($dut['note_eyebrow']); ?></p>
                        <h3 class="dashboard-spotlight-card__title mb-2"><?php echo htmlspecialchars($dut['note_title']); ?></h3>
                        <div class="admin-summary-stack">
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($dut['naming']); ?></span>
                                <strong><?php echo htmlspecialchars($dut['naming_value']); ?></strong>
                            </div>
                            <div class="admin-summary-item">
                                <span><?php echo htmlspecialchars($dut['retrieval']); ?></span>
                                <strong><?php echo htmlspecialchars($dut['retrieval_value']); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/layout.php';
