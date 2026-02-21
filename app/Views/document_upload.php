<?php
$pageTitle = 'Carica Documento';

$content = '
<form method="POST" action="/documents" enctype="multipart/form-data">
    ' . CSRF::field() . '
    <div class="field">
        <label class="label">Cliente</label>
        <div class="control">
            <div class="select is-fullwidth">
                <select name="customer_id" required>
                    <option value="">Seleziona cliente</option>
';

foreach (($customers ?? []) as $customer) {
    $content .= '<option value="' . (int)$customer['id'] . '">' . htmlspecialchars($customer['name']) . '</option>';
}

$content .= '
                </select>
            </div>
        </div>
    </div>

    <div class="field">
        <label class="label">File</label>
        <div class="control">
            <input class="input" type="file" name="file" required>
        </div>
        <p class="help">Formati supportati: PDF, JPG, PNG, DOC, DOCX (max 10MB)</p>
    </div>

    <div class="field">
        <label class="label">Descrizione (opzionale)</label>
        <div class="control">
            <textarea name="description" class="textarea" placeholder="Breve descrizione o note"></textarea>
        </div>
    </div>

    <div class="field">
        <label class="label">Tags (separati da virgola)</label>
        <div class="control">
            <input class="input" type="text" name="tags" placeholder="fattura, 2026, cliente">
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control"><button class="button is-primary" type="submit">Carica</button></div>
        <div class="control"><a class="button is-light" href="/documents">Annulla</a></div>
    </div>
</form>
';

include __DIR__ . '/layout.php';
