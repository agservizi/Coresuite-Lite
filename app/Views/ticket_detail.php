<?php
use Core\Auth;

$pageTitle = 'Dettaglio Ticket #' . (int)($ticket['id'] ?? 0);

$status = $ticket['status'] ?? 'open';
$canManageStatus = Auth::isOperator();

$content = '
<div class="card mb-5">
    <div class="card-content">
        <p class="title is-5">' . htmlspecialchars($ticket['subject'] ?? '(senza oggetto)') . '</p>
        <p class="subtitle is-6">Categoria: ' . htmlspecialchars($ticket['category'] ?? '-') . ' • Stato: <span class="tag is-info">' . htmlspecialchars($status) . '</span></p>
        <div class="content">Cliente: ' . htmlspecialchars($ticket['customer_name'] ?? '-') . '</div>
    </div>
</div>
';

if ($canManageStatus) {
    $content .= '
    <form method="POST" action="/tickets/' . (int)($ticket['id'] ?? 0) . '/status" class="mb-5">
        <div class="field has-addons">
            <div class="control">
                <div class="select">
                    <select name="status">
                        <option value="open" ' . ($status === 'open' ? 'selected' : '') . '>open</option>
                        <option value="in_progress" ' . ($status === 'in_progress' ? 'selected' : '') . '>in_progress</option>
                        <option value="closed" ' . ($status === 'closed' ? 'selected' : '') . '>closed</option>
                    </select>
                </div>
            </div>
            <div class="control"><button class="button is-warning" type="submit">Aggiorna stato</button></div>
        </div>
    </form>
    ';
}

$content .= '<h2 class="title is-5">Commenti</h2>';

foreach (($comments ?? []) as $comment) {
    $content .= '
    <article class="message is-dark">
        <div class="message-header">
            <p>' . htmlspecialchars($comment['author_name'] ?? '-') . '</p>
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
<form method="POST" action="/tickets/' . (int)($ticket['id'] ?? 0) . '/comment" class="mt-5">
    <div class="field">
        <label class="label">Nuovo commento</label>
        <div class="control">
            <textarea class="textarea" name="body" rows="4" required></textarea>
        </div>
    </div>
    <div class="field is-grouped">
        <div class="control"><button class="button is-primary" type="submit">Aggiungi commento</button></div>
        <div class="control"><a href="/tickets" class="button is-light">Torna ai ticket</a></div>
    </div>
</form>
';

include __DIR__ . '/layout.php';
