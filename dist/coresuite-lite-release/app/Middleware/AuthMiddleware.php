<?php
use Core\Auth;

// app/Middleware/AuthMiddleware.php

class AuthMiddleware {
    public function handle() {
        try {
            Auth::checkRememberToken();
            if (!Auth::check()) {
                header('Location: /login');
                exit;
            }
            return Auth::checkSessionTimeout();
        } catch (\Throwable $e) {
            header('Location: /login');
            exit;
        }
    }
}