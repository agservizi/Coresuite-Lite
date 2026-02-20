<?php
use Core\DB;
use Core\Auth;

// app/Controllers/DocumentController.php

class DocumentController {
    public function list($params = []) {
        $user = Auth::user();
        if (Auth::isCustomer()) {
            $stmt = DB::prepare("SELECT * FROM documents WHERE customer_id = ? ORDER BY created_at DESC");
            $stmt->execute([$user['id']]);
        } elseif (Auth::isAdmin()) {
            $stmt = DB::prepare("SELECT d.*, u.name as customer_name FROM documents d JOIN users u ON d.customer_id = u.id ORDER BY d.created_at DESC");
            $stmt->execute();
        }
        $documents = $stmt->fetchAll();

        include __DIR__ . '/../Views/documents.php';
    }

    public function uploadForm($params = []) {
        $stmt = DB::prepare("SELECT id, name FROM users WHERE role = 'customer' ORDER BY name");
        $stmt->execute();
        $customers = $stmt->fetchAll();

        include __DIR__ . '/../Views/document_upload.php';
    }

    public function upload($params = []) {
        $customerId = $_POST['customer_id'] ?? '';
        $file = $_FILES['file'] ?? null;

        if (empty($customerId) || !$file || $file['error'] !== UPLOAD_ERR_OK) {
            $error = 'Cliente e file sono obbligatori';
            $stmt = DB::prepare("SELECT id, name FROM users WHERE role = 'customer' ORDER BY name");
            $stmt->execute();
            $customers = $stmt->fetchAll();
            include __DIR__ . '/../Views/document_upload.php';
            return;
        }

        // Controlli sicurezza
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $maxSize = 10 * 1024 * 1024; // 10MB

        if (!in_array($file['type'], $allowedTypes) || $file['size'] > $maxSize) {
            $error = 'Tipo file non supportato o troppo grande';
            $stmt = Core\DB::prepare("SELECT id, name FROM users WHERE role = 'customer' ORDER BY name");
            $stmt->execute();
            $customers = $stmt->fetchAll();
            include __DIR__ . '/../Views/document_upload.php';
            return;
        }

        // Rinomina file sicuro
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filenameStorage = uniqid() . '.' . $extension;
        $uploadPath = __DIR__ . '/../../storage/uploads/' . $filenameStorage;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $user = Auth::user();
            $stmt = DB::prepare("INSERT INTO documents (customer_id, filename_original, filename_storage, mime, size, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$customerId, $file['name'], $filenameStorage, $file['type'], $file['size'], $user['id']]);

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
        $id = $params['id'];
        $stmt = DB::prepare("SELECT * FROM documents WHERE id = ?");
        $stmt->execute([$id]);
        $doc = $stmt->fetch();

        if (!$doc) {
            http_response_code(404);
            exit;
        }

        $user = Auth::user();
        if (Auth::isCustomer() && $doc['customer_id'] != $user['id']) {
            http_response_code(403);
            exit;
        }

        $filePath = __DIR__ . '/../../storage/uploads/' . $doc['filename_storage'];
        if (file_exists($filePath)) {
            header('Content-Type: ' . $doc['mime']);
            header('Content-Disposition: attachment; filename="' . $doc['filename_original'] . '"');
            header('Content-Length: ' . $doc['size']);
            readfile($filePath);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    public function delete($params = []) {
        $id = $params['id'];
        $stmt = DB::prepare("SELECT * FROM documents WHERE id = ?");
        $stmt->execute([$id]);
        $doc = $stmt->fetch();

        if ($doc) {
            unlink(__DIR__ . '/../../storage/uploads/' . $doc['filename_storage']);
            $stmt = DB::prepare("DELETE FROM documents WHERE id = ?");
            $stmt->execute([$id]);
        }

        header('Location: /documents');
        exit;
    }
}