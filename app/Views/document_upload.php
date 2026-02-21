<?php
$pageTitle = 'Carica Documento';

$content = '
<form method="POST" action="/documents" enctype="multipart/form-data" class="space-y-4">
    ' . CSRF::field() . '
    <div>
        <label class="block text-sm font-medium text-gray-700">Cliente</label>
        <div class="mt-1">
            <select name="customer_id" required class="w-full rounded border px-3 py-2 bg-white">
                <option value="">Seleziona cliente</option>
';

foreach (($customers ?? []) as $customer) {
    $content .= '<option value="' . (int)$customer['id'] . '">' . htmlspecialchars($customer['name']) . '</option>';
}

$content .= '
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">File</label>
        <div class="mt-1">
            <input class="w-full" type="file" name="file" required>
        </div>
        <p class="text-xs text-gray-500 mt-1">Formati supportati: PDF, JPG, PNG, DOC, DOCX (max 10MB)</p>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Descrizione (opzionale)</label>
        <div class="mt-1">
            <textarea name="description" class="w-full rounded border px-3 py-2" placeholder="Breve descrizione o note"></textarea>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Tags (separati da virgola)</label>
        <div class="mt-1">
            <input class="w-full rounded border px-3 py-2" type="text" name="tags" placeholder="fattura, 2026, cliente">
        </div>
    </div>

    <div class="flex gap-3">
        <button class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded" type="submit">Carica</button>
        <a class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-800 rounded" href="/documents">Annulla</a>
    </div>

</form>
';

include __DIR__ . '/layout.php';
