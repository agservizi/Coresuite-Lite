<?php
use Core\DB;
use Core\Auth;

// app/Controllers/DashboardController.php

class DashboardController {
    public function index($params = []) {
        try {
            $user = Auth::user();

            // KPI
            $stmt = DB::prepare("SELECT COUNT(*) as total FROM users WHERE role = 'customer'");
            $stmt->execute();
            $customersCount = (int)$stmt->fetch()['total'];

            $stmt = DB::prepare("SELECT COUNT(*) as total FROM tickets");
            $stmt->execute();
            $ticketsCount = (int)$stmt->fetch()['total'];

            $stmt = DB::prepare("SELECT COUNT(*) as total FROM tickets WHERE status = 'open'");
            $stmt->execute();
            $openTicketsCount = (int)$stmt->fetch()['total'];

            $stmt = DB::prepare("SELECT COUNT(*) as total FROM documents");
            $stmt->execute();
            $documentsCount = (int)$stmt->fetch()['total'];

            // Dati chart: ticket aperti negli ultimi 30 giorni (raggruppati per giorno)
            $chartData = [];
            $stmt = DB::prepare("SELECT DATE(created_at) as day, COUNT(*) as cnt FROM tickets WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE(created_at) ORDER BY day ASC");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            // Riempi tutti i 30 giorni
            $chartLabels = [];
            $chartValues = [];
            for ($i = 29; $i >= 0; $i--) {
                $day = date('Y-m-d', strtotime("-$i days"));
                $chartLabels[] = date('d/m', strtotime($day));
                $found = false;
                foreach ($rows as $r) {
                    if ($r['day'] === $day) {
                        $chartValues[] = (int)$r['cnt'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $chartValues[] = 0;
                }
            }

            // Ultimi 5 ticket
            if (Auth::isCustomer()) {
                $stmt = DB::prepare("SELECT id, subject, status, created_at FROM tickets WHERE customer_id = ? ORDER BY created_at DESC LIMIT 5");
                $stmt->execute([$user['id']]);
            } else {
                $stmt = DB::prepare("SELECT id, subject, status, created_at FROM tickets ORDER BY created_at DESC LIMIT 5");
                $stmt->execute();
            }
            $latestTickets = $stmt->fetchAll();

            // Ultimi 5 documenti
            if (Auth::isCustomer()) {
                $stmt = DB::prepare("SELECT id, filename_original, created_at FROM documents WHERE customer_id = ? ORDER BY created_at DESC LIMIT 5");
                $stmt->execute([$user['id']]);
            } else {
                $stmt = DB::prepare("SELECT d.id, d.filename_original, d.created_at, u.name as customer_name FROM documents d JOIN users u ON d.customer_id = u.id ORDER BY d.created_at DESC LIMIT 5");
                $stmt->execute();
            }
            $latestDocuments = $stmt->fetchAll();

        } catch (\Throwable $e) {
            $customersCount = 0;
            $ticketsCount = 0;
            $openTicketsCount = 0;
            $documentsCount = 0;
            $chartLabels = [];
            $chartValues = [];
            $latestTickets = [];
            $latestDocuments = [];
        }

        include __DIR__ . '/../Views/dashboard.php';
    }
}