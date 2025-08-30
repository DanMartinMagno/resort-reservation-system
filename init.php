<?php

// Initialize autoloading and error handling
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize error logging
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('hi-way-411');
$logger->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG));

// Set error handling
set_error_handler(function ($severity, $message, $file, $line) use ($logger) {
    $logger->error($message, [
        'file' => $file,
        'line' => $line,
        'severity' => $severity
    ]);
});

// Set exception handling
set_exception_handler(function ($e) use ($logger) {
    $logger->error($e->getMessage(), [
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ]);
});

// Start session with secure settings
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => true,
    'cookie_samesite' => 'Lax',
    'use_strict_mode' => true
]);

// Define common constants
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');
define('VIEW_PATH', BASE_PATH . '/views');
define('UPLOAD_PATH', BASE_PATH . '/public/uploads');

// Time zone setting
date_default_timezone_set('Asia/Manila');
