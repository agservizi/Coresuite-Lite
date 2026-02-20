<?php
namespace Core;

// app/Core/Auth.php

class Auth {
    private static $user = null;

    public static function user() {
        if (self::$user === null && isset($_SESSION['user_id'])) {
            $stmt = DB::prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            self::$user = $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return self::$user;
    }

    public static function check() {
        return self::user() !== null;
    }

    public static function login($email, $password, $remember = false) {
        $stmt = DB::prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['last_activity'] = time();

            if ($remember) {
                self::createRememberToken($user['id']);
            }

            // Log login
            self::logAction('login', 'user', $user['id']);

            return true;
        }
        return false;
    }

    public static function logout() {
        if (isset($_SESSION['user_id'])) {
            self::logAction('logout', 'user', $_SESSION['user_id']);
        }

        // Remove remember token if exists
        if (isset($_COOKIE['remember_token'])) {
            self::removeRememberToken($_COOKIE['remember_token']);
            setcookie('remember_token', '', time() - 3600);
        }

        session_destroy();
        self::$user = null;
    }

    public static function hasRole($role) {
        $user = self::user();
        return $user && $user['role'] === $role;
    }

    public static function isAdmin() {
        return self::hasRole('admin');
    }

    public static function isOperator() {
        return self::hasRole('operator') || self::isAdmin();
    }

    public static function isCustomer() {
        return self::hasRole('customer');
    }

    private static function createRememberToken($userId) {
        $token = bin2hex(random_bytes(32));
        $tokenHash = password_hash($token, PASSWORD_DEFAULT);
        $expires = date('Y-m-d H:i:s', time() + 30 * 24 * 3600); // 30 days

        $stmt = DB::prepare("INSERT INTO remember_tokens (user_id, token_hash, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $tokenHash, $expires]);

        setcookie('remember_token', $token, time() + 30 * 24 * 3600, '/', '', true, true);
    }

    private static function removeRememberToken($token) {
        $stmt = DB::prepare("DELETE FROM remember_tokens WHERE token_hash = ?");
        $stmt->execute([password_hash($token, PASSWORD_DEFAULT)]);
    }

    public static function checkRememberToken() {
        if (!self::check() && isset($_COOKIE['remember_token'])) {
            $stmt = DB::prepare("SELECT user_id FROM remember_tokens WHERE token_hash = ? AND expires_at > NOW()");
            $stmt->execute([password_hash($_COOKIE['remember_token'], PASSWORD_DEFAULT)]);
            $token = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($token) {
                $_SESSION['user_id'] = $token['user_id'];
                $_SESSION['last_activity'] = time();
                // Update last_used_at
                $stmt = DB::prepare("UPDATE remember_tokens SET last_used_at = NOW() WHERE user_id = ?");
                $stmt->execute([$token['user_id']]);
            }
        }
    }

    public static function regenerateSession() {
        session_regenerate_id(true);
    }

    public static function checkSessionTimeout() {
        $timeout = 30 * 60; // 30 minutes
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
            self::logout();
            return false;
        }
        $_SESSION['last_activity'] = time();
        return true;
    }

    private static function logAction($action, $entity, $entityId) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $actorId = $_SESSION['user_id'] ?? null;

        $stmt = DB::prepare("INSERT INTO audit_logs (actor_id, action, entity, entity_id, ip, user_agent) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$actorId, $action, $entity, $entityId, $ip, $userAgent]);
    }
}