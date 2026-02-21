<?php
$pageTitle = '404 - Pagina non trovata';
$content = '
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-6xl font-bold">404</h1>
        <h2 class="text-2xl mt-2">Pagina non trovata</h2>
        <p class="mt-4 text-gray-600">La pagina che stai cercando non esiste.</p>
        <a href="/" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded">Torna alla home</a>
    </div>
</div>
';
include __DIR__ . '/../layout.php';
?>