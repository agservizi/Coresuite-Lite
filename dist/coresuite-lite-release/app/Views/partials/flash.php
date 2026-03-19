<!-- app/Views/partials/flash.php -->
<?php
$locale = \Core\Locale::current();
$notificationCopy = [
    'it' => [
        'success' => 'Operazione completata',
        'danger' => 'Attenzione richiesta',
        'warning' => 'Segnale operativo',
        'info' => 'Aggiornamento workspace',
        'close' => 'Chiudi notifica',
        'source' => 'CoreSuite Lite',
    ],
    'en' => [
        'success' => 'Action completed',
        'danger' => 'Attention required',
        'warning' => 'Operational signal',
        'info' => 'Workspace update',
        'close' => 'Close notification',
        'source' => 'CoreSuite Lite',
    ],
    'fr' => [
        'success' => 'Action terminee',
        'danger' => 'Attention requise',
        'warning' => 'Signal operationnel',
        'info' => 'Mise a jour workspace',
        'close' => 'Fermer la notification',
        'source' => 'CoreSuite Lite',
    ],
    'es' => [
        'success' => 'Accion completada',
        'danger' => 'Atencion requerida',
        'warning' => 'Senal operativa',
        'info' => 'Actualizacion workspace',
        'close' => 'Cerrar notificacion',
        'source' => 'CoreSuite Lite',
    ],
];

$copy = $notificationCopy[$locale] ?? $notificationCopy['it'];
$notifications = [];

$buildNotification = static function (string $type, string $message) use ($copy): array {
    $tone = in_array($type, ['success', 'danger', 'warning'], true) ? $type : 'info';
    $icons = [
        'success' => 'fa-circle-check',
        'danger' => 'fa-triangle-exclamation',
        'warning' => 'fa-bell',
        'info' => 'fa-sparkles',
    ];

    return [
        'tone' => $tone,
        'title' => $copy[$tone] ?? $copy['info'],
        'message' => $message,
        'icon' => $icons[$tone] ?? $icons['info'],
        'role' => $tone === 'danger' ? 'alert' : 'status',
        'dismiss' => $tone === 'danger' ? 7600 : 5600,
    ];
};

if (isset($_SESSION['flash'])) {
    $notifications[] = $buildNotification(
        (string)($_SESSION['flash']['type'] ?? 'info'),
        (string)($_SESSION['flash']['message'] ?? '')
    );
    unset($_SESSION['flash']);
}

if (isset($error) && is_string($error) && $error !== '') {
    $notifications[] = $buildNotification('danger', $error);
}

if (isset($message) && is_string($message) && $message !== '') {
    $notifications[] = $buildNotification('success', $message);
}
?>
<?php if (!empty($notifications)): ?>
<div class="browser-notification-stack" data-browser-notification-stack>
    <?php foreach ($notifications as $notification): ?>
        <article
            class="browser-notification is-<?php echo htmlspecialchars($notification['tone']); ?>"
            data-browser-notification
            data-auto-dismiss="<?php echo (int)$notification['dismiss']; ?>"
            role="<?php echo htmlspecialchars($notification['role']); ?>"
            aria-live="polite"
        >
            <span class="browser-notification__accent" aria-hidden="true"></span>
            <span class="browser-notification__icon" aria-hidden="true"><i class="fas <?php echo htmlspecialchars($notification['icon']); ?>"></i></span>
            <div class="browser-notification__content">
                <span class="browser-notification__eyebrow"><?php echo htmlspecialchars($copy['source']); ?></span>
                <strong><?php echo htmlspecialchars($notification['title']); ?></strong>
                <p><?php echo htmlspecialchars($notification['message']); ?></p>
            </div>
            <button class="browser-notification__close" type="button" data-browser-notification-close aria-label="<?php echo htmlspecialchars($copy['close']); ?>">
                <i class="fas fa-xmark" aria-hidden="true"></i>
            </button>
            <span class="browser-notification__progress" aria-hidden="true"></span>
        </article>
    <?php endforeach; ?>
</div>
<?php endif; ?>