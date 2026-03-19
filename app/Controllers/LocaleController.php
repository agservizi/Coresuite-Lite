<?php
use Core\Locale;

class LocaleController {
    public function set($params = []) {
        $locale = (string)($params['code'] ?? 'it');
        Locale::set($locale);

        $redirect = (string)($_GET['redirect'] ?? '/dashboard');
        if ($redirect === '' || strpos($redirect, '/') !== 0) {
            $redirect = '/dashboard';
        }

        header('Location: ' . $redirect);
        exit;
    }
}
