<?php
// migrations/migrate_metadata.php
// Esegue la migrazione dei metadata JSON su tabelle DB create dalla migration SQL.

require_once __DIR__ . '/../app/Core/Config.php';
require_once __DIR__ . '/../app/Core/DB.php';

use Core\DB;

echo "Inizio migrazione metadata...\n";

try {
    DB::init();
} catch (\Throwable $e) {
    echo "Errore connessione DB: " . $e->getMessage() . "\n";
    exit(1);
}

// Applica lo SQL di migrazione
$sqlFile = __DIR__ . '/20260221_add_metadata_tables.sql';
if (!file_exists($sqlFile)) {
    echo "File SQL di migrazione non trovato: $sqlFile\n";
    exit(1);
}
$sql = file_get_contents($sqlFile);
try {
    DB::getPDO()->exec($sql);
    echo "Tabelle create/aggiornate con successo.\n";
} catch (\Throwable $e) {
    echo "Errore esecuzione SQL: " . $e->getMessage() . "\n";
    exit(1);
}

// Migra document metadata da storage/uploads/*.json
$uploadsMetaDir = __DIR__ . '/../storage/uploads';
$migratedDocs = 0;
if (is_dir($uploadsMetaDir)) {
    $files = glob($uploadsMetaDir . '/*.json');
    foreach ($files as $f) {
        $basename = basename($f);
        // stored filename is basename without .json
        $storedName = substr($basename, 0, -5);
        $json = @file_get_contents($f);
        if (!$json) continue;
        $meta = json_decode($json, true);
        if (!$meta) continue;

        // Find document by filename_storage
        $stmt = DB::prepare('SELECT id FROM documents WHERE filename_storage = ?');
        $stmt->execute([$storedName]);
        $doc = $stmt->fetch();
        if (!$doc) continue;
        $docId = $doc['id'];

        // Skip if already migrated
        $chk = DB::prepare('SELECT id FROM document_metadata WHERE document_id = ?');
        $chk->execute([$docId]);
        if ($chk->fetch()) continue;

        $description = $meta['description'] ?? null;
        $tags = isset($meta['tags']) ? json_encode($meta['tags'], JSON_UNESCAPED_UNICODE) : null;
        $uploadedBy = $meta['uploaded_by'] ?? null;
        $uploadedAt = isset($meta['uploaded_at']) ? date('Y-m-d H:i:s', strtotime($meta['uploaded_at'])) : null;

        $ins = DB::prepare('INSERT INTO document_metadata (document_id, description, tags, uploaded_by, uploaded_at) VALUES (?, ?, ?, ?, ?)');
        $ins->execute([$docId, $description, $tags, $uploadedBy, $uploadedAt]);
        $migratedDocs++;
    }
}
echo "Documenti migrati: $migratedDocs\n";

// Migra ticket attachments da storage/tickets/meta/*.json
$ticketsMetaDir = __DIR__ . '/../storage/tickets/meta';
$migratedAtt = 0;
if (is_dir($ticketsMetaDir)) {
    $files = glob($ticketsMetaDir . '/*.json');
    foreach ($files as $f) {
        $json = @file_get_contents($f);
        if (!$json) continue;
        $meta = json_decode($json, true);
        if (!$meta || empty($meta['ticket_id']) || empty($meta['stored_name'])) continue;

        $ticketId = (int)$meta['ticket_id'];
        $stored = $meta['stored_name'];
        $original = $meta['original_name'] ?? $stored;
        $uploadedBy = $meta['uploaded_by'] ?? null;
        $uploadedAt = isset($meta['uploaded_at']) ? date('Y-m-d H:i:s', strtotime($meta['uploaded_at'])) : null;

        // Skip if already exists
        $chk = DB::prepare('SELECT id FROM ticket_attachments WHERE ticket_id = ? AND stored_name = ?');
        $chk->execute([$ticketId, $stored]);
        if ($chk->fetch()) continue;

        $ins = DB::prepare('INSERT INTO ticket_attachments (ticket_id, original_name, stored_name, uploaded_by, uploaded_at) VALUES (?, ?, ?, ?, ?)');
        $ins->execute([$ticketId, $original, $stored, $uploadedBy, $uploadedAt]);
        $migratedAtt++;
    }
}
echo "Allegati ticket migrati: $migratedAtt\n";

echo "Migrazione completata.\n";
