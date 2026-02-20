<?php
require_once __DIR__ . '/../Helpers/validation.php';
use Core\Auth;
use Core\DB;

// app/Controllers/ProfileController.php

class ProfileController {
    public function index($params = []) {
        $user = Auth::user();
        if (!$user) {
            header('Location: /login');
            exit;
        }

        $pageTitle = 'Il mio profilo';
        $success = null;
        $error = null;
        if (isset($_SESSION['flash_message'])) {
            if ($_SESSION['flash_type'] === 'success') {
                $success = $_SESSION['flash_message'];
            } else {
                $error = $_SESSION['flash_message'];
            }
            unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        }

        include __DIR__ . '/../Views/profile.php';
    }

    public function update($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            echo 'Token CSRF non valido';
            return;
        }

        $user = Auth::user();
        if (!$user) {
            header('Location: /login');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validation
        $validator = new Validation();
        $rules = [
            'name' => 'required|min:2',
            'email' => 'required|email',
        ];
        if (!$validator->validate($_POST, $rules)) {
            $errors = $validator->getErrors();
            Auth::flash(implode(', ', $errors), 'danger');
            header('Location: /profile');
            exit;
        }

        // Check email uniqueness (excluding self)
        $stmt = DB::prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $user['id']]);
        if ($stmt->fetch()) {
            Auth::flash('Email già in uso da un altro utente', 'danger');
            header('Location: /profile');
            exit;
        }

        // Password change (optional)
        $passwordHash = null;
        if (!empty($newPassword)) {
            if (!password_verify($currentPassword, $user['password_hash'])) {
                Auth::flash('La password attuale non è corretta', 'danger');
                header('Location: /profile');
                exit;
            }
            if (strlen($newPassword) < 6) {
                Auth::flash('La nuova password deve essere almeno 6 caratteri', 'danger');
                header('Location: /profile');
                exit;
            }
            if ($newPassword !== $confirmPassword) {
                Auth::flash('Le password non coincidono', 'danger');
                header('Location: /profile');
                exit;
            }
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Update
        if ($passwordHash) {
            $stmt = DB::prepare("UPDATE users SET name = ?, email = ?, phone = ?, password_hash = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$name, $email, $phone, $passwordHash, $user['id']]);
        } else {
            $stmt = DB::prepare("UPDATE users SET name = ?, email = ?, phone = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$name, $email, $phone, $user['id']]);
        }

        Auth::logAction('profile_update', 'user', $user['id']);
        Auth::flash('Profilo aggiornato con successo', 'success');
        header('Location: /profile');
        exit;
    }
}
