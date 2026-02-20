<?php
$pageTitle = '404 - Pagina non trovata';
$content = '
<div class="hero is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title is-1">404</h1>
            <h2 class="subtitle is-3">Pagina non trovata</h2>
            <p>La pagina che stai cercando non esiste.</p>
            <a href="/" class="button is-primary">Torna alla home</a>
        </div>
    </div>
</div>
';
include __DIR__ . '/../layout.php';
?>