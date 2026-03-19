<?php
use Core\Locale;

$pageTitle = (string)($salesForm['page_title'] ?? 'Sales CRM');
$meta = (array)($salesForm['meta'] ?? []);
$hasDocumentLines = false;
$sft = [
    'it' => [
        'default_title' => 'Nuova pratica sales',
        'default_back' => 'Torna al cockpit sales',
        'step1_title' => 'Dati principali',
        'step1_text' => 'Imposta anagrafica e relazioni',
        'step2_title' => 'Contesto operativo',
        'step2_text' => 'Completa stato, date e struttura',
        'step3_title' => 'Conferma',
        'step3_text' => 'Salva la pratica fuori dal cockpit',
        'section_eyebrow' => 'Pratica sales',
        'summary_default' => 'Nuova pratica commerciale',
        'summary_text_default' => 'Completa i dati chiave in una vista dedicata.',
        'key_field' => 'Campo chiave',
        'doc_lines_title' => 'Righe documento',
        'doc_lines_text' => 'Ogni voce ha i suoi campi separati per rendere chiari importi e imponibile.',
        'add_line' => 'Aggiungi riga',
        'description' => 'Descrizione',
        'qty' => 'Qta',
        'price' => 'Prezzo',
        'vat' => 'IVA %',
        'total' => 'Totale',
        'remove' => 'Rimuovi',
        'control_room' => 'Control room',
        'companies' => 'Aziende',
        'contacts' => 'Contatti',
        'deals' => 'Deal',
        'flow' => 'Flow',
        'single_page' => 'Single page',
        'why_page' => 'Perche questa pagina',
        'why_1' => 'Il cockpit resta leggibile e veloce da consultare.',
        'why_2' => 'La creazione pratica ha piu spazio per campi, date e righe documento.',
        'why_3' => 'Ogni record puo nascere da URL precompilate partendo da azienda, lead o deal.',
        'line_placeholder' => 'Setup commerciale e pipeline',
    ],
    'en' => [
        'default_title' => 'New sales record',
        'default_back' => 'Back to sales cockpit',
        'step1_title' => 'Core data',
        'step1_text' => 'Set account and relations',
        'step2_title' => 'Operational context',
        'step2_text' => 'Complete status, dates, and structure',
        'step3_title' => 'Confirm',
        'step3_text' => 'Save the record outside the cockpit',
        'section_eyebrow' => 'Sales record',
        'summary_default' => 'New commercial record',
        'summary_text_default' => 'Complete the key data in a dedicated view.',
        'key_field' => 'Key field',
        'doc_lines_title' => 'Document lines',
        'doc_lines_text' => 'Each item uses separate fields to keep amounts and taxable values clear.',
        'add_line' => 'Add line',
        'description' => 'Description',
        'qty' => 'Qty',
        'price' => 'Price',
        'vat' => 'VAT %',
        'total' => 'Total',
        'remove' => 'Remove',
        'control_room' => 'Control room',
        'companies' => 'Companies',
        'contacts' => 'Contacts',
        'deals' => 'Deals',
        'flow' => 'Flow',
        'single_page' => 'Single page',
        'why_page' => 'Why this page',
        'why_1' => 'The cockpit stays readable and fast to consult.',
        'why_2' => 'Creation gets more space for fields, dates, and document lines.',
        'why_3' => 'Every record can start from prefilled URLs based on company, lead, or deal.',
        'line_placeholder' => 'Commercial setup and pipeline',
    ],
    'fr' => [
        'default_title' => 'Nouvelle fiche sales',
        'default_back' => 'Retour au cockpit commercial',
        'step1_title' => 'Donnees principales',
        'step1_text' => 'Definir fiche et relations',
        'step2_title' => 'Contexte operationnel',
        'step2_text' => 'Completer statut, dates et structure',
        'step3_title' => 'Confirmation',
        'step3_text' => 'Enregistrer la fiche hors du cockpit',
        'section_eyebrow' => 'Fiche sales',
        'summary_default' => 'Nouvelle fiche commerciale',
        'summary_text_default' => 'Completez les donnees cle dans une vue dediee.',
        'key_field' => 'Champ cle',
        'doc_lines_title' => 'Lignes document',
        'doc_lines_text' => 'Chaque element utilise des champs separes pour clarifier montants et base taxable.',
        'add_line' => 'Ajouter ligne',
        'description' => 'Description',
        'qty' => 'Qte',
        'price' => 'Prix',
        'vat' => 'TVA %',
        'total' => 'Total',
        'remove' => 'Supprimer',
        'control_room' => 'Control room',
        'companies' => 'Societes',
        'contacts' => 'Contacts',
        'deals' => 'Deals',
        'flow' => 'Flux',
        'single_page' => 'Single page',
        'why_page' => 'Pourquoi cette page',
        'why_1' => 'Le cockpit reste lisible et rapide a consulter.',
        'why_2' => 'La creation dispose de plus d espace pour champs, dates et lignes.',
        'why_3' => 'Chaque fiche peut naitre d URLs pre-remplies depuis societe, lead ou deal.',
        'line_placeholder' => 'Setup commercial et pipeline',
    ],
    'es' => [
        'default_title' => 'Nueva ficha sales',
        'default_back' => 'Volver al cockpit comercial',
        'step1_title' => 'Datos principales',
        'step1_text' => 'Define ficha y relaciones',
        'step2_title' => 'Contexto operativo',
        'step2_text' => 'Completa estado, fechas y estructura',
        'step3_title' => 'Confirmacion',
        'step3_text' => 'Guarda la ficha fuera del cockpit',
        'section_eyebrow' => 'Ficha sales',
        'summary_default' => 'Nueva ficha comercial',
        'summary_text_default' => 'Completa los datos clave en una vista dedicada.',
        'key_field' => 'Campo clave',
        'doc_lines_title' => 'Lineas del documento',
        'doc_lines_text' => 'Cada elemento usa campos separados para aclarar importes y base imponible.',
        'add_line' => 'Agregar linea',
        'description' => 'Descripcion',
        'qty' => 'Cant.',
        'price' => 'Precio',
        'vat' => 'IVA %',
        'total' => 'Total',
        'remove' => 'Eliminar',
        'control_room' => 'Control room',
        'companies' => 'Empresas',
        'contacts' => 'Contactos',
        'deals' => 'Deals',
        'flow' => 'Flujo',
        'single_page' => 'Single page',
        'why_page' => 'Por que esta pagina',
        'why_1' => 'El cockpit sigue siendo legible y rapido de consultar.',
        'why_2' => 'La creacion tiene mas espacio para campos, fechas y lineas del documento.',
        'why_3' => 'Cada registro puede nacer de URLs precargadas desde empresa, lead o deal.',
        'line_placeholder' => 'Setup comercial y pipeline',
    ],
];
$ft = $sft[Locale::current()] ?? $sft['it'];

