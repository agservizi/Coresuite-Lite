<?php
namespace Core;

class WorkspaceSettings {
    private static $defaults = [
        'workspace_name' => 'CoreSuite Lite',
        'environment_label' => 'Production workspace',
        'support_email' => 'support@example.com',
        'support_phone' => '',
        'app_url' => '',
        'legal_name' => 'CoreSuite Lite S.r.l.',
        'address_line' => '',
        'address_city' => '',
        'address_zip' => '',
        'address_country' => 'Italia',
        'vat_number' => '',
        'tax_code' => '',
        'pec_email' => '',
        'sdi_code' => '',
        'iban' => '',
        'default_theme' => 'system',
        'mail_driver' => 'disabled',
        'mail_from_name' => 'CoreSuite Lite',
        'mail_from_email' => '',
        'mail_reply_to' => '',
        'smtp_host' => '',
        'smtp_port' => 587,
        'smtp_username' => '',
        'smtp_password' => '',
        'smtp_encryption' => 'tls',
        'smtp_timeout' => 15,
        'smtp_auth_enabled' => true,
        'resend_api_key' => '',
        'sidebar_collapsed_default' => false,
        'customers_enabled' => true,
        'reports_enabled' => true,
        'audit_logs_enabled' => true,
        'documents_board_enabled' => true,
        'spotlight_hints_enabled' => true,
    ];

    private static $cache = null;

    private static function path() {
        return __DIR__ . '/../storage/workspace_settings.json';
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
        $current = self::all();
        $settings = self::$defaults;
        $settings['workspace_name'] = trim((string)($input['workspace_name'] ?? self::$defaults['workspace_name']));
        $settings['environment_label'] = trim((string)($input['environment_label'] ?? self::$defaults['environment_label']));
        $settings['support_email'] = trim((string)($input['support_email'] ?? self::$defaults['support_email']));
        $settings['support_phone'] = trim((string)($input['support_phone'] ?? ($current['support_phone'] ?? self::$defaults['support_phone'])));
        $settings['app_url'] = trim((string)($input['app_url'] ?? ($current['app_url'] ?? self::$defaults['app_url'])));
        $settings['legal_name'] = trim((string)($input['legal_name'] ?? ($current['legal_name'] ?? self::$defaults['legal_name'])));
        $settings['address_line'] = trim((string)($input['address_line'] ?? ($current['address_line'] ?? self::$defaults['address_line'])));
        $settings['address_city'] = trim((string)($input['address_city'] ?? ($current['address_city'] ?? self::$defaults['address_city'])));
        $settings['address_zip'] = trim((string)($input['address_zip'] ?? ($current['address_zip'] ?? self::$defaults['address_zip'])));
        $settings['address_country'] = trim((string)($input['address_country'] ?? ($current['address_country'] ?? self::$defaults['address_country'])));
        $settings['vat_number'] = trim((string)($input['vat_number'] ?? ($current['vat_number'] ?? self::$defaults['vat_number'])));
        $settings['tax_code'] = trim((string)($input['tax_code'] ?? ($current['tax_code'] ?? self::$defaults['tax_code'])));
        $settings['pec_email'] = trim((string)($input['pec_email'] ?? ($current['pec_email'] ?? self::$defaults['pec_email'])));
        $settings['sdi_code'] = trim((string)($input['sdi_code'] ?? ($current['sdi_code'] ?? self::$defaults['sdi_code'])));
        $settings['iban'] = trim((string)($input['iban'] ?? ($current['iban'] ?? self::$defaults['iban'])));

        $theme = (string)($input['default_theme'] ?? self::$defaults['default_theme']);
        $settings['default_theme'] = in_array($theme, ['light', 'dark', 'system'], true) ? $theme : self::$defaults['default_theme'];

        $mailDriver = strtolower(trim((string)($input['mail_driver'] ?? ($current['mail_driver'] ?? self::$defaults['mail_driver']))));
        $settings['mail_driver'] = in_array($mailDriver, ['disabled', 'log', 'smtp', 'resend'], true) ? $mailDriver : self::$defaults['mail_driver'];
        $settings['mail_from_name'] = trim((string)($input['mail_from_name'] ?? ($current['mail_from_name'] ?? self::$defaults['mail_from_name'])));
        $settings['mail_from_email'] = trim((string)($input['mail_from_email'] ?? ($current['mail_from_email'] ?? self::$defaults['mail_from_email'])));
        $settings['mail_reply_to'] = trim((string)($input['mail_reply_to'] ?? ($current['mail_reply_to'] ?? self::$defaults['mail_reply_to'])));
        $settings['smtp_host'] = trim((string)($input['smtp_host'] ?? ($current['smtp_host'] ?? self::$defaults['smtp_host'])));
        $settings['smtp_port'] = max(1, (int)($input['smtp_port'] ?? ($current['smtp_port'] ?? self::$defaults['smtp_port'])));
        $settings['smtp_username'] = trim((string)($input['smtp_username'] ?? ($current['smtp_username'] ?? self::$defaults['smtp_username'])));

        $smtpPassword = (string)($input['smtp_password'] ?? '');
        $settings['smtp_password'] = $smtpPassword !== '' ? $smtpPassword : (string)($current['smtp_password'] ?? self::$defaults['smtp_password']);

        $smtpEncryption = strtolower(trim((string)($input['smtp_encryption'] ?? ($current['smtp_encryption'] ?? self::$defaults['smtp_encryption']))));
        $settings['smtp_encryption'] = in_array($smtpEncryption, ['none', 'tls', 'ssl'], true) ? $smtpEncryption : self::$defaults['smtp_encryption'];
        $settings['smtp_timeout'] = max(5, (int)($input['smtp_timeout'] ?? ($current['smtp_timeout'] ?? self::$defaults['smtp_timeout'])));
        $settings['smtp_auth_enabled'] = !empty($input['smtp_auth_enabled']);

        $resendKey = trim((string)($input['resend_api_key'] ?? ''));
        $settings['resend_api_key'] = $resendKey !== '' ? $resendKey : (string)($current['resend_api_key'] ?? self::$defaults['resend_api_key']);

        foreach ([
            'sidebar_collapsed_default',
            'customers_enabled',
            'reports_enabled',
            'audit_logs_enabled',
            'documents_board_enabled',
            'spotlight_hints_enabled',
        ] as $key) {
            $settings[$key] = !empty($input[$key]);
        }

        if ($settings['workspace_name'] === '') {
            $settings['workspace_name'] = self::$defaults['workspace_name'];
        }
        if ($settings['environment_label'] === '') {
            $settings['environment_label'] = self::$defaults['environment_label'];
        }
        if ($settings['support_email'] === '') {
            $settings['support_email'] = self::$defaults['support_email'];
        }
        if ($settings['legal_name'] === '') {
            $settings['legal_name'] = self::$defaults['legal_name'];
        }
        if ($settings['mail_from_name'] === '') {
            $settings['mail_from_name'] = self::$defaults['mail_from_name'];
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
