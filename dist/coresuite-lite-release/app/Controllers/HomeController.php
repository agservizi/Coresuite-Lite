<?php
use Core\Auth;

// app/Controllers/HomeController.php

class HomeController {
    public function index($params = []) {
        try {
            if (Auth::check()) {
                header('Location: /dashboard');
            } else {
                header('Location: /login');
            }
        } catch (Exception $e) {
            // DB non disponibile, reindirizza al login
            header('Location: /login');
        }
        exit;
    }
}
?>