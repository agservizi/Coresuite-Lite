<?php
use Core\Auth;

// app/Middleware/RoleMiddleware.php

class RoleMiddleware {
    private $allowedRoles;

    public function __construct($allowedRoles = ['admin']) {
        if (is_string($allowedRoles)) {
            $allowedRoles = [$allowedRoles];
        }
        $this->allowedRoles = $allowedRoles;
    }

    public function handle() {
        try {
            $user = Auth::user();
            if (!$user || !in_array($user['role'], $this->allowedRoles, true)) {
                http_response_code(403);
                include __DIR__ . '/../Views/errors/403.php';
                exit;
            }
        } catch (\Throwable $e) {
            http_response_code(403);
            include __DIR__ . '/../Views/errors/403.php';
            exit;
        }
        return true;
    }
}