<?php
use Core\DB;
use Core\Auth;

// app/Controllers/Admin/UserController.php

class Admin_UserController {
    public function list($params = []) {
        $search = trim($_GET['q'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        if ($search !== '') {
            $like = '%' . $search . '%';
            $countStmt = DB::prepare("SELECT COUNT(*) as total FROM users WHERE name LIKE ? OR email LIKE ?");
            $countStmt->execute([$like, $like]);
            $total = $countStmt->fetch()['total'];

            $stmt = DB::prepare("SELECT id, name, email, phone, role, status, created_at FROM users WHERE name LIKE ? OR email LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
            $stmt->execute([$like, $like, $perPage, $offset]);
        } else {
            $countStmt = DB::prepare("SELECT COUNT(*) as total FROM users");
            $countStmt->execute();
            $total = $countStmt->fetch()['total'];

            $stmt = DB::prepare("SELECT id, name, email, phone, role, status, created_at FROM users ORDER BY created_at DESC LIMIT ? OFFSET ?");
            $stmt->execute([$perPage, $offset]);
        }
        $users = $stmt->fetchAll();
        $totalPages = max(1, ceil($total / $perPage));

        include __DIR__ . '/../../Views/admin/users.php';
    }

    public function create($params = []) {
        include __DIR__ . '/../../Views/admin/user_form.php';
    }

    public function store($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $error = 'Token di sicurezza non valido';
            include __DIR__ . '/../../Views/admin/user_form.php';
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'customer';
        $status = $_POST['status'] ?? 'active';

        // Validazione
        $validation = new Validation();
        if (!$validation->validate([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ])) {
            $error = implode(', ', $validation->getErrors());
            include __DIR__ . '/../../Views/admin/user_form.php';
            return;
        }

        // Valida ruolo e status
        if (!in_array($role, ['admin', 'operator', 'customer'])) $role = 'customer';
        if (!in_array($status, ['active', 'suspended'])) $status = 'active';

        // Controlla email duplicata
        $checkStmt = DB::prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->execute([$email]);
        if ($checkStmt->fetch()) {
            $error = 'Un utente con questa email esiste già';
            include __DIR__ . '/../../Views/admin/user_form.php';
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = DB::prepare("INSERT INTO users (name, email, password_hash, phone, role, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $passwordHash, $phone ?: null, $role, $status]);

        $userId = DB::lastInsertId();
        Auth::logAction('create', 'user', $userId);
        Auth::flash('Utente creato con successo.', 'success');
        header('Location: /admin/users');
        exit;
    }

    public function edit($params = []) {
        $id = (int)$params['id'];
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
        $id = (int)$params['id'];

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $error = 'Token di sicurezza non valido';
            $stmt = DB::prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            include __DIR__ . '/../../Views/admin/user_form.php';
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'customer';
        $status = $_POST['status'] ?? 'active';
        $password = $_POST['password'] ?? '';

        // Validazione
        $validation = new Validation();
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
        ];
        if (!empty($password)) {
            $rules['password'] = 'min:6';
        }
        $data = ['name' => $name, 'email' => $email, 'password' => $password];
        if (!$validation->validate($data, $rules)) {
            $error = implode(', ', $validation->getErrors());
            $stmt = DB::prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            include __DIR__ . '/../../Views/admin/user_form.php';
            return;
        }

        // Valida ruolo e status
        if (!in_array($role, ['admin', 'operator', 'customer'])) $role = 'customer';
        if (!in_array($status, ['active', 'suspended'])) $status = 'active';

        // Controlla email duplicata (escludendo utente corrente)
        $checkStmt = DB::prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $checkStmt->execute([$email, $id]);
        if ($checkStmt->fetch()) {
            $error = 'Un altro utente con questa email esiste già';
            $stmt = DB::prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            include __DIR__ . '/../../Views/admin/user_form.php';
            return;
        }

        // Aggiorna con o senza password
        if (!empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = DB::prepare("UPDATE users SET name = ?, email = ?, phone = ?, password_hash = ?, role = ?, status = ? WHERE id = ?");
            $stmt->execute([$name, $email, $phone ?: null, $passwordHash, $role, $status, $id]);
        } else {
            $stmt = DB::prepare("UPDATE users SET name = ?, email = ?, phone = ?, role = ?, status = ? WHERE id = ?");
            $stmt->execute([$name, $email, $phone ?: null, $role, $status, $id]);
        }

        Auth::logAction('update', 'user', $id);
        Auth::flash('Utente aggiornato con successo.', 'success');
        header('Location: /admin/users');
        exit;
    }

    public function delete($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash('Token di sicurezza non valido.', 'danger');
            header('Location: /admin/users');
            exit;
        }

        $id = (int)$params['id'];

        // Non permettere di eliminare se stessi
        $currentUser = Auth::user();
        if ($currentUser && $currentUser['id'] == $id) {
            Auth::flash('Non puoi eliminare il tuo stesso account.', 'danger');
            header('Location: /admin/users');
            exit;
        }

        $stmt = DB::prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        Auth::logAction('delete', 'user', $id);
        Auth::flash('Utente eliminato.', 'success');
        header('Location: /admin/users');
        exit;
    }
}