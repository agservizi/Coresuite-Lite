<?php
use Core\Auth;
use Core\Locale;
use Core\Mail;
use Core\RolePermissions;
use Core\WorkspaceSettings;

class WorkspaceController {
    private function authorizeAdmin() {
        if (!Auth::isAdmin() || !RolePermissions::canCurrent('workspace_settings_view')) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    public function settings($params = []) {
        $this->authorizeAdmin();
        $settings = WorkspaceSettings::all();
        $mailStatus = Mail::status();
        $currentUser = Auth::user();
        $mailTestRecipient = trim((string)($settings['support_email'] ?? ($currentUser['email'] ?? '')));
        include __DIR__ . '/../Views/workspace_settings.php';
    }

    public function updateSettings($params = []) {
        $this->authorizeAdmin();

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash(Locale::runtime('csrf_invalid'), 'danger');
            header('Location: /workspace/settings');
            exit;
        }

        $workspaceName = trim((string)($_POST['workspace_name'] ?? ''));
        $environmentLabel = trim((string)($_POST['environment_label'] ?? ''));
        $supportEmail = trim((string)($_POST['support_email'] ?? ''));

        if ($workspaceName === '' || $environmentLabel === '') {
            Auth::flash(Locale::runtime('workspace_required'), 'danger');
            header('Location: /workspace/settings');
            exit;
        }

        if ($supportEmail !== '' && !filter_var($supportEmail, FILTER_VALIDATE_EMAIL)) {
            Auth::flash(Locale::runtime('support_email_invalid'), 'danger');
            header('Location: /workspace/settings');
            exit;
        }

        $mailError = $this->validateMailSettings($_POST);
        if ($mailError !== null) {
            Auth::flash($mailError, 'danger');
            header('Location: /workspace/settings');
            exit;
        }

        WorkspaceSettings::save($_POST);
        Auth::logAction('update', 'workspace', 1);

        if (($_POST['action'] ?? 'save') === 'send_test_email') {
            $recipient = trim((string)($_POST['mail_test_recipient'] ?? ''));
            if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                Auth::flash(Locale::runtime('mail_test_recipient_invalid'), 'danger');
                header('Location: /workspace/settings');
                exit;
            }

            if (Mail::sendTestEmail($recipient)) {
                Auth::flash(Locale::runtime('mail_test_sent', ['email' => $recipient]), 'success');
            } else {
                Auth::flash(Locale::runtime('mail_test_failed'), 'danger');
            }

            header('Location: /workspace/settings');
            exit;
        }

        Auth::flash(Locale::runtime('workspace_updated'), 'success');
        header('Location: /workspace/settings');
        exit;
    }

    private function validateMailSettings(array $input): ?string {
        $appUrl = trim((string)($input['app_url'] ?? ''));
        $mailDriver = strtolower(trim((string)($input['mail_driver'] ?? 'disabled')));
        $mailFromEmail = trim((string)($input['mail_from_email'] ?? ''));
        $mailReplyTo = trim((string)($input['mail_reply_to'] ?? ''));
        $smtpHost = trim((string)($input['smtp_host'] ?? ''));
        $smtpPort = (int)($input['smtp_port'] ?? 587);
        $smtpTimeout = (int)($input['smtp_timeout'] ?? 15);
        $smtpEncryption = strtolower(trim((string)($input['smtp_encryption'] ?? 'tls')));
        $resendApiKey = trim((string)($input['resend_api_key'] ?? ''));

        if ($appUrl !== '' && !filter_var($appUrl, FILTER_VALIDATE_URL)) {
            return Locale::runtime('app_url_invalid');
        }

        if (!in_array($mailDriver, ['disabled', 'log', 'smtp', 'resend'], true)) {
            return Locale::runtime('mail_driver_invalid');
        }

        if ($mailDriver !== 'disabled' && !filter_var($mailFromEmail, FILTER_VALIDATE_EMAIL)) {
            return Locale::runtime('mail_from_invalid');
        }

        if ($mailReplyTo !== '' && !filter_var($mailReplyTo, FILTER_VALIDATE_EMAIL)) {
            return Locale::runtime('mail_reply_to_invalid');
        }

        if ($mailDriver === 'smtp') {
            if ($smtpHost === '') {
                return Locale::runtime('smtp_host_required');
            }

            if ($smtpPort < 1 || $smtpPort > 65535 || $smtpTimeout < 1 || $smtpTimeout > 120) {
                return Locale::runtime('smtp_port_invalid');
            }

            if (!in_array($smtpEncryption, ['none', 'tls', 'ssl'], true)) {
                return Locale::runtime('smtp_encryption_invalid');
            }
        }

        if ($mailDriver === 'resend' && $resendApiKey === '') {
            return Locale::runtime('resend_api_key_required');
        }

        return null;
    }
}
