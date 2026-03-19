<?php
namespace Core;

class Mail {
    public static function config(): array {
        $settings = WorkspaceSettings::all();

        $smtpPort = (int)($settings['smtp_port'] ?? Config::get('SMTP_PORT', 587));
        $smtpTimeout = (int)($settings['smtp_timeout'] ?? Config::get('SMTP_TIMEOUT', 15));
        $smtpAuthSetting = $settings['smtp_auth_enabled'] ?? Config::get('SMTP_AUTH_ENABLED', '1');

        return [
            'app_url' => trim((string)($settings['app_url'] ?? Config::get('APP_URL', ''))),
            'mail_driver' => strtolower(trim((string)($settings['mail_driver'] ?? Config::get('MAIL_DRIVER', 'disabled')))),
            'mail_from_name' => trim((string)($settings['mail_from_name'] ?? Config::get('MAIL_FROM_NAME', 'CoreSuite Lite'))),
            'mail_from_email' => trim((string)($settings['mail_from_email'] ?? Config::get('MAIL_FROM_EMAIL', ''))),
            'mail_reply_to' => trim((string)($settings['mail_reply_to'] ?? Config::get('MAIL_REPLY_TO', ''))),
            'smtp_host' => trim((string)($settings['smtp_host'] ?? Config::get('SMTP_HOST', ''))),
            'smtp_port' => $smtpPort > 0 ? $smtpPort : 587,
            'smtp_username' => trim((string)($settings['smtp_username'] ?? Config::get('SMTP_USERNAME', ''))),
            'smtp_password' => (string)($settings['smtp_password'] ?? Config::get('SMTP_PASSWORD', '')),
            'smtp_encryption' => strtolower(trim((string)($settings['smtp_encryption'] ?? Config::get('SMTP_ENCRYPTION', 'tls')))),
            'smtp_timeout' => $smtpTimeout > 0 ? $smtpTimeout : 15,
            'smtp_auth_enabled' => self::toBool($smtpAuthSetting, true),
            'resend_api_key' => trim((string)($settings['resend_api_key'] ?? Config::get('RESEND_API_KEY', ''))),
        ];
    }

    public static function status(): array {
        $config = self::config();
        $driver = $config['mail_driver'];

        return [
            'driver' => $driver,
            'configured' => self::driverConfigured($config),
            'from_email' => $config['mail_from_email'],
            'from_name' => $config['mail_from_name'],
            'reply_to' => $config['mail_reply_to'],
        ];
    }

    public static function appUrl(): string {
        $config = self::config();
        $appUrl = rtrim($config['app_url'], '/');
        if ($appUrl !== '') {
            return $appUrl;
        }

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $scheme . '://' . $host;
    }

    public static function sendPasswordReset(string $toEmail, string $resetLink, ?string $recipientName = null): bool {
        $locale = Locale::current();
        $copy = self::passwordResetCopy($locale);
        $settings = WorkspaceSettings::all();
        $workspaceName = trim((string)($settings['workspace_name'] ?? 'CoreSuite Lite')) ?: 'CoreSuite Lite';

        $subject = str_replace(':workspace', $workspaceName, $copy['subject']);
        $greeting = str_replace(':name', trim((string)$recipientName) !== '' ? trim((string)$recipientName) : $copy['user_fallback'], $copy['greeting']);
        $html = self::wrapHtmlTemplate(
            $workspaceName,
            $subject,
            $greeting,
            $copy['intro'],
            $copy['cta'],
            $resetLink,
            $copy['footer']
        );
        $text = implode("\n\n", [
            $subject,
            $greeting,
            $copy['intro'],
            $copy['cta'] . ': ' . $resetLink,
            $copy['footer'],
        ]);

        return self::send([
            'to' => $toEmail,
            'subject' => $subject,
            'html' => $html,
            'text' => $text,
        ]);
    }

    public static function sendTestEmail(string $toEmail): bool {
        $status = self::status();
        $driver = $status['driver'];
        $workspaceName = trim((string)(WorkspaceSettings::get('workspace_name', 'CoreSuite Lite'))) ?: 'CoreSuite Lite';
        $subject = $workspaceName . ' - Mail configuration test';
        $html = self::wrapHtmlTemplate(
            $workspaceName,
            $subject,
            'Hello,',
            'This test email confirms that your workspace mail delivery is configured and working.',
            'Open workspace',
            self::appUrl() . '/login',
            'Current mail driver: ' . strtoupper($driver)
        );
        $text = implode("\n\n", [
            $subject,
            'This test email confirms that your workspace mail delivery is configured and working.',
            'Workspace URL: ' . self::appUrl() . '/login',
            'Current mail driver: ' . strtoupper($driver),
        ]);

        return self::send([
            'to' => $toEmail,
            'subject' => $subject,
            'html' => $html,
            'text' => $text,
        ]);
    }

