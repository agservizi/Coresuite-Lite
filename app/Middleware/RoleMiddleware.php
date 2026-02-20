<?php
use Core\Auth;

// app/Middleware/RoleMiddleware.php

class RoleMiddleware {
    public function handle() {
        // Assume admin for admin routes, operator for others
        // In a real app, pass required roles
        try {
            if (!Auth::isAdmin()) {
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