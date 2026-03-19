<?php
// public/index.php - Front Controller

if (PHP_SAPI === 'cli-server') {
    $requestedPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $publicFile = __DIR__ . ($requestedPath ?: '');

    if ($requestedPath && $requestedPath !== '/' && is_file($publicFile)) {
        return false;
    }
}

// Inizia la sessione
session_start();

// Carica configurazione
require_once __DIR__ . '/../app/Core/Config.php';
require_once __DIR__ . '/../app/Core/Logger.php';
require_once __DIR__ . '/../app/Helpers/csrf.php';

// Logging globale errori PHP
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    \Core\Logger::error("[PHP] $errstr in $errfile:$errline", ['errno' => $errno]);
    return false; // lascia gestire a PHP dopo aver loggato
});
set_exception_handler(function($ex) {
    \Core\Logger::error('[EXCEPTION] ' . $ex->getMessage(), ['trace' => $ex->getTraceAsString()]);
    http_response_code(500);
    echo 'Si è verificato un errore interno.';
    exit;
});
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        \Core\Logger::error('[FATAL] ' . $error['message'], $error);
    }
});

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

Core\Locale::boot();

// Ottieni URI e metodo
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = strtoupper((string)($_SERVER['REQUEST_METHOD'] ?? 'GET'));

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
ob_start();
$router->dispatch($uri, $method);
$response = ob_get_clean();

if ($method !== 'HEAD') {
    echo Core\Locale::translateResponse((string)$response, $uri);
}