    public static function send(array $payload): bool {
        $config = self::config();
        $driver = $config['mail_driver'];
        $to = trim((string)($payload['to'] ?? ''));
        $subject = trim((string)($payload['subject'] ?? ''));
        $html = (string)($payload['html'] ?? '');
        $text = (string)($payload['text'] ?? '');

        if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL) || $subject === '') {
            Logger::warning('mail_invalid_payload', ['to' => $to, 'subject' => $subject]);
            return false;
        }

        if (!$config['mail_from_email'] || !filter_var($config['mail_from_email'], FILTER_VALIDATE_EMAIL)) {
            Logger::warning('mail_missing_from_email', ['driver' => $driver]);
            return false;
        }

        try {
            if ($driver === 'log') {
                Logger::info('mail_logged', [
                    'to' => $to,
                    'subject' => $subject,
                    'driver' => $driver,
                    'text' => $text,
                    'html' => $html,
                ]);
                return true;
            }

            if ($driver === 'resend') {
                return self::sendViaResend($config, $to, $subject, $html, $text);
            }

            if ($driver === 'smtp') {
                return self::sendViaSmtp($config, $to, $subject, $html, $text);
            }

            Logger::warning('mail_driver_disabled_or_unknown', ['driver' => $driver, 'to' => $to]);
            return false;
        } catch (\Throwable $e) {
            Logger::error('mail_send_failed', [
                'driver' => $driver,
                'to' => $to,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }

    private static function driverConfigured(array $config): bool {
        if ($config['mail_driver'] === 'smtp') {
            return $config['smtp_host'] !== '' && $config['mail_from_email'] !== '';
        }

        if ($config['mail_driver'] === 'resend') {
            return $config['resend_api_key'] !== '' && $config['mail_from_email'] !== '';
        }

        if ($config['mail_driver'] === 'log') {
            return true;
        }

        return false;
    }

    private static function sendViaResend(array $config, string $to, string $subject, string $html, string $text): bool {
        if ($config['resend_api_key'] === '') {
            throw new \RuntimeException('Missing RESEND API key');
        }

        $headers = [
            'Authorization: Bearer ' . $config['resend_api_key'],
            'Content-Type: application/json',
        ];

        $payload = [
            'from' => self::formatAddress($config['mail_from_email'], $config['mail_from_name']),
            'to' => [$to],
            'subject' => $subject,
            'html' => $html,
            'text' => $text,
        ];

        if ($config['mail_reply_to'] !== '' && filter_var($config['mail_reply_to'], FILTER_VALIDATE_EMAIL)) {
            $payload['reply_to'] = $config['mail_reply_to'];
        }

        $response = self::httpPostJson('https://api.resend.com/emails', $headers, $payload);
        if ($response['status'] < 200 || $response['status'] >= 300) {
            throw new \RuntimeException('Resend API error: HTTP ' . $response['status'] . ' ' . $response['body']);
        }

        Logger::info('mail_sent', ['driver' => 'resend', 'to' => $to, 'subject' => $subject]);
        return true;
    }

    private static function sendViaSmtp(array $config, string $to, string $subject, string $html, string $text): bool {
        if ($config['smtp_host'] === '') {
            throw new \RuntimeException('Missing SMTP host');
        }

        $host = $config['smtp_host'];
        $port = (int)$config['smtp_port'];
        $encryption = strtolower((string)$config['smtp_encryption']);
        $timeout = (int)$config['smtp_timeout'];

        $transportHost = $host;
        if ($encryption === 'ssl') {
            $transportHost = 'ssl://' . $host;
        }

        $socket = @stream_socket_client($transportHost . ':' . $port, $errno, $errstr, $timeout);
        if (!$socket) {
            throw new \RuntimeException('SMTP connection failed: ' . $errstr . ' (' . $errno . ')');
        }

        stream_set_timeout($socket, $timeout);
        self::smtpExpect($socket, [220]);
        self::smtpCommand($socket, 'EHLO localhost', [250]);

        if ($encryption === 'tls') {
            self::smtpCommand($socket, 'STARTTLS', [220]);
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                fclose($socket);
                throw new \RuntimeException('Unable to enable TLS for SMTP connection');
            }
            self::smtpCommand($socket, 'EHLO localhost', [250]);
        }

        if (!empty($config['smtp_auth_enabled'])) {
            self::smtpCommand($socket, 'AUTH LOGIN', [334]);
            self::smtpCommand($socket, base64_encode((string)$config['smtp_username']), [334]);
            self::smtpCommand($socket, base64_encode((string)$config['smtp_password']), [235]);
        }

        self::smtpCommand($socket, 'MAIL FROM:<' . $config['mail_from_email'] . '>', [250]);
        self::smtpCommand($socket, 'RCPT TO:<' . $to . '>', [250, 251]);
        self::smtpCommand($socket, 'DATA', [354]);

        $boundary = 'coresuite_' . bin2hex(random_bytes(8));
        $headers = [
            'Date: ' . date(DATE_RFC2822),
            'From: ' . self::formatAddress($config['mail_from_email'], $config['mail_from_name']),
            'To: <' . $to . '>',
            'Subject: ' . self::encodeHeader($subject),
            'MIME-Version: 1.0',
            'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
        ];

        if ($config['mail_reply_to'] !== '' && filter_var($config['mail_reply_to'], FILTER_VALIDATE_EMAIL)) {
            $headers[] = 'Reply-To: <' . $config['mail_reply_to'] . '>';
        }

        $body = implode("\r\n", $headers) . "\r\n\r\n";
        $body .= '--' . $boundary . "\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= self::escapeSmtpBody($text) . "\r\n";
        $body .= '--' . $boundary . "\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= self::escapeSmtpBody($html) . "\r\n";
        $body .= '--' . $boundary . "--\r\n.";

        fwrite($socket, $body . "\r\n");
        self::smtpExpect($socket, [250]);
        self::smtpCommand($socket, 'QUIT', [221]);
        fclose($socket);

        Logger::info('mail_sent', ['driver' => 'smtp', 'to' => $to, 'subject' => $subject]);
        return true;
    }

    private static function smtpCommand($socket, string $command, array $expectedCodes): string {
        fwrite($socket, $command . "\r\n");
        return self::smtpExpect($socket, $expectedCodes, $command);
    }

    private static function smtpExpect($socket, array $expectedCodes, string $command = ''): string {
        $response = '';
        while (!feof($socket)) {
            $line = fgets($socket, 515);
            if ($line === false) {
                break;
            }

            $response .= $line;
            if (strlen($line) >= 4 && $line[3] === ' ') {
                break;
            }
        }

        $code = (int)substr(trim($response), 0, 3);
        if (!in_array($code, $expectedCodes, true)) {
            throw new \RuntimeException('SMTP error' . ($command !== '' ? ' after ' . $command : '') . ': ' . trim($response));
        }

        return $response;
    }

    private static function httpPostJson(string $url, array $headers, array $payload): array {
        if (function_exists('curl_init')) {
            $handle = curl_init($url);
            curl_setopt_array($handle, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                CURLOPT_TIMEOUT => 20,
            ]);

            $body = curl_exec($handle);
            $status = (int)curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
            $error = curl_error($handle);
            curl_close($handle);

            if ($body === false) {
                throw new \RuntimeException('HTTP request failed: ' . $error);
            }

            return ['status' => $status, 'body' => (string)$body];
        }

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => implode("\r\n", $headers),
                'content' => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'timeout' => 20,
                'ignore_errors' => true,
            ],
        ]);

        $body = @file_get_contents($url, false, $context);
        $responseHeaders = $http_response_header ?? [];
        $status = 0;
        foreach ($responseHeaders as $header) {
            if (preg_match('#HTTP/\S+\s+(\d{3})#', $header, $matches)) {
                $status = (int)$matches[1];
                break;
            }
        }

        return ['status' => $status, 'body' => (string)$body];
    }

    private static function wrapHtmlTemplate(string $workspaceName, string $title, string $greeting, string $intro, string $cta, string $url, string $footer): string {
        $workspaceName = htmlspecialchars($workspaceName, ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $greeting = nl2br(htmlspecialchars($greeting, ENT_QUOTES, 'UTF-8'));
        $intro = nl2br(htmlspecialchars($intro, ENT_QUOTES, 'UTF-8'));
        $cta = htmlspecialchars($cta, ENT_QUOTES, 'UTF-8');
        $footer = nl2br(htmlspecialchars($footer, ENT_QUOTES, 'UTF-8'));
        $safeUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

        return '<!DOCTYPE html><html lang="en"><body style="margin:0;padding:32px;background:#f3f6fb;font-family:Segoe UI,Arial,sans-serif;color:#0f172a;">'
            . '<div style="max-width:640px;margin:0 auto;background:#ffffff;border:1px solid #d7e0ec;border-radius:20px;overflow:hidden;box-shadow:0 18px 40px rgba(15,23,42,0.08);">'
            . '<div style="padding:24px 28px;background:linear-gradient(135deg,#0ea5a8,#0b7f82);color:#ffffff;">'
            . '<div style="font-size:12px;letter-spacing:0.14em;text-transform:uppercase;opacity:0.8;">' . $workspaceName . '</div>'
            . '<h1 style="margin:10px 0 0;font-size:24px;line-height:1.2;">' . $title . '</h1>'
            . '</div>'
            . '<div style="padding:28px;">'
            . '<p style="margin:0 0 14px;font-size:16px;line-height:1.6;">' . $greeting . '</p>'
            . '<p style="margin:0 0 22px;font-size:15px;line-height:1.7;color:#475569;">' . $intro . '</p>'
            . '<p style="margin:0 0 22px;"><a href="' . $safeUrl . '" style="display:inline-block;padding:14px 20px;border-radius:14px;background:#0ea5a8;color:#ffffff;text-decoration:none;font-weight:700;">' . $cta . '</a></p>'
            . '<p style="margin:0 0 18px;font-size:13px;line-height:1.6;color:#64748b;word-break:break-all;">' . $safeUrl . '</p>'
            . '<p style="margin:0;font-size:13px;line-height:1.7;color:#64748b;">' . $footer . '</p>'
            . '</div></div></body></html>';
    }

    private static function passwordResetCopy(string $locale): array {
        $messages = [
            'it' => [
                'subject' => ':workspace - Reset password',
                'greeting' => 'Ciao :name,',
                'intro' => 'Abbiamo ricevuto una richiesta di reset della password per il tuo account. Se hai effettuato tu la richiesta, usa il pulsante qui sotto per impostare una nuova password. Il link resta valido per 60 minuti.',
                'cta' => 'Imposta nuova password',
                'footer' => 'Se non hai richiesto il reset, puoi ignorare questa email in sicurezza.',
                'user_fallback' => 'utente',
            ],
            'fr' => [
                'subject' => ':workspace - Reinitialisation mot de passe',
                'greeting' => 'Bonjour :name,',
                'intro' => 'Nous avons recu une demande de reinitialisation du mot de passe pour votre compte. Si vous etes a l origine de la demande, utilisez le bouton ci-dessous pour definir un nouveau mot de passe. Le lien est valide pendant 60 minutes.',
                'cta' => 'Definir un nouveau mot de passe',
                'footer' => 'Si vous n avez pas demande cette reinitialisation, vous pouvez ignorer cet email.',
                'user_fallback' => 'utilisateur',
            ],
            'es' => [
                'subject' => ':workspace - Restablecer contrasena',
                'greeting' => 'Hola :name,',
                'intro' => 'Hemos recibido una solicitud para restablecer la contrasena de tu cuenta. Si la solicitud es tuya, usa el boton inferior para definir una nueva contrasena. El enlace es valido durante 60 minutos.',
                'cta' => 'Definir nueva contrasena',
                'footer' => 'Si no solicitaste este cambio, puedes ignorar este email con seguridad.',
                'user_fallback' => 'usuario',
            ],
            'en' => [
                'subject' => ':workspace - Password reset',
                'greeting' => 'Hello :name,',
                'intro' => 'We received a password reset request for your account. If this was you, use the button below to set a new password. The link remains valid for 60 minutes.',
                'cta' => 'Set new password',
                'footer' => 'If you did not request this change, you can safely ignore this email.',
                'user_fallback' => 'user',
            ],
        ];

        return $messages[$locale] ?? $messages['en'];
    }

    private static function encodeHeader(string $value): string {
        return '=?UTF-8?B?' . base64_encode($value) . '?=';
    }

    private static function formatAddress(string $email, string $name = ''): string {
        $email = trim($email);
        $name = trim($name);
        if ($name === '') {
            return '<' . $email . '>';
        }

        return self::encodeHeader($name) . ' <' . $email . '>';
    }

    private static function escapeSmtpBody(string $body): string {
        $body = str_replace(["\r\n", "\r"], "\n", $body);
        $body = str_replace("\n.", "\n..", $body);
        return str_replace("\n", "\r\n", $body);
    }

    private static function toBool($value, bool $default = false): bool {
        if (is_bool($value)) {
            return $value;
        }

        $normalized = strtolower(trim((string)$value));
        if ($normalized === '') {
            return $default;
        }

        return in_array($normalized, ['1', 'true', 'yes', 'on'], true);
    }
}