<?php
require_once __DIR__ . '/../Helpers/validation.php';
use Core\Auth;
use Core\DB;
use Core\Locale;

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

        // Recupera ultime 20 voci audit relative all'utente (come attore o entità)
        try {
            $stmt = DB::prepare("SELECT * FROM audit_logs WHERE actor_id = ? OR (entity = 'user' AND entity_id = ?) ORDER BY created_at DESC LIMIT 20");
            $stmt->execute([$user['id'], $user['id']]);
            $activity = $stmt->fetchAll();
        } catch (\Throwable $e) {
            $activity = [];
        }

        include __DIR__ . '/../Views/profile.php';
    }

    public function update($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            echo Locale::runtime('csrf_invalid_plain');
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
            Auth::flash(Locale::runtime('email_in_use'), 'danger');
            header('Location: /profile');
            exit;
        }

        // Password change (optional)
        $passwordHash = null;
        if (!empty($newPassword)) {
            if (!password_verify($currentPassword, $user['password_hash'])) {
                Auth::flash(Locale::runtime('current_password_incorrect'), 'danger');
                header('Location: /profile');
                exit;
            }
            if (strlen($newPassword) < 6) {
                Auth::flash(Locale::runtime('new_password_min_6'), 'danger');
                header('Location: /profile');
                exit;
            }
            if ($newPassword !== $confirmPassword) {
                Auth::flash(Locale::runtime('password_confirmation_mismatch'), 'danger');
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
        Auth::flash(Locale::runtime('profile_updated'), 'success');
        header('Location: /profile');
        exit;
    }
}
