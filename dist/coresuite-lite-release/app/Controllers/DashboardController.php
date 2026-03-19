<?php
use Core\DB;
use Core\Auth;
use Core\Locale;
use Core\NotificationSettings;
use Core\RolePermissions;

// app/Controllers/DashboardController.php

class DashboardController {
    public function index($params = []) {
        try {
            $user = Auth::user();
            $locale = Locale::current();

            $dashboardText = [
                'it' => [
                    'chart_labels' => ['Aperti', 'In lavorazione', 'Risolti', 'Chiusi'],
                    'notification_ticket_title_prefix' => 'Ticket #',
                    'notification_ticket_empty_subject' => '(senza oggetto)',
                    'notification_document_title' => 'Documento disponibile',
                    'notification_document_file' => 'File',
                ],
                'en' => [
                    'chart_labels' => ['Open', 'In Progress', 'Resolved', 'Closed'],
                    'notification_ticket_title_prefix' => 'Ticket #',
                    'notification_ticket_empty_subject' => '(untitled)',
                    'notification_document_title' => 'Document available',
                    'notification_document_file' => 'File',
                ],
                'fr' => [
                    'chart_labels' => ['Ouverts', 'En cours', 'Resolus', 'Fermes'],
                    'notification_ticket_title_prefix' => 'Ticket #',
                    'notification_ticket_empty_subject' => '(sans objet)',
                    'notification_document_title' => 'Document disponible',
                    'notification_document_file' => 'Fichier',
                ],
                'es' => [
                    'chart_labels' => ['Abiertos', 'En curso', 'Resueltos', 'Cerrados'],
                    'notification_ticket_title_prefix' => 'Ticket #',
                    'notification_ticket_empty_subject' => '(sin asunto)',
                    'notification_document_title' => 'Documento disponible',
                    'notification_document_file' => 'Archivo',
                ],
            ];
            $t = $dashboardText[$locale] ?? $dashboardText['it'];

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

            $salesOpenDealsCount = 0;
            $salesReminderCount = 0;
            $salesPipelineValue = 0.0;
            if (!Auth::isCustomer() && RolePermissions::canCurrent('sales_view')) {
                try {
                    $stmt = DB::prepare("SELECT COUNT(*) AS total, COALESCE(SUM(amount), 0) AS total_value FROM crm_deals WHERE status = 'open' AND stage NOT IN ('won', 'lost')");
                    $stmt->execute();
                    $salesDealRow = $stmt->fetch();
                    $salesOpenDealsCount = (int)($salesDealRow['total'] ?? 0);
                    $salesPipelineValue = (float)($salesDealRow['total_value'] ?? 0);

                    $stmt = DB::prepare("SELECT COUNT(*) AS total FROM crm_reminders WHERE status = 'pending'");
                    $stmt->execute();
                    $salesReminderCount = (int)($stmt->fetch()['total'] ?? 0);
                } catch (\Throwable $e) {
                    $salesOpenDealsCount = 0;
                    $salesReminderCount = 0;
                    $salesPipelineValue = 0.0;
                }
            }

            // Donut chart data: distribuzione ticket per stato
            if (Auth::isCustomer()) {
                $stmt = DB::prepare("
                    SELECT status, COUNT(*) as cnt
                    FROM tickets
                    WHERE customer_id = ?
                    GROUP BY status
                ");
                $stmt->execute([$user['id']]);
            } else {
                $stmt = DB::prepare("SELECT status, COUNT(*) as cnt FROM tickets GROUP BY status");
                $stmt->execute();
            }
            $statusRows = $stmt->fetchAll();
            $statusMap = [
                'open' => 0,
                'in_progress' => 0,
                'resolved' => 0,
                'closed' => 0,
            ];
            foreach ($statusRows as $row) {
                $statusKey = (string)($row['status'] ?? '');
                if (isset($statusMap[$statusKey])) {
                    $statusMap[$statusKey] = (int)($row['cnt'] ?? 0);
                }
            }
            $chartLabels = $t['chart_labels'];
            $chartValues = array_values($statusMap);

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

            // Activity center: ultime azioni
            if (Auth::isCustomer()) {
                $stmt = DB::prepare("SELECT action, entity, entity_id, created_at FROM audit_logs WHERE actor_id = ? OR (entity = 'ticket' AND entity_id IN (SELECT id FROM tickets WHERE customer_id = ?)) OR (entity = 'document' AND entity_id IN (SELECT id FROM documents WHERE customer_id = ?)) ORDER BY created_at DESC LIMIT 8");
                $stmt->execute([$user['id'], $user['id'], $user['id']]);
            } else {
                $stmt = DB::prepare("SELECT action, entity, entity_id, created_at FROM audit_logs ORDER BY created_at DESC LIMIT 8");
                $stmt->execute();
            }
            $recentActivity = $stmt->fetchAll();

            // Kanban snapshot
            if (Auth::isCustomer()) {
                $stmt = DB::prepare("SELECT id, subject, status, priority, created_at FROM tickets WHERE customer_id = ? ORDER BY created_at DESC LIMIT 18");
                $stmt->execute([$user['id']]);
            } else {
                $stmt = DB::prepare("SELECT id, subject, status, priority, created_at FROM tickets ORDER BY created_at DESC LIMIT 18");
                $stmt->execute();
            }
            $kanbanTickets = $stmt->fetchAll();

            // Customer summary cards for admin/operator
            if (!Auth::isCustomer()) {
                $stmt = DB::prepare("
                    SELECT
                        u.id,
                        u.name,
                        COUNT(DISTINCT t.id) AS tickets_total,
                        SUM(CASE WHEN t.status = 'open' THEN 1 ELSE 0 END) AS tickets_open,
                        COUNT(DISTINCT d.id) AS documents_total
                    FROM users u
                    LEFT JOIN tickets t ON t.customer_id = u.id
                    LEFT JOIN documents d ON d.customer_id = u.id
                    WHERE u.role = 'customer'
                    GROUP BY u.id, u.name
                    ORDER BY tickets_open DESC, tickets_total DESC, documents_total DESC, u.name ASC
                    LIMIT 4
                ");
                $stmt->execute();
                $customerSummaries = $stmt->fetchAll();
            } else {
                $customerSummaries = [];
            }

            // Inbox/notifications derived from latest entities
            $notificationSettings = NotificationSettings::all();
            $notificationItems = [];
            if (!empty($notificationSettings['dashboard_notification_inbox']) && !empty($notificationSettings['in_app_ticket_activity'])) {
                foreach ($latestTickets as $ticketItem) {
                    $notificationItems[] = [
                        'icon' => 'fa-ticket-alt',
                        'tone' => 'ticket',
                        'notify_tone' => 'warning',
                        'title' => $t['notification_ticket_title_prefix'] . (int)$ticketItem['id'],
                        'text' => (string)($ticketItem['subject'] ?: $t['notification_ticket_empty_subject']),
                        'meta' => (string)($ticketItem['created_at'] ?? ''),
                        'href' => '/tickets/' . (int)$ticketItem['id'],
                    ];
                }
            }
            if (!empty($notificationSettings['dashboard_notification_inbox']) && !empty($notificationSettings['in_app_document_activity'])) {
                foreach ($latestDocuments as $documentItem) {
                    $notificationItems[] = [
                        'icon' => 'fa-file-alt',
                        'tone' => 'document',
                        'notify_tone' => 'success',
                        'title' => $t['notification_document_title'],
                        'text' => (string)($documentItem['filename_original'] ?? $t['notification_document_file']),
                        'meta' => (string)($documentItem['created_at'] ?? ''),
                        'href' => '/documents',
                    ];
                }
            }
            $notificationItems = array_slice($notificationItems, 0, 6);

        } catch (\Throwable $e) {
            $customersCount = 0;
            $ticketsCount = 0;
            $openTicketsCount = 0;
            $documentsCount = 0;
            $chartLabels = [];
            $chartValues = [];
            $latestTickets = [];
            $latestDocuments = [];
            $recentActivity = [];
            $kanbanTickets = [];
            $customerSummaries = [];
            $notificationItems = [];
            $salesOpenDealsCount = 0;
            $salesReminderCount = 0;
            $salesPipelineValue = 0.0;
        }

        include __DIR__ . '/../Views/dashboard.php';
    }
}
