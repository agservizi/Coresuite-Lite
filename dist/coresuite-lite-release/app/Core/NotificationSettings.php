<?php
namespace Core;

class NotificationSettings {
    private static $defaults = [
        'in_app_workspace_updates' => true,
        'in_app_ticket_activity' => true,
        'in_app_document_activity' => true,
        'in_app_admin_alerts' => true,
        'dashboard_notification_inbox' => true,
        'email_daily_digest' => false,
        'email_new_ticket' => true,
        'email_ticket_status' => true,
        'email_document_upload' => false,
    ];

    private static $cache = null;

    private static function path() {
        return __DIR__ . '/../storage/notification_settings.json';
    }

    public static function all() {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $settings = self::$defaults;
        $path = self::path();
        if (is_file($path)) {
            $raw = file_get_contents($path);
            $decoded = json_decode((string)$raw, true);
            if (is_array($decoded)) {
                $settings = array_merge($settings, $decoded);
            }
        }

        self::$cache = $settings;
        return $settings;
    }

    public static function get($key, $default = null) {
        $settings = self::all();
        return $settings[$key] ?? $default;
    }

    public static function save(array $input) {
        $settings = self::$defaults;
        foreach (array_keys(self::$defaults) as $key) {
            $settings[$key] = !empty($input[$key]);
        }

        $dir = dirname(self::path());
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents(
            self::path(),
            json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );

        self::$cache = $settings;
        return $settings;
    }
}
