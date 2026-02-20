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
            <th>Stato</th>
            <th>Data</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
';

foreach (($tickets ?? []) as $ticket) {
    $status = $ticket['status'] ?? 'open';
    $tag = $status === 'closed' ? 'is-success' : ($status === 'in_progress' ? 'is-warning' : 'is-info');
    $content .= '
        <tr>
            <td>' . (int)($ticket['id'] ?? 0) . '</td>
            <td>' . htmlspecialchars($ticket['subject'] ?? '(senza oggetto)') . '</td>
            <td>' . htmlspecialchars($ticket['category'] ?? '-') . '</td>
            <td><span class="tag ' . $tag . '">' . htmlspecialchars($status) . '</span></td>
            <td>' . htmlspecialchars($ticket['created_at'] ?? '-') . '</td>
            <td><a class="button is-small is-link is-light" href="/tickets/' . (int)($ticket['id'] ?? 0) . '">Apri</a></td>
        </tr>
    ';
}

if (empty($tickets)) {
    $content .= '<tr><td colspan="6" class="has-text-centered has-text-grey">Nessun ticket disponibile</td></tr>';
}

$content .= '
    </tbody>
</table>
</div>
';

include __DIR__ . '/layout.php';
