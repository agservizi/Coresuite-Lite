<?php
use Core\DB;
use Core\Config;

// app/Controllers/InstallController.php

class InstallController {
    public function index($params = []) {
        if (!Config::isInstallEnabled()) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }

        if (Config::isConfigured()) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->setup();
        }

        include __DIR__ . '/../Views/install.php';
    }

    private function setup() {
        $dbHost = $_POST['db_host'] ?? '';
        $dbName = $_POST['db_name'] ?? '';
        $dbUser = $_POST['db_user'] ?? '';
        $dbPass = $_POST['db_pass'] ?? '';
        $adminName = $_POST['admin_name'] ?? '';
        $adminEmail = $_POST['admin_email'] ?? '';
        $adminPass = $_POST['admin_pass'] ?? '';

        // Salva .env
        $envContent = "DB_HOST=$dbHost\nDB_NAME=$dbName\nDB_USER=$dbUser\nDB_PASS=$dbPass\n";
        file_put_contents(__DIR__ . '/../../.env', $envContent);

        // Ricarica config
        Config::load();
        DB::init();

        // Crea tabelle
        $this->createTables();

        // Crea admin
        $adminPasswordHash = password_hash($adminPass, PASSWORD_DEFAULT);
        $stmt = DB::prepare("INSERT INTO users (name, email, password_hash, role, status) VALUES (?, ?, ?, 'admin', 'active')");
        $stmt->execute([$adminName, $adminEmail, $adminPasswordHash]);

        header('Location: /login');
        exit;
    }

    private function createTables() {
        // Esegui schema.sql
        $schema = file_get_contents(__DIR__ . '/../../schema.sql');
        DB::getPDO()->exec($schema);
    }
}