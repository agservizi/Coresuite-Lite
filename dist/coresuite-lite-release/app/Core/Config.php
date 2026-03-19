<?php
namespace Core;

// app/Core/Config.php

class Config {
    private static $config = [];

    private static function envPath(): string {
        return __DIR__ . '/../../.env';
    }

    public static function load() {
        self::$config = [];
        $configFile = self::envPath();
        if (file_exists($configFile)) {
            $lines = file($configFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim((string)$line);
                if ($line === '' || strpos($line, '#') === 0) {
                    continue;
                }
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    self::$config[$key] = trim($value, "\"'");
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
        if (!file_exists(self::envPath())) {
            return true;
        }

        $value = strtolower((string) self::get('INSTALL_ENABLED', '0'));
        return in_array($value, ['1', 'true', 'yes', 'on'], true);
    }

    public static function writeEnv(array $values): void {
        $lines = [];
        foreach ($values as $key => $value) {
            $key = trim((string)$key);
            if ($key === '') {
                continue;
            }

            $rawValue = (string)$value;
            if (preg_match('/\s/', $rawValue) || strpos($rawValue, '#') !== false) {
                $rawValue = '"' . addcslashes($rawValue, "\"\\") . '"';
            }

            $lines[] = $key . '=' . $rawValue;
        }

        file_put_contents(self::envPath(), implode(PHP_EOL, $lines) . PHP_EOL);
        self::load();
    }
}

// Carica configurazione all'avvio
Config::load();
