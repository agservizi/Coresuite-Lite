<?php
use Core\Auth;

$pageTitle = 'Dettaglio Ticket #' . (int)($ticket['id'] ?? 0);

$status = $ticket['status'] ?? 'open';
$priority = $ticket['priority'] ?? 'medium';
$canManageStatus = Auth::isOperator();

$priorityTag = $priority === 'high' ? 'is-danger' : ($priority === 'low' ? 'is-light' : 'is-warning');
$statusTag = $status === 'closed' ? 'is-success' : ($status === 'in_progress' ? 'is-warning' : ($status === 'resolved' ? 'is-primary' : 'is-info'));

$content = '
<div class="bg-white border rounded p-4 mb-5 shadow-sm">
    <h2 class="text-xl font-semibold">' . htmlspecialchars($ticket['subject'] ?? '(senza oggetto)') . '</h2>
    <div class="text-sm text-gray-600 mt-2">
        <span>Categoria: ' . htmlspecialchars($ticket['category'] ?? '-') . '</span>
        <span class="mx-2">•</span>
        <span>Stato: <span class="inline-block px-2 py-0.5 text-sm rounded ' . ($status === 'closed' ? 'bg-green-100 text-green-800' : ($status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : ($status === 'resolved' ? 'bg-blue-100 text-blue-800' : 'bg-indigo-100 text-indigo-800'))) . '">' . htmlspecialchars($status) . '</span></span>
        <span class="mx-2">•</span>
        <span>Priorità: <span class="inline-block px-2 py-0.5 text-sm rounded ' . ($priority === 'high' ? 'bg-red-100 text-red-800' : ($priority === 'low' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')) . '">' . htmlspecialchars($priority) . '</span></span>
    </div>
    <div class="text-sm text-gray-700 mt-3">
        Cliente: ' . htmlspecialchars($ticket['customer_name'] ?? '-') . '
        ' . (!empty($ticket['assigned_name']) ? '<span class="mx-2">•</span> Assegnato a: <strong>' . htmlspecialchars($ticket['assigned_name']) . '</strong>' : '') . '
    </div>
</div>
';

if ($canManageStatus) {
    $content .= '
    <div class="grid md:grid-cols-2 gap-4 mb-5">
        <div>
            <form method="POST" action="/tickets/' . (int)($ticket['id'] ?? 0) . '/status">
                ' . CSRF::field() . '
                <div class="flex items-center gap-3">
                    <select name="status" class="rounded border px-3 py-2">
                        <option value="open" ' . ($status === 'open' ? 'selected' : '') . '>open</option>
                        <option value="in_progress" ' . ($status === 'in_progress' ? 'selected' : '') . '>in_progress</option>
                        <option value="resolved" ' . ($status === 'resolved' ? 'selected' : '') . '>resolved</option>
                        <option value="closed" ' . ($status === 'closed' ? 'selected' : '') . '>closed</option>
                    </select>
                    <button class="px-3 py-2 bg-yellow-500 text-white rounded" type="submit">Aggiorna stato</button>
                </div>
            </form>
        </div>
        <div>
            <form method="POST" action="/tickets/' . (int)($ticket['id'] ?? 0) . '/assign">
                ' . CSRF::field() . '
                <div class="flex items-center gap-3">
                    <select name="assigned_to" class="rounded border px-3 py-2">
                        <option value="">Non assegnato</option>';

    foreach (($operators ?? []) as $op) {
        $sel = (isset($ticket['assigned_to']) && $ticket['assigned_to'] == $op['id']) ? 'selected' : '';
        $content .= '<option value="' . (int)$op['id'] . '" ' . $sel . '>' . htmlspecialchars($op['name']) . '</option>';
    }

    $content .= '
                    </select>
                    <button class="px-3 py-2 bg-blue-500 text-white rounded" type="submit">Assegna</button>
                </div>
            </form>
        </div>
    </div>
    ';
}


// Attachments section
$content .= '<div class="border rounded p-4 mb-4"><p class="text-lg font-semibold mb-2">Allegati</p>';
if (!empty($attachments)) {
    $content .= '<ul class="list-disc pl-5 space-y-2">';
    foreach ($attachments as $att) {
        $link = '/storage/tickets/' . htmlspecialchars($att['stored_name']);
        $content .= '<li><a href="' . $link . '" target="_blank" class="text-blue-600 hover:underline">' . htmlspecialchars($att['original_name']) . '</a> <span class="text-xs text-gray-500">(' . htmlspecialchars($att['uploaded_at']) . ')</span></li>';
    }
    $content .= '</ul>';
} else {
    $content .= '<p class="text-gray-500">Nessun allegato</p>';
}
$content .= '</div>';

$content .= '<h2 class="title is-5">Commenti</h2>';

foreach (($comments ?? []) as $comment) {
    $isInternal = ($comment['visibility'] ?? 'public') === 'internal';
    $internalBadge = $isInternal ? ' <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">interno</span>' : '';
    $bubbleClass = $isInternal ? 'bg-yellow-50 border-yellow-200' : 'bg-gray-100 border-gray-200';

    $content .= '
    <div class="border ' . $bubbleClass . ' rounded mb-3 p-3">
        <div class="flex justify-between items-start">
            <div class="font-medium">' . htmlspecialchars($comment['author_name'] ?? '-') . $internalBadge . '</div>
            <div class="text-xs text-gray-500">' . htmlspecialchars($comment['created_at'] ?? '-') . '</div>
        </div>
        <div class="mt-2 text-sm">' . nl2br(htmlspecialchars($comment['body'] ?? '')) . '</div>
    </div>
    ';
}

if (empty($comments)) {
    $content .= '<p class="has-text-grey">Nessun commento ancora.</p>';
}

$content .= '
<form method="POST" action="/tickets/' . (int)($ticket['id'] ?? 0) . '/comment" class="mt-5 space-y-4" enctype="multipart/form-data">
    ' . CSRF::field() . '
    <div>
        <label class="block text-sm font-medium text-gray-700">Nuovo commento</label>
        <div class="mt-1">
            <textarea class="w-full rounded border px-3 py-2" name="body" rows="4" required></textarea>
        </div>
    </div>';

// Solo operator/admin possono scegliere la visibilità
if (Auth::isOperator()) {
    $content .= '
    <div>
        <label class="block text-sm font-medium text-gray-700">Visibilità</label>
        <div class="mt-1">
            <select name="visibility" class="rounded border px-3 py-2">
                <option value="public">Pubblico (visibile al cliente)</option>
                <option value="internal">Interno (solo staff)</option>
            </select>
        </div>
    </div>';
}

 $content .= '
    <div class="flex gap-3">
        <button class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded" type="submit">Aggiungi commento</button>
        <a href="/tickets" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-800 rounded">Torna ai ticket</a>
    </div>
</form>
';

include __DIR__ . '/layout.php';
