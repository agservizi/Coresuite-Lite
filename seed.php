<?php
use Core\DB;
use Core\Config;

// seed.php - Crea dati demo

require_once __DIR__ . '/app/Core/Config.php';
require_once __DIR__ . '/app/Core/DB.php';
require_once __DIR__ . '/app/Core/Auth.php';

Config::load();
DB::init();

// Crea admin
$adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = DB::prepare("INSERT INTO users (name, email, password_hash, role, status) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE id=id");
$stmt->execute(['Admin User', 'admin@example.com', $adminPassword, 'admin', 'active']);

// Crea operatore
$operatorPassword = password_hash('operator123', PASSWORD_DEFAULT);
$stmt->execute(['Operator User', 'operator@example.com', $operatorPassword, 'operator', 'active']);

// Crea cliente demo
$customerPassword = password_hash('customer123', PASSWORD_DEFAULT);
$stmt->execute(['Demo Customer', 'customer@example.com', $customerPassword, 'customer', 'active']);

echo "Seed completato. Utenti demo creati:\n";
echo "Admin: admin@example.com / admin123\n";
echo "Operator: operator@example.com / operator123\n";
echo "Customer: customer@example.com / customer123\n";