ob_start();
?>
<section class="admin-section-hero mb-4 sales-create-hero">
    <div class="admin-section-hero__content">
        <div class="admin-section-hero__eyebrow"><?php echo htmlspecialchars((string)($salesForm['eyebrow'] ?? 'Sales CRM')); ?></div>
        <h2 class="admin-section-hero__title"><?php echo htmlspecialchars((string)($salesForm['title'] ?? $ft['default_title'])); ?></h2>
        <p class="admin-section-hero__lead"><?php echo htmlspecialchars((string)($salesForm['lead'] ?? '')); ?></p>
    </div>
    <div class="admin-section-hero__actions">
        <a href="<?php echo htmlspecialchars((string)($salesForm['back_href'] ?? '/sales')); ?>" class="btn btn-outline-secondary"><?php echo htmlspecialchars((string)($salesForm['back_label'] ?? $ft['default_back'])); ?></a>
    </div>
</section>

<div class="admin-form-shell sales-form-shell mb-4">
    <div class="admin-form-stepper">
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">1</span>
            <div><strong><?php echo htmlspecialchars($ft['step1_title']); ?></strong><small><?php echo htmlspecialchars($ft['step1_text']); ?></small></div>
        </div>
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">2</span>
            <div><strong><?php echo htmlspecialchars($ft['step2_title']); ?></strong><small><?php echo htmlspecialchars($ft['step2_text']); ?></small></div>
        </div>
        <div class="admin-form-step is-active">
            <span class="admin-form-step__index">3</span>
            <div><strong><?php echo htmlspecialchars($ft['step3_title']); ?></strong><small><?php echo htmlspecialchars($ft['step3_text']); ?></small></div>
        </div>
    </div>
</div>

