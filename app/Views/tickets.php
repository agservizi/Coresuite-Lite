<?php
$pageTitle = 'Tickets';

$content = '
<div class="level">
    <div class="level-left">
        <div class="level-item"><p class="subtitle is-6">Elenco richieste di assistenza</p></div>
    </div>
    <div class="level-right">
        <div class="level-item"><a href="/tickets/create" class="button is-primary">Nuovo Ticket</a></div>
    </div>
</div>

<div class="table-container">
<table class="table is-fullwidth is-hoverable">
    <thead>
        <tr>
            <th>#</th>
            <th>Oggetto</th>
            <th>Categoria</th>
            <th>Priorità</th>
            <th>Stato</th>
            <th>Data</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
';

foreach (($tickets ?? []) as $ticket) {
    $status = $ticket['status'] ?? 'open';
    $priority = $ticket['priority'] ?? 'medium';
    $statusTag = $status === 'closed' ? 'is-success' : ($status === 'in_progress' ? 'is-warning' : ($status === 'resolved' ? 'is-primary' : 'is-info'));
    $priorityTag = $priority === 'high' ? 'is-danger' : ($priority === 'low' ? 'is-light' : 'is-warning');
    $content .= '
        <tr>
            <td>' . (int)($ticket['id'] ?? 0) . '</td>
            <td>' . htmlspecialchars($ticket['subject'] ?? '(senza oggetto)') . '</td>
            <td>' . htmlspecialchars($ticket['category'] ?? '-') . '</td>
            <td><span class="tag ' . $priorityTag . '">' . htmlspecialchars($priority) . '</span></td>
            <td><span class="tag ' . $statusTag . '">' . htmlspecialchars($status) . '</span></td>
            <td>' . htmlspecialchars($ticket['created_at'] ?? '-') . '</td>
            <td><a class="button is-small is-link is-light" href="/tickets/' . (int)($ticket['id'] ?? 0) . '">Apri</a></td>
        </tr>
    ';
}

if (empty($tickets)) {
    $content .= '<tr><td colspan="7" class="has-text-centered has-text-grey">Nessun ticket disponibile</td></tr>';
}

$content .= '
    </tbody>
</table>
</div>
';

// Paginazione
if (isset($totalPages) && $totalPages > 1) {
    $currentPage = $page ?? 1;
    $content .= '<nav class="pagination is-centered mt-4" role="navigation" aria-label="pagination">';
    $content .= '<a class="pagination-previous" ' . ($currentPage <= 1 ? 'disabled' : 'href="/tickets?page=' . ($currentPage - 1) . '"') . '>Precedente</a>';
    $content .= '<a class="pagination-next" ' . ($currentPage >= $totalPages ? 'disabled' : 'href="/tickets?page=' . ($currentPage + 1) . '"') . '>Successiva</a>';
    $content .= '<ul class="pagination-list">';
    for ($p = 1; $p <= $totalPages; $p++) {
        $content .= '<li><a class="pagination-link ' . ($p == $currentPage ? 'is-current' : '') . '" href="/tickets?page=' . $p . '">' . $p . '</a></li>';
    }
    $content .= '</ul></nav>';
}

include __DIR__ . '/layout.php';
