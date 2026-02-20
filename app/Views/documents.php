<?php
use Core\Auth;

$pageTitle = 'Documenti';

$content = '';
if (Auth::isAdmin()) {
    $content .= '<div class="mb-4"><a href="/documents/upload" class="button is-primary">Carica documento</a></div>';
}

$content .= '
<div class="table-container">
<table class="table is-fullwidth is-hoverable">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome file</th>
            <th>MIME</th>
            <th>Dimensione</th>
            <th>Data</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
';

foreach (($documents ?? []) as $doc) {
    $content .= '
        <tr>
            <td>' . (int)($doc['id'] ?? 0) . '</td>
            <td>' . htmlspecialchars($doc['filename_original'] ?? '-') . '</td>
            <td>' . htmlspecialchars($doc['mime'] ?? '-') . '</td>
            <td>' . (int)($doc['size'] ?? 0) . ' bytes</td>
            <td>' . htmlspecialchars($doc['created_at'] ?? '-') . '</td>
            <td>
                <div class="buttons are-small">
                    <a class="button is-link is-light" href="/documents/' . (int)($doc['id'] ?? 0) . '/download">Download</a>
                    ' . (Auth::isAdmin() ? '<form method="POST" action="/documents/' . (int)($doc['id'] ?? 0) . '/delete" onsubmit="return confirm(\'Eliminare il documento?\')"><button class="button is-danger is-light" type="submit">Elimina</button></form>' : '') . '
                </div>
            </td>
        </tr>
    ';
}

if (empty($documents)) {
    $content .= '<tr><td colspan="6" class="has-text-centered has-text-grey">Nessun documento disponibile</td></tr>';
}

$content .= '
    </tbody>
</table>
</div>
';

include __DIR__ . '/layout.php';
