<?php
namespace Core;

// app/Core/Config.php

class Config {
    private static $config = [];

    public static function load() {
        $configFile = __DIR__ . '/../../.env';
        if (file_exists($configFile)) {
            $lines = file($configFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    self::$config[trim($key)] = trim($value);
                }
            }
        }
    }

    public static function get($key, $default = null) {
        return self::$config[$key] ?? $default;
    }

    public static function isConfigured() {
        return !empty(self::$config['DB_HOST']) && !empty(self::$config['DB_NAME']);
    }

    public static function isInstallEnabled() {
        $value = strtolower((string) self::get('INSTALL_ENABLED', '0'));
        return in_array($value, ['1', 'true', 'yes', 'on'], true);
    }
}

// Carica configurazione all'avvio
Config::load();