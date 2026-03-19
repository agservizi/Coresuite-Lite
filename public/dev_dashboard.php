<?php
// Development-only dashboard preview (auto-login as demo)
require_once __DIR__ . '/../coresuite/auth/Auth.php';
Auth::start();
// set demo session user for preview
$_SESSION['user'] = ['id'=>0,'email'=>'demo@local','role'=>'admin'];
$page = 'dashboard';
require __DIR__ . '/../coresuite/layouts/layout.php';
