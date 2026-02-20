<?php
$pageTitle = '403 - Accesso negato';
$content = '
<div class="hero is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title is-1">403</h1>
            <h2 class="subtitle is-3">Accesso negato</h2>
            <p>Non hai i permessi per accedere a questa pagina.</p>
            <a href="/dashboard" class="button is-primary">Torna alla dashboard</a>
        </div>
    </div>
</div>
';
include __DIR__ . '/../layout.php';
?>