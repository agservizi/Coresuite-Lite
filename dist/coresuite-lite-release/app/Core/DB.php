<?php
namespace Core;

use \PDOException;

// app/Core/DB.php

class DB {
    private static $pdo = null;

    private static function ensureConnection() {
        if (self::$pdo === null) {
            self::init();
        }

        if (self::$pdo === null) {
            throw new \RuntimeException('Database non disponibile');
        }
    }

    public static function init() {
        if (self::$pdo === null) {
            $host = Config::get('DB_HOST', 'localhost');
            $db = Config::get('DB_NAME', 'coresuite_lite');
            $user = Config::get('DB_USER', 'root');
            $pass = Config::get('DB_PASS', '');
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$pdo = new \PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                throw new \RuntimeException("Database connection failed: " . $e->getMessage(), 0, $e);
            }
        }
    }

    public static function getPDO() {
        self::ensureConnection();
        return self::$pdo;
    }

    public static function prepare($sql) {
        self::ensureConnection();
        return self::$pdo->prepare($sql);
    }

    public static function query($sql) {
        self::ensureConnection();
        return self::$pdo->query($sql);
    }

    public static function lastInsertId() {
        self::ensureConnection();
        return self::$pdo->lastInsertId();
    }
}