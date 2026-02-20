<?php
// app/Controllers/DashboardController.php

class DashboardController {
    public function index($params = []) {
        include __DIR__ . '/../Views/dashboard.php';
    }
}