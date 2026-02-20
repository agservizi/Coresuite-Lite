<?php
namespace Core;

// app/Core/Logger.php

class Logger {
    private static $logPath = null;

    private static function getLogPath() {
        if (self::$logPath === null) {
            self::$logPath = __DIR__ . '/../../storage/logs';
            if (!is_dir(self::$logPath)) {
                @mkdir(self::$logPath, 0755, true);
            }
        }
        return self::$logPath;
    }

    public static function log($level, $message, array $context = []) {
        $date = date('Y-m-d H:i:s');
        $level = strtoupper($level);
        $contextStr = !empty($context) ? ' ' . json_encode($context, JSON_UNESCAPED_UNICODE) : '';
        $line = "[{$date}] [{$level}] {$message}{$contextStr}" . PHP_EOL;

        $file = self::getLogPath() . '/app-' . date('Y-m-d') . '.log';
        @file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
    }

    public static function info($message, array $context = []) {
        self::log('INFO', $message, $context);
    }

    public static function warning($message, array $context = []) {
        self::log('WARNING', $message, $context);
    }

    public static function error($message, array $context = []) {
        self::log('ERROR', $message, $context);
    }

    public static function debug($message, array $context = []) {
        self::log('DEBUG', $message, $context);
    }
}
