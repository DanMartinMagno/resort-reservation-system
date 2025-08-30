<?php

// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Database configuration
define("DB_HOST", $_ENV['DB_HOST']);
define("DB_NAME", $_ENV['DB_NAME']);
define("DB_USER", $_ENV['DB_USER']);
define("DB_PASS", $_ENV['DB_PASS']);

// Application URLs
define("APP_URL", $_ENV['APP_URL']);
define("ADMIN_URL", $_ENV['ADMIN_URL']);

// Security settings
define("HASH_COST", 12); // For password hashing
define("SESSION_LIFETIME", 7200); // 2 hours

// File upload settings
define("MAX_FILE_SIZE", 5 * 1024 * 1024); // 5MB
define("ALLOWED_FILE_TYPES", ['image/jpeg', 'image/png', 'image/gif']);
define("UPLOAD_PATH", __DIR__ . '/../public/uploads/');

// Error reporting in production
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Session security settings
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');
