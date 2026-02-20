<?php
use Core\Auth;
use Core\DB;

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
                $error = 'Database non disponibile. Verifica credenziali DB in .env e che il database esista.';
                include __DIR__ . '/../Views/login.php';
                return;
            }

            // Verifica CSRF
            if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
                $error = 'Token di sicurezza non valido';
            } else {
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                $remember = isset($_POST['remember']);

                try {
                    if (Auth::login($email, $password, $remember)) {
                        header('Location: /dashboard');
                        exit;
                    } else {
                        $error = 'Credenziali non valide';
                    }
                } catch (\Throwable $e) {
                    if (\Core\Config::isInstallEnabled()) {
                        header('Location: /install');
                        exit;
                    }
                    $error = 'Database non disponibile. Configura il file .env per lo sviluppo.';
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
            $email = $_POST['email'] ?? '';
            // Implementa invio email con token
            // Per ora, solo placeholder
            $message = 'Se l\'email esiste, riceverai un link per il reset.';
        }

        include __DIR__ . '/../Views/reset_password.php';
    }

    public function resetPasswordForm($params = []) {
        $token = $params['token'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            if ($password === $confirm && strlen($password) >= 8) {
                // Verifica token e aggiorna password
                // Placeholder
                $message = 'Password aggiornata con successo.';
            } else {
                $error = 'Password non valida o non corrispondente.';
            }
        }

        include __DIR__ . '/../Views/reset_password_form.php';
    }
}