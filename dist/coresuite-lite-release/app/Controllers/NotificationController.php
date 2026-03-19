<?php
use Core\Auth;
use Core\Locale;
use Core\NotificationSettings;
use Core\RolePermissions;

class NotificationController {
    private function authorizeAdmin() {
        if (!Auth::isAdmin() || !RolePermissions::canCurrent('notification_settings_view')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    public function settings($params = []) {
        $this->authorizeAdmin();
        $settings = NotificationSettings::all();
        include __DIR__ . '/../Views/notification_settings.php';
    }

    public function updateSettings($params = []) {
        $this->authorizeAdmin();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /workspace/notifications');
            exit;
        }

        NotificationSettings::save($_POST);
        Auth::logAction('update', 'notification_settings', 1);
        Auth::flash(Locale::runtime('notification_settings_updated'), 'success');
        header('Location: /workspace/notifications');
        exit;
    }
}
