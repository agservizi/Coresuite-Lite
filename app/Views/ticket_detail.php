<?php
use Core\Auth;

$pageTitle = 'Dettaglio Ticket #' . (int)($ticket['id'] ?? 0);

$status = $ticket['status'] ?? 'open';
$priority = $ticket['priority'] ?? 'medium';
$canManageStatus = Auth::isOperator();

$priorityTag = $priority === 'high' ? 'is-danger' : ($priority === 'low' ? 'is-light' : 'is-warning');
$statusTag = $status === 'closed' ? 'is-success' : ($status === 'in_progress' ? 'is-warning' : ($status === 'resolved' ? 'is-primary' : 'is-info'));

$content = '
<div class="card mb-5">
    <div class="card-content">
        <p class="title is-5">' . htmlspecialchars($ticket['subject'] ?? '(senza oggetto)') . '</p>
        <p class="subtitle is-6">
            Categoria: ' . htmlspecialchars($ticket['category'] ?? '-') . '
            &bull; Stato: <span class="tag ' . $statusTag . '">' . htmlspecialchars($status) . '</span>
            &bull; Priorità: <span class="tag ' . $priorityTag . '">' . htmlspecialchars($priority) . '</span>
        </p>
        <div class="content">
            Cliente: ' . htmlspecialchars($ticket['customer_name'] ?? '-') . '
            ' . (!empty($ticket['assigned_name']) ? '&bull; Assegnato a: <strong>' . htmlspecialchars($ticket['assigned_name']) . '</strong>' : '') . '
        </div>
    </div>
</div>
';

if ($canManageStatus) {
    $content .= '
    <div class="columns mb-5">
        <div class="column is-6">
            <form method="POST" action="/tickets/' . (int)($ticket['id'] ?? 0) . '/status">
                ' . CSRF::field() . '
                <div class="field has-addons">
                    <div class="control">
                        <div class="select">
                            <select name="status">
                                <option value="open" ' . ($status === 'open' ? 'selected' : '') . '>open</option>
                                <option value="in_progress" ' . ($status === 'in_progress' ? 'selected' : '') . '>in_progress</option>
                                <option value="resolved" ' . ($status === 'resolved' ? 'selected' : '') . '>resolved</option>
                                <option value="closed" ' . ($status === 'closed' ? 'selected' : '') . '>closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="control"><button class="button is-warning" type="submit">Aggiorna stato</button></div>
                </div>
            </form>
        </div>
        <div class="column is-6">
            <form method="POST" action="/tickets/' . (int)($ticket['id'] ?? 0) . '/assign">
                ' . CSRF::field() . '
                <div class="field has-addons">
                    <div class="control">
                        <div class="select">
                            <select name="assigned_to">
                                <option value="">Non assegnato</option>';

    foreach (($operators ?? []) as $op) {
        $sel = (isset($ticket['assigned_to']) && $ticket['assigned_to'] == $op['id']) ? 'selected' : '';
        $content .= '<option value="' . (int)$op['id'] . '" ' . $sel . '>' . htmlspecialchars($op['name']) . '</option>';
    }

    $content .= '
                            </select>
                        </div>
                    </div>
                    <div class="control"><button class="button is-info" type="submit">Assegna</button></div>
                </div>
            </form>
        </div>
    </div>
    ';
}


// Attachments section
$content .= '<div class="box mb-4"><p class="title is-6">Allegati</p>';
if (!empty($attachments)) {
    $content .= '<ul>';
    foreach ($attachments as $att) {
        $link = '/storage/tickets/' . htmlspecialchars($att['stored_name']);
        $content .= '<li><a href="' . $link . '" target="_blank">' . htmlspecialchars($att['original_name']) . '</a> <small class="has-text-grey">(' . htmlspecialchars($att['uploaded_at']) . ')</small></li>';
    }
    $content .= '</ul>';
} else {
    $content .= '<p class="has-text-grey">Nessun allegato</p>';
}
$content .= '</div>';

$content .= '<h2 class="title is-5">Commenti</h2>';

foreach (($comments ?? []) as $comment) {
    $isInternal = ($comment['visibility'] ?? 'public') === 'internal';
    $msgClass = $isInternal ? 'is-warning' : 'is-dark';
    $internalBadge = $isInternal ? ' <span class="tag is-warning is-light is-small">interno</span>' : '';

    $content .= '
    <article class="message ' . $msgClass . '">
        <div class="message-header">
            <p>' . htmlspecialchars($comment['author_name'] ?? '-') . $internalBadge . '</p>
            <small>' . htmlspecialchars($comment['created_at'] ?? '-') . '</small>
        </div>
        <div class="message-body">' . nl2br(htmlspecialchars($comment['body'] ?? '')) . '</div>
    </article>
    ';
}

if (empty($comments)) {
    $content .= '<p class="has-text-grey">Nessun commento ancora.</p>';
}

$content .= '
<form method="POST" action="/tickets/' . (int)($ticket['id'] ?? 0) . '/comment" class="mt-5" enctype="multipart/form-data">
    ' . CSRF::field() . '
    <div class="field">
        <label class="label">Nuovo commento</label>
        <div class="control">
            <textarea class="textarea" name="body" rows="4" required></textarea>
        </div>
    </div>';

// Solo operator/admin possono scegliere la visibilità
if (Auth::isOperator()) {
    $content .= '
    <div class="field">
        <label class="label">Visibilità</label>
        <div class="control">
            <div class="select">
                <select name="visibility">
                    <option value="public">Pubblico (visibile al cliente)</option>
                    <option value="internal">Interno (solo staff)</option>
                </select>
            </div>
        </div>
    </div>';
}

$content .= '
    <div class="field is-grouped">
        <div class="control"><button class="button is-primary" type="submit">Aggiungi commento</button></div>
        <div class="control"><a href="/tickets" class="button is-light">Torna ai ticket</a></div>
    </div>
</form>
';

include __DIR__ . '/layout.php';
