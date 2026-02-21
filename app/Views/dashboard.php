<?php
use Core\Auth;

$pageTitle = 'Dashboard';
$content = '
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border rounded p-4 shadow-sm">
        <p class="text-2xl font-semibold">' . (int)($customersCount ?? 0) . '</p>
        <p class="text-sm text-gray-600">Clienti</p>
    </div>
    <div class="bg-white border rounded p-4 shadow-sm">
        <p class="text-2xl font-semibold">' . (int)($ticketsCount ?? 0) . '</p>
        <p class="text-sm text-gray-600">Totale Tickets</p>
    </div>
    <div class="bg-white border rounded p-4 shadow-sm">
        <p class="text-2xl font-semibold">' . (int)($openTicketsCount ?? 0) . '</p>
        <p class="text-sm text-gray-600">Tickets Aperti</p>
    </div>
    <div class="bg-white border rounded p-4 shadow-sm">
        <p class="text-2xl font-semibold">' . (int)($documentsCount ?? 0) . '</p>
        <p class="text-sm text-gray-600">Documenti</p>
    </div>
</div>

<div class="bg-white border rounded mb-5 shadow-sm">
    <div class="border-b px-4 py-2 font-medium">Grafico Tickets (ultimi 30 giorni)</div>
    <div class="p-4">
        <canvas id="ticketChart" width="400" height="200"></canvas>
    </div>
</div>
<script>
    window._chartLabels = ' . json_encode($chartLabels ?? []) . ';
    window._chartValues = ' . json_encode($chartValues ?? []) . ';
</script>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="bg-white border rounded shadow-sm">
        <div class="px-4 py-3 border-b font-medium">Ultime Richieste</div>
        <div class="p-4">';

if (!empty($latestTickets)) {
    $content .= '<ul>';
    foreach ($latestTickets as $lt) {
        $statusTag = $lt['status'] === 'closed' ? 'is-success' : ($lt['status'] === 'in_progress' ? 'is-warning' : ($lt['status'] === 'resolved' ? 'is-primary' : 'is-info'));
        $content .= '<li><a href="/tickets/' . (int)$lt['id'] . '">Ticket #' . (int)$lt['id'] . ' - ' . htmlspecialchars($lt['subject'] ?: '(senza oggetto)') . '</a> <span class="tag ' . $statusTag . ' is-light">' . htmlspecialchars($lt['status']) . '</span></li>';
    }
    $content .= '</ul>';
} else {
    $content .= '<p class="has-text-grey">Nessun ticket.</p>';
}

$content .= '
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white border rounded shadow-sm">
        <div class="px-4 py-3 border-b font-medium">Ultimi Upload</div>
        <div class="p-4">';

if (!empty($latestDocuments)) {
    $content .= '<ul>';
    foreach ($latestDocuments as $ld) {
        $customerInfo = isset($ld['customer_name']) ? ' - ' . htmlspecialchars($ld['customer_name']) : '';
        $content .= '<li><a href="/documents/' . (int)$ld['id'] . '/download">' . htmlspecialchars($ld['filename_original']) . '</a>' . $customerInfo . '</li>';
    }
    $content .= '</ul>';
} else {
    $content .= '<p class="has-text-grey">Nessun documento.</p>';
}

$content .= '
                </div>
            </div>
        </div>
    </div>
</div>
';

include __DIR__ . '/layout.php';
?>