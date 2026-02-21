<?php
$pageTitle = '403 - Accesso negato';
$content = '
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-6xl font-bold">403</h1>
        <h2 class="text-2xl mt-2">Accesso negato</h2>
        <p class="mt-4 text-gray-600">Non hai i permessi per accedere a questa pagina.</p>
        <a href="/dashboard" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded">Torna alla dashboard</a>
    </div>
</div>
';
include __DIR__ . '/../layout.php';
?>