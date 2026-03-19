<?php
use Core\Locale;

$error403Text = [
    'it' => ['page_title' => '403 - Accesso negato', 'title' => 'Accesso negato', 'text' => 'Non hai i permessi necessari per visualizzare questa pagina o eseguire questa azione.', 'back_dashboard' => 'Torna alla dashboard', 'profile' => 'Area personale'],
    'en' => ['page_title' => '403 - Access denied', 'title' => 'Access denied', 'text' => 'You do not have the necessary permissions to view this page or perform this action.', 'back_dashboard' => 'Back to dashboard', 'profile' => 'Personal area'],
    'fr' => ['page_title' => '403 - Acces refuse', 'title' => 'Acces refuse', 'text' => 'Vous n avez pas les permissions necessaires pour afficher cette page ou executer cette action.', 'back_dashboard' => 'Retour au dashboard', 'profile' => 'Espace personnel'],
    'es' => ['page_title' => '403 - Acceso denegado', 'title' => 'Acceso denegado', 'text' => 'No tienes los permisos necesarios para ver esta pagina o ejecutar esta accion.', 'back_dashboard' => 'Volver al dashboard', 'profile' => 'Area personal'],
];
$e403 = $error403Text[Locale::current()] ?? $error403Text['it'];
$pageTitle = $e403['page_title'];

ob_start();
?>
<div class="admin-error-state">
    <div class="card admin-error-card text-center">
        <div class="card-body">
            <div class="admin-error-code">403</div>
            <h2 class="admin-error-title"><?php echo htmlspecialchars($e403['title']); ?></h2>
            <p class="admin-error-text"><?php echo htmlspecialchars($e403['text']); ?></p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="/dashboard" class="btn btn-primary"><?php echo htmlspecialchars($e403['back_dashboard']); ?></a>
                <a href="/profile" class="btn btn-outline-secondary"><?php echo htmlspecialchars($e403['profile']); ?></a>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();

include __DIR__ . '/../layout.php';
