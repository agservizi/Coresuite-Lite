<?php
use Core\DB;
use Core\Config;
use Core\Locale;

// app/Controllers/InstallController.php

class InstallController {
    public function index($params = []) {
        if (!Config::isInstallEnabled()) {
            if (Config::isConfigured()) {
                header('Location: ' . $this->loginUrl());
                exit;
            }

            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->setup();
        }

        include __DIR__ . '/../Views/install.php';
    }

    private function setup() {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            echo Locale::runtime('csrf_invalid_plain');
            return;
        }

        $dbHost = trim($_POST['db_host'] ?? '');
        $dbName = trim($_POST['db_name'] ?? '');
        $dbUser = trim($_POST['db_user'] ?? '');
        $dbPass = $_POST['db_pass'] ?? '';
        $adminName = trim($_POST['admin_name'] ?? '');
        $adminEmail = trim($_POST['admin_email'] ?? '');
        $adminPass = $_POST['admin_pass'] ?? '';
        $appUrl = trim((string)($_POST['app_url'] ?? ''));
        $mailDriver = strtolower(trim((string)($_POST['mail_driver'] ?? 'disabled')));
        $mailFromName = trim((string)($_POST['mail_from_name'] ?? 'CoreSuite Lite'));
        $mailFromEmail = trim((string)($_POST['mail_from_email'] ?? ''));
        $mailReplyTo = trim((string)($_POST['mail_reply_to'] ?? ''));
        $smtpHost = trim((string)($_POST['smtp_host'] ?? ''));
        $smtpPort = (int)($_POST['smtp_port'] ?? 587);
        $smtpUsername = trim((string)($_POST['smtp_username'] ?? ''));
        $smtpPassword = (string)($_POST['smtp_password'] ?? '');
        $smtpEncryption = strtolower(trim((string)($_POST['smtp_encryption'] ?? 'tls')));
        $smtpTimeout = (int)($_POST['smtp_timeout'] ?? 15);
        $smtpAuthEnabled = !empty($_POST['smtp_auth_enabled']) ? '1' : '0';
        $resendApiKey = trim((string)($_POST['resend_api_key'] ?? ''));

        if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            echo Locale::runtime('admin_email_invalid');
            return;
        }

        if ($appUrl !== '' && !filter_var($appUrl, FILTER_VALIDATE_URL)) {
            echo Locale::runtime('app_url_invalid');
            return;
        }

        if (!in_array($mailDriver, ['disabled', 'log', 'smtp', 'resend'], true)) {
            echo Locale::runtime('mail_driver_invalid');
            return;
        }

        if ($mailDriver !== 'disabled' && !filter_var($mailFromEmail, FILTER_VALIDATE_EMAIL)) {
            echo Locale::runtime('mail_from_invalid');
            return;
        }

        if ($mailReplyTo !== '' && !filter_var($mailReplyTo, FILTER_VALIDATE_EMAIL)) {
            echo Locale::runtime('mail_reply_to_invalid');
            return;
        }

        if ($mailDriver === 'smtp') {
            if ($smtpHost === '') {
                echo Locale::runtime('smtp_host_required');
                return;
            }

            if ($smtpPort < 1 || $smtpPort > 65535 || $smtpTimeout < 1 || $smtpTimeout > 120) {
                echo Locale::runtime('smtp_port_invalid');
                return;
            }

            if (!in_array($smtpEncryption, ['none', 'tls', 'ssl'], true)) {
                echo Locale::runtime('smtp_encryption_invalid');
                return;
            }
        }

        if ($mailDriver === 'resend' && $resendApiKey === '') {
            echo Locale::runtime('resend_api_key_required');
            return;
        }

        Config::writeEnv([
            'DB_HOST' => $dbHost,
            'DB_NAME' => $dbName,
            'DB_USER' => $dbUser,
            'DB_PASS' => $dbPass,
            'APP_URL' => $appUrl,
            'MAIL_DRIVER' => $mailDriver,
            'MAIL_FROM_NAME' => $mailFromName,
            'MAIL_FROM_EMAIL' => $mailFromEmail,
            'MAIL_REPLY_TO' => $mailReplyTo,
            'SMTP_HOST' => $smtpHost,
            'SMTP_PORT' => (string)$smtpPort,
            'SMTP_USERNAME' => $smtpUsername,
            'SMTP_PASSWORD' => $smtpPassword,
            'SMTP_ENCRYPTION' => $smtpEncryption,
            'SMTP_TIMEOUT' => (string)$smtpTimeout,
            'SMTP_AUTH_ENABLED' => $smtpAuthEnabled,
            'RESEND_API_KEY' => $resendApiKey,
            'INSTALL_ENABLED' => '0',
        ]);

        Config::load();
        DB::init();

        // Crea tabelle
        $this->createTables();

        // Crea admin
        $adminPasswordHash = password_hash($adminPass, PASSWORD_DEFAULT);
        $stmt = DB::prepare("INSERT INTO users (name, email, password_hash, role, status) VALUES (?, ?, ?, 'admin', 'active')");
        $stmt->execute([$adminName, $adminEmail, $adminPasswordHash]);

        header('Location: ' . $this->loginUrl());
        exit;
    }

    private function createTables() {
        // Esegui schema.sql
        $schema = file_get_contents(__DIR__ . '/../../schema.sql');
        DB::getPDO()->exec($schema);
    }

    private function loginUrl(): string {
        return '/login';
    }
}
