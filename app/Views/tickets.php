<?php
$pageTitle = 'Tickets';

$content = '
<div class="flex items-center justify-between mb-4">
    <div class="text-sm text-gray-600">Elenco richieste di assistenza</div>
    <a href="/tickets/create" class="px-3 py-2 bg-blue-600 text-white rounded">Nuovo Ticket</a>
</div>

<div class="overflow-x-auto bg-white border rounded">
<table class="min-w-full divide-y">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Oggetto</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Categoria</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Priorità</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Stato</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Data</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600"></th>
        </tr>
    </thead>
    <tbody class="divide-y">
';

foreach (($tickets ?? []) as $ticket) {
    $status = $ticket['status'] ?? 'open';
    $priority = $ticket['priority'] ?? 'medium';
    $statusTag = $status === 'closed' ? 'is-success' : ($status === 'in_progress' ? 'is-warning' : ($status === 'resolved' ? 'is-primary' : 'is-info'));
    $priorityTag = $priority === 'high' ? 'is-danger' : ($priority === 'low' ? 'is-light' : 'is-warning');
    $content .= '
        <tr>
            <td class="px-4 py-2">' . (int)($ticket['id'] ?? 0) . '</td>
            <td class="px-4 py-2">' . htmlspecialchars($ticket['subject'] ?? '(senza oggetto)') . '</td>
            <td class="px-4 py-2">' . htmlspecialchars($ticket['category'] ?? '-') . '</td>
            <td class="px-4 py-2"><span class="inline-block px-2 py-0.5 text-sm rounded ' . ($priority === 'high' ? 'bg-red-100 text-red-800' : ($priority === 'low' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')) . '">' . htmlspecialchars($priority) . '</span></td>
            <td class="px-4 py-2"><span class="inline-block px-2 py-0.5 text-sm rounded ' . ($status === 'closed' ? 'bg-green-100 text-green-800' : ($status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : ($status === 'resolved' ? 'bg-blue-100 text-blue-800' : 'bg-indigo-100 text-indigo-800'))) . '">' . htmlspecialchars($status) . '</span></td>
            <td class="px-4 py-2">' . htmlspecialchars($ticket['created_at'] ?? '-') . '</td>
            <td class="px-4 py-2"><a class="px-2 py-1 bg-gray-100 rounded" href="/tickets/' . (int)($ticket['id'] ?? 0) . '">Apri</a></td>
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
