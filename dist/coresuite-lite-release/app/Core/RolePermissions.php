<?php
namespace Core;

class RolePermissions {
    private static $defaults = [
        'admin' => [
            'sales_view' => true,
            'sales_manage' => true,
            'sales_pipeline_view' => true,
            'sales_calendar_view' => true,
            'quotes_view' => true,
            'quotes_manage' => true,
            'invoices_view' => true,
            'invoices_manage' => true,
            'projects_view' => true,
            'projects_manage' => true,
            'tickets_view' => true,
            'tickets_create' => true,
            'tickets_manage' => true,
            'documents_view' => true,
            'documents_upload' => true,
            'customers_view' => true,
            'reports_view' => true,
            'audit_logs_view' => true,
            'users_manage' => true,
            'workspace_settings_view' => true,
            'notification_settings_view' => true,
            'roles_permissions_view' => true,
        ],
        'operator' => [
            'sales_view' => true,
            'sales_manage' => true,
            'sales_pipeline_view' => true,
            'sales_calendar_view' => true,
            'quotes_view' => true,
            'quotes_manage' => true,
            'invoices_view' => true,
            'invoices_manage' => true,
            'projects_view' => true,
            'projects_manage' => true,
            'tickets_view' => true,
            'tickets_create' => false,
            'tickets_manage' => true,
            'documents_view' => true,
            'documents_upload' => true,
            'customers_view' => true,
            'reports_view' => true,
            'audit_logs_view' => true,
            'users_manage' => false,
            'workspace_settings_view' => false,
            'notification_settings_view' => false,
            'roles_permissions_view' => false,
        ],
        'customer' => [
            'sales_view' => false,
            'sales_manage' => false,
            'sales_pipeline_view' => false,
            'sales_calendar_view' => false,
            'quotes_view' => false,
            'quotes_manage' => false,
            'invoices_view' => false,
            'invoices_manage' => false,
            'projects_view' => true,
            'projects_manage' => false,
            'tickets_view' => true,
            'tickets_create' => true,
            'tickets_manage' => false,
            'documents_view' => true,
            'documents_upload' => false,
            'customers_view' => false,
            'reports_view' => false,
            'audit_logs_view' => false,
            'users_manage' => false,
            'workspace_settings_view' => false,
            'notification_settings_view' => false,
            'roles_permissions_view' => false,
        ],
    ];

    private static $cache = null;

    private static function path() {
        return __DIR__ . '/../storage/role_permissions.json';
    }

    public static function all() {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $permissions = self::$defaults;
        $path = self::path();
        if (is_file($path)) {
            $raw = file_get_contents($path);
            $decoded = json_decode((string)$raw, true);
            if (is_array($decoded)) {
                foreach (self::$defaults as $role => $roleDefaults) {
                    if (isset($decoded[$role]) && is_array($decoded[$role])) {
                        $permissions[$role] = array_merge($roleDefaults, $decoded[$role]);
                    }
                }
            }
        }

        self::$cache = $permissions;
        return $permissions;
    }

    public static function defaults() {
        return self::$defaults;
    }

    public static function permissionKeys() {
        return array_keys(self::$defaults['admin']);
    }

    public static function forRole($role) {
        $all = self::all();
        return $all[$role] ?? [];
    }

    public static function can($role, $permission) {
        $rolePermissions = self::forRole((string)$role);
        return !empty($rolePermissions[$permission]);
    }

    public static function canCurrent($permission) {
        $user = Auth::user();
        if (!$user) {
            return false;
        }
        return self::can((string)($user['role'] ?? ''), $permission);
    }

    public static function save(array $input) {
        $permissions = self::$defaults;
        foreach (self::$defaults as $role => $roleDefaults) {
            foreach ($roleDefaults as $permission => $default) {
                $permissions[$role][$permission] = !empty($input['permissions'][$role][$permission]);
            }
        }

        $dir = dirname(self::path());
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents(
            self::path(),
            json_encode($permissions, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );

        self::$cache = $permissions;
        return $permissions;
    }
}
