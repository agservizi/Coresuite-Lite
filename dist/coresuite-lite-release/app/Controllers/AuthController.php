<?php
use Core\Auth;
use Core\DB;
use Core\Locale;

// app/Controllers/AuthController.php

class AuthController {
    public function login($params = []) {
        $dbAvailable = true;
        try {
            DB::init();
        } catch (\Throwable $e) {
            $dbAvailable = false;
            if (\Core\Config::isInstallEnabled()) {
                header('Location: /install');
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$dbAvailable) {
                $error = Locale::runtime('db_unavailable_verify_env');
                include __DIR__ . '/../Views/login.php';
                return;
            }

            // Verifica CSRF
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                $error = Locale::runtime('csrf_invalid');
            } else {
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $remember = isset($_POST['remember']);

                try {
                    if (Auth::login($email, $password, $remember)) {
                        header('Location: /dashboard');
                        exit;
                    } else {
                        $error = Locale::runtime('invalid_credentials');
                    }
                } catch (\Throwable $e) {
                    if (\Core\Config::isInstallEnabled()) {
                        header('Location: /install');
                        exit;
                    }
                    $error = Locale::runtime('db_unavailable_configure_env');
                }
            }
        }

        include __DIR__ . '/../Views/login.php';
    }

    public function logout($params = []) {
        Auth::logout();
        header('Location: /login');
        exit;
    }

    public function resetPassword($params = []) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                $error = Locale::runtime('csrf_invalid');
                include __DIR__ . '/../Views/reset_password.php';
                return;
            }

            $email = trim($_POST['email'] ?? '');

            // Cerca l'utente
            $stmt = DB::prepare("SELECT id FROM users WHERE email = ? AND status = 'active'");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                // Rimuovi token precedenti per questo utente
                $stmt = DB::prepare("DELETE FROM password_resets WHERE user_id = ?");
                $stmt->execute([$user['id']]);

                // Genera token
                $token = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $token);
                $expires = date('Y-m-d H:i:s', time() + 3600); // 1 ora

                $stmt = DB::prepare("INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (?, ?, ?)");
                $stmt->execute([$user['id'], $tokenHash, $expires]);

                // In produzione qui si invierebbe l'email con il link
                // Per ora, logga il link per test
                $resetLink = rtrim(\Core\Mail::appUrl(), '/') . '/reset-password/' . $token;
                Auth::logAction('password_reset_request', 'user', $user['id']);

                $mailSent = \Core\Mail::sendPasswordReset($email, $resetLink);
                if (!$mailSent) {
                    \Core\Logger::warning('password_reset_mail_not_sent', ['user_id' => $user['id'], 'email' => $email]);
                }
            }

            // Messaggio generico per evitare enumerazione utenti
            $message = Locale::runtime('reset_email_sent');
        }

        include __DIR__ . '/../Views/reset_password.php';
    }

    public function resetPasswordForm($params = []) {
        $token = $params['token'] ?? '';

        if (empty($token)) {
            header('Location: /login');
            exit;
        }

        // Verifica che il token sia valido
        $tokenHash = hash('sha256', $token);
        $stmt = DB::prepare("SELECT pr.*, u.email FROM password_resets pr JOIN users u ON pr.user_id = u.id WHERE pr.token_hash = ? AND pr.expires_at > NOW() AND pr.used_at IS NULL");
        $stmt->execute([$tokenHash]);
        $resetRecord = $stmt->fetch();

        if (!$resetRecord) {
            $error = Locale::runtime('reset_link_invalid');
            include __DIR__ . '/../Views/reset_password_form.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                $error = Locale::runtime('csrf_invalid');
                include __DIR__ . '/../Views/reset_password_form.php';
                return;
            }

            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            if ($password !== $confirm) {
                $error = Locale::runtime('passwords_mismatch');
                include __DIR__ . '/../Views/reset_password_form.php';
                return;
            }

            if (strlen($password) < 8) {
                $error = Locale::runtime('password_min_8');
                include __DIR__ . '/../Views/reset_password_form.php';
                return;
            }

            // Aggiorna password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = DB::prepare("UPDATE users SET password_hash = ? WHERE id = ?");
            $stmt->execute([$passwordHash, $resetRecord['user_id']]);

            // Segna token come usato
            $stmt = DB::prepare("UPDATE password_resets SET used_at = NOW() WHERE id = ?");
            $stmt->execute([$resetRecord['id']]);

            Auth::logAction('password_reset', 'user', $resetRecord['user_id']);

            $message = Locale::runtime('password_updated');
        }

        include __DIR__ . '/../Views/reset_password_form.php';
    }
}
