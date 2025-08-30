<?php

namespace App\Middleware;

class Auth {
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . APP_URL . '/auth/login');
            exit;
        }
    }

    public static function requireAdmin() {
        if (!isset($_SESSION['adminname'])) {
            header('Location: ' . ADMIN_URL . '/admins/login-admins.php');
            exit;
        }
    }

    public static function guest() {
        if (self::isLoggedIn()) {
            header('Location: ' . APP_URL);
            exit;
        }
    }
}
