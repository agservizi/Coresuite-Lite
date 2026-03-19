<?php
use Core\Logger;

class UIController
{
    // Riceve POST AJAX per logging eventi UI (sidebar toggle)
    public function sidebarToggle()
    {
        // Legge input JSON
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true) ?: [];

        // Verifica CSRF token se presente
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!empty($token) && function_exists('CSRF')) {
            try {
                if (!\CSRF::verifyToken($token)) {
                    http_response_code(403);
                    echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
                    return;
                }
            } catch (\Exception $e) {
                // If CSRF helper not available or verification fails, still continue but warn in log
                Logger::warning('[UIController] CSRF verification error: ' . $e->getMessage());
            }
        }

        $action = $data['action'] ?? 'unknown';
        $mode = $data['mode'] ?? 'unknown';
        $user = $_SESSION['user']['id'] ?? ($_SESSION['user'] ?? null);

        $context = [
            'action' => $action,
            'mode' => $mode,
            'user' => $user,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'
        ];

        Logger::info('[Sidebar] ' . $action . ' (' . $mode . ')', $context);

        header('Content-Type: application/json');
        echo json_encode(['status' => 'ok']);
    }
}
