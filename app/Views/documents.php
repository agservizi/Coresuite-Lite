<?php
use Core\Auth;

$pageTitle = 'Documenti';

$content = '';
if (Auth::isAdmin() || Auth::isOperator()) {
    $content .= '<div class="mb-4"><a href="/documents/upload" class="button is-primary"><span class="icon"><i class="fas fa-upload"></i></span><span>Carica documento</span></a></div>';
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
    $sizeKB = round(($doc['size'] ?? 0) / 1024, 1);
    $content .= '
        <tr>
            <td>' . (int)($doc['id'] ?? 0) . '</td>
            <td>' . htmlspecialchars($doc['filename_original'] ?? '-') . '</td>
            <td><span class="tag is-light">' . htmlspecialchars($doc['mime'] ?? '-') . '</span></td>
            <td>' . $sizeKB . ' KB</td>
            <td>' . htmlspecialchars($doc['created_at'] ?? '-') . '</td>
            <td>
                <div class="buttons are-small">
                    <a class="button is-link is-light" href="/documents/' . (int)($doc['id'] ?? 0) . '/download"><span class="icon"><i class="fas fa-download"></i></span><span>Download</span></a>
                    ' . ((Auth::isAdmin() || Auth::isOperator()) ? '<form method="POST" action="/documents/' . (int)($doc['id'] ?? 0) . '/delete" onsubmit="return confirm(\'Eliminare il documento?\')">'.CSRF::field().'<button class="button is-danger is-light" type="submit"><span class="icon"><i class="fas fa-trash"></i></span><span>Elimina</span></button></form>' : '') . '
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

// Paginazione
$currentPage = $page ?? 1;
$totalPages = $totalPages ?? 1;
if ($totalPages > 1) {
    $content .= '<nav class="pagination is-centered mt-4" role="navigation">';
    $content .= '<a class="pagination-previous" ' . ($currentPage <= 1 ? 'disabled' : 'href="/documents?page=' . ($currentPage - 1) . '"') . '>Precedente</a>';
    $content .= '<a class="pagination-next" ' . ($currentPage >= $totalPages ? 'disabled' : 'href="/documents?page=' . ($currentPage + 1) . '"') . '>Successiva</a>';
    $content .= '<ul class="pagination-list">';
    for ($i = 1; $i <= $totalPages; $i++) {
        $content .= '<li><a class="pagination-link' . ($i === $currentPage ? ' is-current' : '') . '" href="/documents?page=' . $i . '">' . $i . '</a></li>';
    }
    $content .= '</ul></nav>';
}

include __DIR__ . '/layout.php';
