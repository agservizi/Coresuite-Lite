<?php
$pageTitle = 'Nuovo Ticket';

$content = '
<form method="POST" action="/tickets" enctype="multipart/form-data" class="space-y-4">
    ' . CSRF::field() . '
    <div>
        <label class="block text-sm font-medium text-gray-700">Categoria</label>
        <div class="mt-1">
            <select name="category" required class="w-full rounded border px-3 py-2 bg-white">
                <option value="">Seleziona categoria</option>
                <option value="tecnico">Tecnico</option>
                <option value="amministrativo">Amministrativo</option>
                <option value="commerciale">Commerciale</option>
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Oggetto</label>
        <div class="mt-1">
            <input class="w-full rounded border px-3 py-2" type="text" name="subject" placeholder="Breve descrizione" required>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Priorità</label>
        <div class="mt-1">
            <select name="priority" class="w-full rounded border px-3 py-2">
                <option value="low">Bassa</option>
                <option value="medium" selected>Media</option>
                <option value="high">Alta</option>
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Descrizione</label>
        <div class="mt-1">
            <textarea class="w-full rounded border px-3 py-2" name="body" rows="6" required></textarea>
        </div>
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700">Allega file (opzionale)</label>
        <div class="mt-1">
            <input type="file" name="attachment">
        </div>
    </div>

    <div class="flex gap-3">
        <button class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded" type="submit">Invia ticket</button>
        <a href="/tickets" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-800 rounded">Annulla</a>
    </div>
</form>
';

include __DIR__ . '/layout.php';
