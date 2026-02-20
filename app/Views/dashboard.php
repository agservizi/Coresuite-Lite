<?php
use Core\Auth;

$pageTitle = 'Dashboard';

$content = '
<div class="columns is-multiline">
    <div class="column is-3">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="title is-2">' . (int)($customersCount ?? 0) . '</p>
                    <p class="subtitle">Clienti</p>
                </div>
            </div>
        </div>
    </div>
    <div class="column is-3">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="title is-2">' . (int)($ticketsCount ?? 0) . '</p>
                    <p class="subtitle">Totale Tickets</p>
                </div>
            </div>
        </div>
    </div>
    <div class="column is-3">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="title is-2">' . (int)($openTicketsCount ?? 0) . '</p>
                    <p class="subtitle">Tickets Aperti</p>
                </div>
            </div>
        </div>
    </div>
    <div class="column is-3">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="title is-2">' . (int)($documentsCount ?? 0) . '</p>
                    <p class="subtitle">Documenti</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5">
    <header class="card-header">
        <p class="card-header-title">Grafico Tickets (ultimi 30 giorni)</p>
    </header>
    <div class="card-content">
        <canvas id="ticketChart" width="400" height="200"></canvas>
    </div>
</div>
<script>
    window._chartLabels = ' . json_encode($chartLabels ?? []) . ';
    window._chartValues = ' . json_encode($chartValues ?? []) . ';
</script>

<div class="columns">
    <div class="column is-6">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">Ultime Richieste</p>
            </header>
            <div class="card-content">
                <div class="content">';

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
    <div class="column is-6">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">Ultimi Upload</p>
            </header>
            <div class="card-content">
                <div class="content">';

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