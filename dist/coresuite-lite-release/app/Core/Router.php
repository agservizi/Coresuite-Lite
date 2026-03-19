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
        $method = strtoupper((string)$method);
        $matchMethod = $method === 'HEAD' ? 'GET' : $method;

        foreach ($this->routes as $route) {
            if ($route['method'] === $matchMethod && $this->matchPath($route['path'], $uri, $params)) {
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
        $this->add('GET', '/locale/:code', 'Locale@set');
        $this->add('GET', '/reset-password', 'Auth@resetPassword');
        $this->add('POST', '/reset-password', 'Auth@resetPassword');
        $this->add('GET', '/reset-password/:token', 'Auth@resetPasswordForm');
        $this->add('POST', '/reset-password/:token', 'Auth@resetPasswordForm');

        // Dashboard
        $this->add('GET', '/dashboard', 'Dashboard@index', ['middleware' => ['Auth']]);
        $this->add('GET', '/search', 'Search@index', ['middleware' => ['Auth']]);
        $this->add('GET', '/api/search/spotlight', 'Search@spotlight', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales', 'Sales@index', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/pipeline', 'Sales@pipeline', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/calendar', 'Sales@calendar', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/companies/create', 'Sales@createCompany', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/contacts/create', 'Sales@createContact', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/leads/create', 'Sales@createLead', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/deals/create', 'Sales@createDeal', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/activities/create', 'Sales@createActivity', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/reminders/create', 'Sales@createReminder', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/quotes/create', 'Sales@createQuote', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/invoices/create', 'Sales@createInvoice', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/quotes/:id/edit', 'Sales@editQuote', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/invoices/:id/edit', 'Sales@editInvoice', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/quotes/:id/pdf', 'Sales@quotePdf', ['middleware' => ['Auth']]);
        $this->add('GET', '/sales/invoices/:id/pdf', 'Sales@invoicePdf', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/companies', 'Sales@storeCompany', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/contacts', 'Sales@storeContact', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/leads', 'Sales@storeLead', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/deals', 'Sales@storeDeal', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/deals/:id/stage', 'Sales@updateDealStage', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/activities', 'Sales@storeActivity', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/reminders', 'Sales@storeReminder', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/reminders/:id/complete', 'Sales@completeReminder', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/quotes', 'Sales@storeQuote', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/invoices', 'Sales@storeInvoice', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/quotes/:id', 'Sales@updateQuote', ['middleware' => ['Auth']]);
        $this->add('POST', '/sales/invoices/:id', 'Sales@updateInvoice', ['middleware' => ['Auth']]);
        $this->add('GET', '/customers', 'Customer@list', ['middleware' => ['Auth']]);
        $this->add('GET', '/customers/:id', 'Customer@show', ['middleware' => ['Auth']]);
        $this->add('GET', '/projects', 'Project@list', ['middleware' => ['Auth']]);
        $this->add('GET', '/projects/board', 'Project@board', ['middleware' => ['Auth']]);
        $this->add('GET', '/projects/create', 'Project@create', ['middleware' => ['Auth']]);
        $this->add('POST', '/projects', 'Project@store', ['middleware' => ['Auth']]);
        $this->add('GET', '/projects/:id', 'Project@show', ['middleware' => ['Auth']]);
        $this->add('GET', '/projects/:id/edit', 'Project@edit', ['middleware' => ['Auth']]);
        $this->add('POST', '/projects/:id', 'Project@update', ['middleware' => ['Auth']]);
        $this->add('POST', '/projects/:id/delete', 'Project@delete', ['middleware' => ['Auth']]);
        $this->add('POST', '/projects/:id/milestones', 'Project@addMilestone', ['middleware' => ['Auth']]);
        $this->add('POST', '/projects/:id/milestones/:milestoneId/update', 'Project@updateMilestone', ['middleware' => ['Auth']]);
        $this->add('POST', '/projects/:id/milestones/:milestoneId/delete', 'Project@deleteMilestone', ['middleware' => ['Auth']]);
        $this->add('POST', '/projects/:id/tasks', 'Project@addTask', ['middleware' => ['Auth']]);
        $this->add('POST', '/projects/:id/tasks/:taskId/update', 'Project@updateTask', ['middleware' => ['Auth']]);
        $this->add('POST', '/projects/:id/tasks/:taskId/status', 'Project@updateTaskStatus', ['middleware' => ['Auth']]);
        $this->add('POST', '/projects/:id/tasks/:taskId/delete', 'Project@deleteTask', ['middleware' => ['Auth']]);
        $this->add('GET', '/reports', 'Report@index', ['middleware' => ['Auth']]);
        $this->add('GET', '/audit-logs', 'AuditLog@index', ['middleware' => ['Auth']]);
        $this->add('GET', '/workspace/settings', 'Workspace@settings', ['middleware' => ['Auth']]);
        $this->add('POST', '/workspace/settings', 'Workspace@updateSettings', ['middleware' => ['Auth']]);
        $this->add('GET', '/workspace/notifications', 'Notification@settings', ['middleware' => ['Auth']]);
        $this->add('POST', '/workspace/notifications', 'Notification@updateSettings', ['middleware' => ['Auth']]);

        // Admin routes
        $this->add('GET', '/admin/users', 'Admin/User@list', ['middleware' => ['Auth', 'Role']]);
        $this->add('GET', '/admin/roles-permissions', 'Roles@index', ['middleware' => ['Auth', 'Role']]);
        $this->add('POST', '/admin/roles-permissions', 'Roles@update', ['middleware' => ['Auth', 'Role']]);
        $this->add('GET', '/admin/users/create', 'Admin/User@create', ['middleware' => ['Auth', 'Role']]);
        $this->add('POST', '/admin/users', 'Admin/User@store', ['middleware' => ['Auth', 'Role']]);
        $this->add('GET', '/admin/users/:id/edit', 'Admin/User@edit', ['middleware' => ['Auth', 'Role']]);
        $this->add('POST', '/admin/users/:id', 'Admin/User@update', ['middleware' => ['Auth', 'Role']]);
        $this->add('POST', '/admin/users/:id/delete', 'Admin/User@delete', ['middleware' => ['Auth', 'Role']]);

        // Ticket routes
        $this->add('GET', '/tickets', 'Ticket@list', ['middleware' => ['Auth']]);
        $this->add('GET', '/tickets/board', 'Ticket@board', ['middleware' => ['Auth']]);
        $this->add('GET', '/tickets/create', 'Ticket@create', ['middleware' => ['Auth']]);
        $this->add('POST', '/tickets', 'Ticket@store', ['middleware' => ['Auth']]);
        $this->add('GET', '/tickets/:id', 'Ticket@show', ['middleware' => ['Auth']]);
        $this->add('POST', '/tickets/:id/comment', 'Ticket@addComment', ['middleware' => ['Auth']]);
        $this->add('POST', '/tickets/:id/status', 'Ticket@updateStatus', ['middleware' => ['Auth']]);
        $this->add('POST', '/tickets/:id/assign', 'Ticket@assignTicket', ['middleware' => ['Auth', 'Role']]);

        // Profile routes
        $this->add('GET', '/profile', 'Profile@index', ['middleware' => ['Auth']]);
        $this->add('POST', '/profile', 'Profile@update', ['middleware' => ['Auth']]);

        // Document routes
        $this->add('GET', '/documents', 'Document@list', ['middleware' => ['Auth']]);
        $this->add('GET', '/documents/board', 'Document@board', ['middleware' => ['Auth']]);
        $this->add('GET', '/documents/upload', 'Document@uploadForm', ['middleware' => ['Auth', 'Role']]);
        $this->add('POST', '/documents', 'Document@upload', ['middleware' => ['Auth', 'Role']]);
        $this->add('GET', '/documents/:id/download', 'Document@download', ['middleware' => ['Auth']]);
        $this->add('POST', '/documents/:id/delete', 'Document@delete', ['middleware' => ['Auth', 'Role']]);

        // Install
        if (Config::isInstallEnabled()) {
            $this->add('GET', '/install', 'Install@index');
            $this->add('POST', '/install', 'Install@setup');
        }

        // UI AJAX routes (client-side interactions logging)
        $this->add('POST', '/api/ui/sidebar-toggle', 'UI@sidebarToggle', ['middleware' => ['Auth']]);
    }
}
