<?php
namespace Core;

use Core\Auth;
use Core\DB;
use Core\Config;

// app/Core/Router.php

class Router {
    private $routes = [];

    public function add($method, $path, $handler, $options = []) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
            'middleware' => $options['middleware'] ?? []
        ];
    }

    public function dispatch($uri, $method) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $uri, $params)) {
                // Middleware check
                if (!$this->checkMiddleware($route)) {
                    return;
                }

                // Call handler
                if (is_callable($route['handler'])) {
                    call_user_func($route['handler'], $params);
                } elseif (is_string($route['handler'])) {
                    $this->callController($route['handler'], $params);
                }
                return;
            }
        }

        // 404
        $this->error404();
    }

    private function matchPath($routePath, $uri, &$params) {
        $routeParts = explode('/', trim($routePath, '/'));
        $uriParts = explode('/', trim($uri, '/'));

        if (count($routeParts) !== count($uriParts)) {
            return false;
        }

        $params = [];
        for ($i = 0; $i < count($routeParts); $i++) {
            if (strpos($routeParts[$i], ':') === 0) {
                $params[substr($routeParts[$i], 1)] = $uriParts[$i];
            } elseif ($routeParts[$i] !== $uriParts[$i]) {
                return false;
            }
        }
        return true;
    }

    private function checkMiddleware($route) {
        // Implementa middleware qui se necessario
        // Per ora, semplice controllo auth
        if (isset($route['middleware'])) {
            foreach ($route['middleware'] as $middleware) {
                $middlewareClass = $middleware . 'Middleware';
                $middlewareFile = __DIR__ . '/../Middleware/' . $middlewareClass . '.php';
                if (file_exists($middlewareFile)) {
                    require_once $middlewareFile;
                }
                if (class_exists($middlewareClass)) {
                    $instance = new $middlewareClass();
                    if (!$instance->handle()) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    private function callController($handler, $params) {
        list($controller, $method) = explode('@', $handler);
        $controllerFile = __DIR__ . '/../Controllers/' . $controller . 'Controller.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        }

        $controllerClass = str_replace('/', '_', $controller) . 'Controller';
        if (class_exists($controllerClass)) {
            $instance = new $controllerClass();
            if (method_exists($instance, $method)) {
                call_user_func_array([$instance, $method], [$params]);
            } else {
                $this->error404();
            }
        } else {
            $this->error404();
        }
    }

    private function error404() {
        http_response_code(404);
        include __DIR__ . '/../Views/errors/404.php';
    }

    public function initRoutes() {
        // Home
        $this->add('GET', '/', 'Home@index');

        // Auth routes
        $this->add('GET', '/login', 'Auth@login');
        $this->add('POST', '/login', 'Auth@login');
        $this->add('GET', '/logout', 'Auth@logout');
        $this->add('GET', '/reset-password', 'Auth@resetPassword');
        $this->add('POST', '/reset-password', 'Auth@resetPassword');
        $this->add('GET', '/reset-password/:token', 'Auth@resetPasswordForm');
        $this->add('POST', '/reset-password/:token', 'Auth@resetPasswordForm');

        // Dashboard
        $this->add('GET', '/dashboard', 'Dashboard@index', ['middleware' => ['Auth']]);

        // Admin routes
        $this->add('GET', '/admin/users', 'Admin/User@list', ['middleware' => ['Auth', 'Role']]);
        $this->add('GET', '/admin/users/create', 'Admin/User@create', ['middleware' => ['Auth', 'Role']]);
        $this->add('POST', '/admin/users', 'Admin/User@store', ['middleware' => ['Auth', 'Role']]);
        $this->add('GET', '/admin/users/:id/edit', 'Admin/User@edit', ['middleware' => ['Auth', 'Role']]);
        $this->add('POST', '/admin/users/:id', 'Admin/User@update', ['middleware' => ['Auth', 'Role']]);
        $this->add('POST', '/admin/users/:id/delete', 'Admin/User@delete', ['middleware' => ['Auth', 'Role']]);

        // Ticket routes
        $this->add('GET', '/tickets', 'Ticket@list', ['middleware' => ['Auth']]);
        $this->add('GET', '/tickets/create', 'Ticket@create', ['middleware' => ['Auth']]);
        $this->add('POST', '/tickets', 'Ticket@store', ['middleware' => ['Auth']]);
        $this->add('GET', '/tickets/:id', 'Ticket@show', ['middleware' => ['Auth']]);
        $this->add('POST', '/tickets/:id/comment', 'Ticket@addComment', ['middleware' => ['Auth']]);
        $this->add('POST', '/tickets/:id/status', 'Ticket@updateStatus', ['middleware' => ['Auth']]);

        // Document routes
        $this->add('GET', '/documents', 'Document@list', ['middleware' => ['Auth']]);
        $this->add('GET', '/documents/upload', 'Document@uploadForm', ['middleware' => ['Auth', 'Role']]);
        $this->add('POST', '/documents', 'Document@upload', ['middleware' => ['Auth', 'Role']]);
        $this->add('GET', '/documents/:id/download', 'Document@download', ['middleware' => ['Auth']]);
        $this->add('POST', '/documents/:id/delete', 'Document@delete', ['middleware' => ['Auth', 'Role']]);

        // Install
        if (Config::isInstallEnabled()) {
            $this->add('GET', '/install', 'Install@index');
            $this->add('POST', '/install', 'Install@setup');
        }
    }
}