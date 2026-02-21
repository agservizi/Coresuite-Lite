<?php
use Core\DB;
use Core\Auth;

// app/Controllers/DocumentController.php

class DocumentController {
    public function list($params = []) {
        $user = Auth::user();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        if (Auth::isCustomer()) {
            $countStmt = DB::prepare("SELECT COUNT(*) as total FROM documents WHERE customer_id = ?");
            $countStmt->execute([$user['id']]);
            $total = $countStmt->fetch()['total'];

            $stmt = DB::prepare("SELECT * FROM documents WHERE customer_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
            $stmt->execute([$user['id'], $perPage, $offset]);
        } else {
            // Admin e Operator vedono tutti i documenti
            $countStmt = DB::prepare("SELECT COUNT(*) as total FROM documents");
            $countStmt->execute();
            $total = $countStmt->fetch()['total'];

            $stmt = DB::prepare("SELECT d.*, u.name as customer_name FROM documents d JOIN users u ON d.customer_id = u.id ORDER BY d.created_at DESC LIMIT ? OFFSET ?");
            $stmt->execute([$perPage, $offset]);
        }
        $documents = $stmt->fetchAll();
        // Attach metadata if exists
        foreach ($documents as &$d) {
            $metaPath = __DIR__ . '/../../storage/uploads/' . ($d['filename_storage'] ?? '') . '.json';
            if (file_exists($metaPath)) {
                $json = file_get_contents($metaPath);
                $d['meta'] = json_decode($json, true);
            } else {
                $d['meta'] = null;
            }
        }
        $totalPages = max(1, ceil($total / $perPage));

        include __DIR__ . '/../Views/documents.php';
    }

    public function uploadForm($params = []) {
        $stmt = DB::prepare("SELECT id, name FROM users WHERE role = 'customer' ORDER BY name");
        $stmt->execute();
        $customers = $stmt->fetchAll();

        include __DIR__ . '/../Views/document_upload.php';
    }

    public function upload($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $error = 'Token di sicurezza non valido';
            $stmt = DB::prepare("SELECT id, name FROM users WHERE role = 'customer' ORDER BY name");
            $stmt->execute();
            $customers = $stmt->fetchAll();
            include __DIR__ . '/../Views/document_upload.php';
            return;
        }

        $customerId = $_POST['customer_id'] ?? '';
        $description = trim($_POST['description'] ?? '');
        $tags = trim($_POST['tags'] ?? '');
        $file = $_FILES['file'] ?? null;

        if (empty($customerId) || !$file || $file['error'] !== UPLOAD_ERR_OK) {
            $error = 'Cliente e file sono obbligatori';
            $stmt = DB::prepare("SELECT id, name FROM users WHERE role = 'customer' ORDER BY name");
            $stmt->execute();
            $customers = $stmt->fetchAll();
            include __DIR__ . '/../Views/document_upload.php';
            return;
        }

        // Controlli sicurezza - MIME type server-side con finfo
        $allowedTypes = [
            'application/pdf',
            'image/jpeg',
            'image/png',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
        $maxSize = 10 * 1024 * 1024; // 10MB

        // Verifica MIME lato server con finfo
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $detectedMime = $finfo->file($file['tmp_name']);

        // Verifica estensione
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($detectedMime, $allowedTypes) || !in_array($extension, $allowedExtensions) || $file['size'] > $maxSize) {
            $error = 'Tipo file non supportato o troppo grande (max 10MB). Formati: PDF, JPG, PNG, DOC, DOCX';
            $stmt = DB::prepare("SELECT id, name FROM users WHERE role = 'customer' ORDER BY name");
            $stmt->execute();
            $customers = $stmt->fetchAll();
            include __DIR__ . '/../Views/document_upload.php';
            return;
        }

        // Rinomina file sicuro con random_bytes
        $filenameStorage = bin2hex(random_bytes(16)) . '.' . $extension;
        $uploadPath = __DIR__ . '/../../storage/uploads/' . $filenameStorage;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $user = Auth::user();
            $stmt = DB::prepare("INSERT INTO documents (customer_id, filename_original, filename_storage, mime, size, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$customerId, $file['name'], $filenameStorage, $detectedMime, $file['size'], $user['id']]);
            $docId = DB::lastInsertId();
            Auth::logAction('upload', 'document', $docId);

            // Save metadata JSON alongside the file for advanced document management
            try {
                $meta = [
                    'doc_id' => $docId,
                    'original_name' => $file['name'],
                    'uploaded_by' => $user['id'],
                    'uploaded_at' => date('c'),
                    'description' => $description,
                    'tags' => array_values(array_filter(array_map('trim', explode(',', $tags))))
                ];
                $metaPath = __DIR__ . '/../../storage/uploads/' . $filenameStorage . '.json';
                file_put_contents($metaPath, json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            } catch (\Throwable $e) {
                // ignore metadata write errors
            }
            Auth::flash('Documento caricato con successo.', 'success');
            header('Location: /documents');
            exit;
        } else {
            $error = 'Errore nel caricamento del file';
            $stmt = DB::prepare("SELECT id, name FROM users WHERE role = 'customer' ORDER BY name");
            $stmt->execute();
            $customers = $stmt->fetchAll();
            include __DIR__ . '/../Views/document_upload.php';
            return;
        }
    }

    public function download($params = []) {
        $id = (int)$params['id'];
        $stmt = DB::prepare("SELECT * FROM documents WHERE id = ?");
        $stmt->execute([$id]);
        $doc = $stmt->fetch();

        if (!$doc) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }

        $user = Auth::user();
        if (Auth::isCustomer() && $doc['customer_id'] != $user['id']) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            return;
        }

        $filePath = __DIR__ . '/../../storage/uploads/' . $doc['filename_storage'];
        if (file_exists($filePath)) {
            // Sanitize filename per header — rimuovi caratteri pericolosi
            $safeName = preg_replace('/[^a-zA-Z0-9._\-]/', '_', $doc['filename_original']);
            header('Content-Type: ' . $doc['mime']);
            header('Content-Disposition: attachment; filename="' . $safeName . '"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        } else {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }
    }

    public function delete($params = []) {
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            Auth::flash('Token di sicurezza non valido.', 'danger');
            header('Location: /documents');
            exit;
        }

        $id = (int)$params['id'];
        $stmt = DB::prepare("SELECT * FROM documents WHERE id = ?");
        $stmt->execute([$id]);
        $doc = $stmt->fetch();

        if ($doc) {
            $filePath = __DIR__ . '/../../storage/uploads/' . $doc['filename_storage'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $stmt = DB::prepare("DELETE FROM documents WHERE id = ?");
            $stmt->execute([$id]);
            Auth::logAction('delete', 'document', $id);
            Auth::flash('Documento eliminato.', 'success');
        }

        header('Location: /documents');
        exit;
    }
}