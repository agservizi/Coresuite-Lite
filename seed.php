<?php
use Core\DB;
use Core\Config;

// seed.php - Crea dati demo

require_once __DIR__ . '/app/Core/Config.php';
require_once __DIR__ . '/app/Core/DB.php';
require_once __DIR__ . '/app/Core/Auth.php';

Config::load();
DB::init();

$requiredTables = [
    'projects',
    'project_milestones',
    'project_tasks',
];

foreach ($requiredTables as $tableName) {
    $stmt = DB::prepare('SHOW TABLES LIKE ?');
    $stmt->execute([$tableName]);
    if (!$stmt->fetchColumn()) {
        echo "Missing required table: {$tableName}\n";
        echo "Import schema.sql before running seed.php.\n";
        exit(1);
    }
}

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

$usersStmt = DB::query("SELECT id, email FROM users WHERE email IN ('admin@example.com', 'operator@example.com', 'customer@example.com')");
$userMap = [];
foreach ($usersStmt->fetchAll() as $user) {
    $userMap[$user['email']] = (int)$user['id'];
}

$projectStmt = DB::prepare("
    INSERT INTO projects (customer_id, owner_id, name, code, status, priority, health, progress, budget, start_date, due_date, description, tags)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
        status = VALUES(status),
        priority = VALUES(priority),
        health = VALUES(health),
        progress = VALUES(progress),
        budget = VALUES(budget),
        start_date = VALUES(start_date),
        due_date = VALUES(due_date),
        description = VALUES(description),
        tags = VALUES(tags)
");

$customerId = $userMap['customer@example.com'] ?? null;
$adminId = $userMap['admin@example.com'] ?? null;
$operatorId = $userMap['operator@example.com'] ?? null;

$demoProjects = [
    [$customerId, $adminId, 'Workspace Migration Retail', 'PRJ-2401', 'active', 'high', 'on_track', 68, 24000, '2026-03-01', '2026-04-15', 'Migrazione del workspace cliente con focus su documenti, permessi e adoption operativa.', 'migration, retail, workspace'],
    [$customerId, $operatorId, 'Customer Portal Refresh', 'PRJ-2402', 'review', 'medium', 'watch', 84, 12000, '2026-02-20', '2026-03-28', 'Rifinitura customer-facing con allineamento UX, contenuti e flussi di supporto.', 'portal, ux, customer'],
    [$customerId, $adminId, 'Compliance Archive Rollout', 'PRJ-2403', 'planning', 'high', 'at_risk', 22, 18000, '2026-03-18', '2026-05-05', 'Setup archivio documentale con policy, tassonomie e controllo accessi per audit.', 'archive, compliance, audit'],
];

foreach ($demoProjects as $projectRow) {
    $projectStmt->execute($projectRow);
}

$projectsStmt = DB::query("SELECT id, code FROM projects WHERE code IN ('PRJ-2401', 'PRJ-2402', 'PRJ-2403')");
$projectMap = [];
foreach ($projectsStmt->fetchAll() as $project) {
    $projectMap[$project['code']] = (int)$project['id'];
}

$milestoneStmt = DB::prepare("
    INSERT INTO project_milestones (project_id, title, status, due_date, sort_order)
    VALUES (?, ?, ?, ?, ?)
");

$milestoneRows = [
    ['PRJ-2401', 'Scoperta e mapping processi', 'done', '2026-03-08', 1],
    ['PRJ-2401', 'Migrazione documentale', 'active', '2026-03-24', 2],
    ['PRJ-2401', 'Go-live assistito', 'planned', '2026-04-12', 3],
    ['PRJ-2402', 'UI polish e handoff', 'active', '2026-03-22', 1],
    ['PRJ-2402', 'QA customer journey', 'planned', '2026-03-26', 2],
    ['PRJ-2403', 'Definizione tassonomie', 'planned', '2026-03-29', 1],
    ['PRJ-2403', 'Policy accessi e audit', 'planned', '2026-04-08', 2],
];

DB::query("DELETE FROM project_tasks WHERE project_id IN (" . implode(',', array_map('intval', array_values($projectMap ?: [0]))) . ")");
DB::query("DELETE FROM project_milestones WHERE project_id IN (" . implode(',', array_map('intval', array_values($projectMap ?: [0]))) . ")");

$milestoneMap = [];
foreach ($milestoneRows as $row) {
    if (empty($projectMap[$row[0]])) {
        continue;
    }
    $milestoneStmt->execute([$projectMap[$row[0]], $row[1], $row[2], $row[3], $row[4]]);
    $milestoneMap[$row[0]][$row[1]] = (int)DB::lastInsertId();
}

$taskStmt = DB::prepare("
    INSERT INTO project_tasks (project_id, milestone_id, title, status, priority, assignee_id, due_date, sort_order)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$taskRows = [
    ['PRJ-2401', 'Scoperta e mapping processi', 'Pulire naming storico documenti', 'done', 'medium', $adminId, '2026-03-06', 1],
    ['PRJ-2401', 'Migrazione documentale', 'Validare permessi per area finance', 'doing', 'high', $operatorId ?: $adminId, '2026-03-21', 2],
    ['PRJ-2401', 'Go-live assistito', 'Preparare checklist onboarding operatori', 'todo', 'medium', $adminId, '2026-04-10', 3],
    ['PRJ-2402', 'UI polish e handoff', 'Aggiornare componenti auth', 'doing', 'high', $operatorId ?: $adminId, '2026-03-20', 1],
    ['PRJ-2402', 'QA customer journey', 'Eseguire regressione su search e inbox', 'todo', 'medium', $adminId, '2026-03-25', 2],
    ['PRJ-2403', 'Definizione tassonomie', 'Confermare categorie compliance', 'todo', 'high', $adminId, '2026-03-27', 1],
    ['PRJ-2403', 'Policy accessi e audit', 'Mappare ruoli e retention log', 'todo', 'high', $operatorId ?: $adminId, '2026-04-03', 2],
];

foreach ($taskRows as $row) {
    if (empty($projectMap[$row[0]])) {
        continue;
    }
    $taskStmt->execute([
        $projectMap[$row[0]],
        $milestoneMap[$row[0]][$row[1]] ?? null,
        $row[2],
        $row[3],
        $row[4],
        $row[5],
        $row[6],
        $row[7],
    ]);
}

echo "Seed completato. Utenti demo creati:\n";
echo "Admin: admin@example.com / admin123\n";
echo "Operator: operator@example.com / operator123\n";
echo "Customer: customer@example.com / customer123\n";
echo "Projects demo: PRJ-2401, PRJ-2402, PRJ-2403\n";
echo "Milestones demo: 7\n";
echo "Tasks demo: 7\n";
