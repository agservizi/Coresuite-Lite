<?php
// public/index.php - Front Controller

// Inizia la sessione
session_start();

// Carica configurazione
require_once __DIR__ . '/../app/Core/Config.php';
require_once __DIR__ . '/../app/Helpers/csrf.php';

// Autoload semplice (per classi in app/)
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../app/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Carica controller specifici
require_once __DIR__ . '/../app/Controllers/HomeController.php';

// Inizializza DB se possibile
try {
    Core\DB::init();
} catch (Exception $e) {
    // DB non configurato, continua senza DB
}

// Ottieni URI e metodo
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Rimuovi base path se necessario (per hosting condiviso)
$basePath = '/'; // Modifica se necessario
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}
if ($uri === '' || $uri === '/') {
    $uri = '/';
}

// Router
$router = new Core\Router();
$router->initRoutes();
$router->dispatch($uri, $method);