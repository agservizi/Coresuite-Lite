<?php
use Core\DB;
use Core\Auth;

// app/Controllers/TicketController.php

class TicketController {
    public function list($params = []) {
        $user = Auth::user();
        if (Auth::isCustomer()) {
            $stmt = DB::prepare("SELECT * FROM tickets WHERE customer_id = ? ORDER BY created_at DESC");
            $stmt->execute([$user['id']]);
        } elseif (Auth::isOperator()) {
            $stmt = DB::prepare("SELECT t.*, u.name as customer_name FROM tickets t JOIN users u ON t.customer_id = u.id ORDER BY t.created_at DESC");
            $stmt->execute();
        }
        $tickets = $stmt->fetchAll();

        include __DIR__ . '/../Views/tickets.php';
    }

    public function create($params = []) {
        include __DIR__ . '/../Views/ticket_form.php';
    }

    public function store($params = []) {
        $user = Auth::user();
        $category = $_POST['category'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $body = $_POST['body'] ?? '';

        if (empty($category) || empty($body)) {
            $error = 'Categoria e descrizione sono obbligatori';
            include __DIR__ . '/../Views/ticket_form.php';
            return;
        }

        $stmt = DB::prepare("INSERT INTO tickets (customer_id, category, subject) VALUES (?, ?, ?)");
        $stmt->execute([$user['id'], $category, $subject]);

        $ticketId = DB::lastInsertId();

        // Aggiungi primo commento
        $stmt = DB::prepare("INSERT INTO ticket_comments (ticket_id, author_id, body) VALUES (?, ?, ?)");
        $stmt->execute([$ticketId, $user['id'], $body]);

        header('Location: /tickets');
        exit;
    }

    public function show($params = []) {
        $id = $params['id'];
        $stmt = DB::prepare("SELECT t.*, u.name as customer_name FROM tickets t JOIN users u ON t.customer_id = u.id WHERE t.id = ?");
        $stmt->execute([$id]);
        $ticket = $stmt->fetch();

        if (!$ticket) {
            http_response_code(404);
            include __DIR__ . '/../Views/errors/404.php';
            return;
        }

        // Controlla permessi
        $user = Auth::user();
        if (Auth::isCustomer() && $ticket['customer_id'] != $user['id']) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            return;
        }

        $stmt = DB::prepare("SELECT c.*, u.name as author_name FROM ticket_comments c JOIN users u ON c.author_id = u.id WHERE c.ticket_id = ? ORDER BY c.created_at ASC");
        $stmt->execute([$id]);
        $comments = $stmt->fetchAll();

        include __DIR__ . '/../Views/ticket_detail.php';
    }

    public function addComment($params = []) {
        $id = $params['id'];
        $body = $_POST['body'] ?? '';
        $visibility = $_POST['visibility'] ?? 'public';

        if (empty($body)) {
            header('Location: /tickets/' . $id);
            exit;
        }

        $user = Auth::user();
        $stmt = DB::prepare("INSERT INTO ticket_comments (ticket_id, author_id, body, visibility) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id, $user['id'], $body, $visibility]);

        header('Location: /tickets/' . $id);
        exit;
    }

    public function updateStatus($params = []) {
        $id = $params['id'];
        $status = $_POST['status'] ?? '';

        if (Auth::isOperator()) {
            $stmt = DB::prepare("UPDATE tickets SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
        }

        header('Location: /tickets/' . $id);
        exit;
    }
}