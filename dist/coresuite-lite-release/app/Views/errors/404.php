<?php
use Core\Locale;

$error404Text = [
    'it' => ['page_title' => '404 - Pagina non trovata', 'title' => 'Pagina non trovata', 'text' => 'La risorsa che stai cercando non esiste piu o il link non e valido.', 'back_dashboard' => 'Torna alla dashboard', 'open_tickets' => 'Apri ticket'],
    'en' => ['page_title' => '404 - Page not found', 'title' => 'Page not found', 'text' => 'The resource you are looking for no longer exists or the link is invalid.', 'back_dashboard' => 'Back to dashboard', 'open_tickets' => 'Open tickets'],
    'fr' => ['page_title' => '404 - Page introuvable', 'title' => 'Page introuvable', 'text' => 'La ressource que vous recherchez n existe plus ou le lien n est pas valide.', 'back_dashboard' => 'Retour au dashboard', 'open_tickets' => 'Ouvrir tickets'],
    'es' => ['page_title' => '404 - Pagina no encontrada', 'title' => 'Pagina no encontrada', 'text' => 'El recurso que buscas ya no existe o el enlace no es valido.', 'back_dashboard' => 'Volver al dashboard', 'open_tickets' => 'Abrir tickets'],
];
$e404 = $error404Text[Locale::current()] ?? $error404Text['it'];
$pageTitle = $e404['page_title'];

ob_start();
?>
<div class="admin-error-state">
    <div class="card admin-error-card text-center">
        <div class="card-body">
            <div class="admin-error-code">404</div>
            <h2 class="admin-error-title"><?php echo htmlspecialchars($e404['title']); ?></h2>
            <p class="admin-error-text"><?php echo htmlspecialchars($e404['text']); ?></p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="/dashboard" class="btn btn-primary"><?php echo htmlspecialchars($e404['back_dashboard']); ?></a>
                <a href="/tickets" class="btn btn-outline-secondary"><?php echo htmlspecialchars($e404['open_tickets']); ?></a>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layout.php';