<div class="row g-4 sales-form-layout">
    <div class="col-xl-8">
        <form method="POST" action="<?php echo htmlspecialchars((string)($salesForm['action'] ?? '/sales')); ?>" class="sales-form-main">
            <?php echo CSRF::field(); ?>
            <div class="card admin-data-card admin-form-card">
                <div class="card-body">
                    <div class="admin-form-section admin-form-section--boxed mb-4">
                        <p class="admin-form-section__eyebrow"><?php echo htmlspecialchars($ft['section_eyebrow']); ?></p>
                        <h3 class="admin-form-section__title"><?php echo htmlspecialchars((string)($salesForm['summary_title'] ?? $ft['summary_default'])); ?></h3>
                        <p class="admin-form-section__lead"><?php echo htmlspecialchars((string)($salesForm['summary_text'] ?? $ft['summary_text_default'])); ?></p>
                    </div>

                    <div class="row g-3">
                        <?php foreach ((array)($salesForm['fields'] ?? []) as $field): ?>
                            <?php
                            $type = (string)($field['type'] ?? 'text');
                            $name = (string)($field['name'] ?? '');
                            $rawValue = $field['value'] ?? '';
                            $value = is_scalar($rawValue) || $rawValue === null ? (string)$rawValue : '';
                            $label = (string)($field['label'] ?? $name);
                            $col = (string)($field['col'] ?? 'col-12');
                            $placeholder = (string)($field['placeholder'] ?? '');
                            $required = !empty($field['required']) ? ' required' : '';
                            $help = (string)($field['help'] ?? '');
                            ?>
                            <div class="<?php echo htmlspecialchars($col); ?>">
                                <?php if ($type === 'checkbox'): ?>
                                    <label class="workspace-settings-toggle w-100 mb-0 sales-form-toggle">
                                        <input type="checkbox" name="<?php echo htmlspecialchars($name); ?>" value="1"<?php echo $value === '1' ? ' checked' : ''; ?>>
                                        <span>
                                            <strong><?php echo htmlspecialchars($label); ?></strong>
                                            <?php if ($help !== ''): ?><small><?php echo htmlspecialchars($help); ?></small><?php endif; ?>
                                        </span>
                                    </label>
                                <?php else: ?>
                                    <label class="form-label"><?php echo htmlspecialchars($label); ?><?php if (!empty($field['required'])): ?> <span class="admin-label-hint"><?php echo htmlspecialchars($ft['key_field']); ?></span><?php endif; ?></label>
                                    <?php if ($type === 'document_lines'): ?>
                                        <?php $hasDocumentLines = true; ?>
                                        <div class="sales-document-lines" data-document-lines data-initial-lines="<?php echo htmlspecialchars(json_encode(is_array($rawValue) ? $rawValue : [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8'); ?>">
                                            <div class="sales-document-lines__head">
                                                <div>
                                                    <strong><?php echo htmlspecialchars($ft['doc_lines_title']); ?></strong>
                                                    <p><?php echo htmlspecialchars($ft['doc_lines_text']); ?></p>
                                                </div>
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-add-document-line><?php echo htmlspecialchars($ft['add_line']); ?></button>
                                            </div>
                                            <div class="sales-document-lines__table">
                                                <div class="sales-document-lines__header">
                                                    <span><?php echo htmlspecialchars($ft['description']); ?></span>
                                                    <span><?php echo htmlspecialchars($ft['qty']); ?></span>
                                                    <span><?php echo htmlspecialchars($ft['price']); ?></span>
                                                    <span><?php echo htmlspecialchars($ft['vat']); ?></span>
                                                    <span><?php echo htmlspecialchars($ft['total']); ?></span>
                                                    <span></span>
                                                </div>
                                                <div class="sales-document-lines__body" data-document-lines-body></div>
                                            </div>
                                            <template data-document-line-template>
                                                <div class="sales-document-line">
                                                    <div class="sales-document-line__cell sales-document-line__cell--description" data-label="<?php echo htmlspecialchars($ft['description']); ?>">
                                                        <input class="form-control" type="text" name="document_lines[description][]" placeholder="<?php echo htmlspecialchars($ft['line_placeholder']); ?>" required>
                                                    </div>
                                                    <div class="sales-document-line__cell sales-document-line__cell--qty" data-label="<?php echo htmlspecialchars($ft['qty']); ?>">
                                                        <input class="form-control" type="number" name="document_lines[quantity][]" value="1" min="0.01" step="0.01" required>
                                                    </div>
                                                    <div class="sales-document-line__cell sales-document-line__cell--price" data-label="<?php echo htmlspecialchars($ft['price']); ?>">
                                                        <input class="form-control" type="number" name="document_lines[unit_price][]" value="0" min="0" step="0.01" required>
                                                    </div>
                                                    <div class="sales-document-line__cell sales-document-line__cell--tax" data-label="<?php echo htmlspecialchars($ft['vat']); ?>">
                                                        <input class="form-control" type="number" name="document_lines[tax_rate][]" value="22" min="0" step="0.01" required>
                                                    </div>
                                                    <div class="sales-document-line__cell sales-document-line__cell--total" data-label="<?php echo htmlspecialchars($ft['total']); ?>">
                                                        <input class="form-control sales-document-line__total" type="text" value="0,00" readonly tabindex="-1">
                                                    </div>
                                                    <div class="sales-document-line__cell sales-document-line__cell--actions">
                                                        <button class="btn btn-sm btn-outline-danger" type="button" data-remove-document-line><?php echo htmlspecialchars($ft['remove']); ?></button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    <?php elseif ($type === 'select'): ?>
                                        <select class="form-select" name="<?php echo htmlspecialchars($name); ?>"<?php echo $required; ?>>
                                            <?php foreach ((array)($field['options'] ?? []) as $option): ?>
                                                <option value="<?php echo htmlspecialchars((string)($option['value'] ?? '')); ?>"<?php echo $value !== '' && $value === (string)($option['value'] ?? '') ? ' selected' : ''; ?>>
                                                    <?php echo htmlspecialchars((string)($option['label'] ?? '')); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php elseif ($type === 'textarea'): ?>
                                        <textarea class="form-control" name="<?php echo htmlspecialchars($name); ?>" rows="<?php echo (int)($field['rows'] ?? 4); ?>" placeholder="<?php echo htmlspecialchars($placeholder); ?>"<?php echo $required; ?>><?php echo htmlspecialchars($value); ?></textarea>
                                    <?php else: ?>
                                        <input
                                            class="form-control"
                                            type="<?php echo htmlspecialchars($type); ?>"
                                            name="<?php echo htmlspecialchars($name); ?>"
                                            value="<?php echo htmlspecialchars($value); ?>"
                                            placeholder="<?php echo htmlspecialchars($placeholder); ?>"
                                            <?php if (isset($field['min'])): ?>min="<?php echo htmlspecialchars((string)$field['min']); ?>"<?php endif; ?>
                                            <?php if (isset($field['max'])): ?>max="<?php echo htmlspecialchars((string)$field['max']); ?>"<?php endif; ?>
                                            <?php echo $required; ?>
                                        >
                                    <?php endif; ?>
                                    <?php if ($help !== ''): ?><div class="form-text"><?php echo htmlspecialchars($help); ?></div><?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="sales-form-footer">
                        <a href="<?php echo htmlspecialchars((string)($salesForm['back_href'] ?? '/sales')); ?>" class="btn btn-outline-secondary"><?php echo htmlspecialchars((string)($salesForm['back_label'] ?? $ft['default_back'])); ?></a>
                        <button class="btn btn-primary" type="submit"><?php echo htmlspecialchars((string)($salesForm['submit_label'] ?? 'Salva')); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-xl-4">
        <div class="sales-form-sidebar">
            <div class="card admin-data-card admin-form-aside-card">
                <div class="card-body">
                    <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($ft['control_room']); ?></p>
                    <div class="admin-form-kpis">
                        <div class="admin-form-kpi"><span><?php echo htmlspecialchars($ft['companies']); ?></span><strong><?php echo (int)($meta['companies'] ?? 0); ?></strong></div>
                        <div class="admin-form-kpi"><span><?php echo htmlspecialchars($ft['contacts']); ?></span><strong><?php echo (int)($meta['contacts'] ?? 0); ?></strong></div>
                        <div class="admin-form-kpi"><span><?php echo htmlspecialchars($ft['deals']); ?></span><strong><?php echo (int)($meta['deals'] ?? 0); ?></strong></div>
                        <div class="admin-form-kpi"><span><?php echo htmlspecialchars($ft['flow']); ?></span><strong><?php echo htmlspecialchars($ft['single_page']); ?></strong></div>
                    </div>
                </div>
            </div>

            <div class="card admin-data-card admin-form-aside-card">
                <div class="card-body">
                    <p class="admin-panel-eyebrow mb-2"><?php echo htmlspecialchars($ft['why_page']); ?></p>
                    <div class="admin-summary-stack">
                        <div class="admin-summary-item"><strong><?php echo htmlspecialchars($ft['why_1']); ?></strong></div>
                        <div class="admin-summary-item"><strong><?php echo htmlspecialchars($ft['why_2']); ?></strong></div>
                        <div class="admin-summary-item"><strong><?php echo htmlspecialchars($ft['why_3']); ?></strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

