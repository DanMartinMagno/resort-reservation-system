<?php

namespace App\Helpers;

class Security {
    private static $instance = null;
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Security();
        }
        return self::$instance;
    }

    /**
     * Generate CSRF token
     */
    public function generateCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify CSRF token
     */
    public function verifyCsrfToken($token) {
        if (!empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        return false;
    }

    /**
     * Sanitize input
     */
    public function sanitizeInput($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeInput'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Rate limiting check
     */
    public function checkRateLimit($key, $maxAttempts = 5, $timeWindow = 300) {
        $attempts = $_SESSION['rate_limit'][$key] ?? [];
        $now = time();
        
        // Remove old attempts
        $attempts = array_filter($attempts, function($timestamp) use ($now, $timeWindow) {
            return $timestamp > ($now - $timeWindow);
        });
        
        if (count($attempts) >= $maxAttempts) {
            return false;
        }
        
        $attempts[] = $now;
        $_SESSION['rate_limit'][$key] = $attempts;
        return true;
    }

    /**
     * Password validation
     */
    public function validatePassword($password) {
        $minLength = 8;
        $requireUppercase = true;
        $requireLowercase = true;
        $requireNumbers = true;
        $requireSpecialChars = true;

        if (strlen($password) < $minLength) {
            return false;
        }

        if ($requireUppercase && !preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if ($requireLowercase && !preg_match('/[a-z]/', $password)) {
            return false;
        }

        if ($requireNumbers && !preg_match('/[0-9]/', $password)) {
            return false;
        }

        if ($requireSpecialChars && !preg_match('/[^A-Za-z0-9]/', $password)) {
            return false;
        }

        return true;
    }

    /**
     * Log security events
     */
    public function logSecurityEvent($event, $details) {
        $logEntry = date('Y-m-d H:i:s') . " | " . $event . " | " . json_encode($details) . "\n";
        error_log($logEntry, 3, __DIR__ . '/../../logs/security.log');
    }
}
