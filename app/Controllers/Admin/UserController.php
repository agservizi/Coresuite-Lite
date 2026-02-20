<?php
use Core\DB;

// app/Controllers/Admin/UserController.php

class Admin_UserController {
    public function list($params = []) {
        $stmt = DB::prepare("SELECT id, name, email, role, status, created_at FROM users ORDER BY created_at DESC");
        $stmt->execute();
        $users = $stmt->fetchAll();

        include __DIR__ . '/../../Views/admin/users.php';
    }

    public function create($params = []) {
        include __DIR__ . '/../../Views/admin/user_form.php';
    }

    public function store($params = []) {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'customer';
        $status = $_POST['status'] ?? 'active';

        if (empty($name) || empty($email) || empty($password)) {
            $error = 'Tutti i campi sono obbligatori';
            include __DIR__ . '/../../Views/admin/user_form.php';
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = DB::prepare("INSERT INTO users (name, email, password_hash, role, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $passwordHash, $role, $status]);

        header('Location: /admin/users');
        exit;
    }

    public function edit($params = []) {
        $id = $params['id'];
        $stmt = DB::prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        if (!$user) {
            http_response_code(404);
            include __DIR__ . '/../../Views/errors/404.php';
            return;
        }

        include __DIR__ . '/../../Views/admin/user_form.php';
    }

    public function update($params = []) {
        $id = $params['id'];
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? 'customer';
        $status = $_POST['status'] ?? 'active';

        if (empty($name) || empty($email)) {
            $error = 'Nome e email sono obbligatori';
            // Ricarica form
            $stmt = DB::prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            include __DIR__ . '/../../Views/admin/user_form.php';
            return;
        }

        $stmt = DB::prepare("UPDATE users SET name = ?, email = ?, role = ?, status = ? WHERE id = ?");
        $stmt->execute([$name, $email, $role, $status, $id]);

        header('Location: /admin/users');
        exit;
    }

    public function delete($params = []) {
        $id = $params['id'];
        $stmt = DB::prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        header('Location: /admin/users');
        exit;
    }
}