if ($hasDocumentLines):
    $content .= <<<HTML
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-document-lines]').forEach(function (editor) {
        const body = editor.querySelector('[data-document-lines-body]');
        const template = editor.querySelector('[data-document-line-template]');
        const addButton = editor.querySelector('[data-add-document-line]');
        const initialLines = (function () {
            const raw = editor.getAttribute('data-initial-lines') || '';
            if (!raw) {
                return [];
            }
            try {
                const parsed = JSON.parse(raw);
                return parsed && typeof parsed === 'object' ? parsed : [];
            } catch (error) {
                return [];
            }
        })();

        const formatMoney = function (value) {
            return new Intl.NumberFormat('it-IT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
        };

        const updateRowTotal = function (row) {
            const quantity = parseFloat((row.querySelector('input[name="document_lines[quantity][]"]') || {}).value || '0');
            const unitPrice = parseFloat((row.querySelector('input[name="document_lines[unit_price][]"]') || {}).value || '0');
            const taxRate = parseFloat((row.querySelector('input[name="document_lines[tax_rate][]"]') || {}).value || '0');
            const net = Math.max(0, quantity) * Math.max(0, unitPrice);
            const total = net + (net * Math.max(0, taxRate) / 100);
            const totalField = row.querySelector('.sales-document-line__total');
            if (totalField) {
                totalField.value = formatMoney(total);
            }
        };

        const bindRow = function (row) {
            row.querySelectorAll('input').forEach(function (input) {
                input.addEventListener('input', function () {
                    updateRowTotal(row);
                });
            });
            const removeButton = row.querySelector('[data-remove-document-line]');
            if (removeButton) {
                removeButton.addEventListener('click', function () {
                    if (body.children.length === 1) {
                        row.querySelectorAll('input').forEach(function (input) {
                            if (input.name === 'document_lines[description][]') {
                                input.value = '';
                            } else if (input.classList.contains('sales-document-line__total')) {
                                input.value = '0,00';
                            } else if (input.name === 'document_lines[tax_rate][]') {
                                input.value = '22';
                            } else if (input.name === 'document_lines[quantity][]') {
                                input.value = '1';
                            } else {
                                input.value = '0';
                            }
                        });
                        updateRowTotal(row);
                        return;
                    }
                    row.remove();
                });
            }
            updateRowTotal(row);
        };

        const addRow = function (values) {
            const fragment = template.content.cloneNode(true);
            const row = fragment.querySelector('.sales-document-line');
            const rowValues = values && typeof values === 'object' ? values : {};
            const descriptionInput = row.querySelector('input[name="document_lines[description][]"]');
            const quantityInput = row.querySelector('input[name="document_lines[quantity][]"]');
            const unitPriceInput = row.querySelector('input[name="document_lines[unit_price][]"]');
            const taxRateInput = row.querySelector('input[name="document_lines[tax_rate][]"]');
            if (descriptionInput) {
                descriptionInput.value = rowValues.description || '';
            }
            if (quantityInput && rowValues.quantity !== undefined) {
                quantityInput.value = rowValues.quantity;
            }
            if (unitPriceInput && rowValues.unit_price !== undefined) {
                unitPriceInput.value = rowValues.unit_price;
            }
            if (taxRateInput && rowValues.tax_rate !== undefined) {
                taxRateInput.value = rowValues.tax_rate;
            }
            body.appendChild(fragment);
            bindRow(body.lastElementChild);
        };

        addButton.addEventListener('click', function () {
            addRow();
        });

        if (Array.isArray(initialLines.description) && initialLines.description.length) {
            initialLines.description.forEach(function (_, index) {
                addRow({
                    description: initialLines.description[index] || '',
                    quantity: (initialLines.quantity || [])[index] || '1',
                    unit_price: (initialLines.unit_price || [])[index] || '0',
                    tax_rate: (initialLines.tax_rate || [])[index] || '22'
                });
            });
        } else {
            addRow();
        }
    });
});
</script>
HTML;
endif;

include __DIR__ . '/layout.php';
