<?php

require_once __DIR__ . '/init.php';

use App\Router;
use App\Controllers\AuthController;
use App\Controllers\RoomController;
use App\Controllers\BookingController;
use App\Middleware\Auth;

$router = new Router();

// Public routes
$router->get('/', [RoomController::class, 'index']);
$router->get('/rooms', [RoomController::class, 'index']);
$router->get('/room/{id}', [RoomController::class, 'show']);

// Auth routes
$router->get('/auth/login', [AuthController::class, 'login'], [Auth::class, 'guest']);
$router->post('/auth/login', [AuthController::class, 'login'], [Auth::class, 'guest']);
$router->get('/auth/register', [AuthController::class, 'register'], [Auth::class, 'guest']);
$router->post('/auth/register', [AuthController::class, 'register'], [Auth::class, 'guest']);
$router->get('/auth/logout', [AuthController::class, 'logout']);

// Protected routes
$router->get('/bookings', [BookingController::class, 'index'], [Auth::class, 'requireLogin']);
$router->post('/bookings', [BookingController::class, 'create'], [Auth::class, 'requireLogin']);
$router->get('/booking/{id}', [BookingController::class, 'show'], [Auth::class, 'requireLogin']);

// Admin routes (these should be in a separate admin.php file)
$router->get('/admin/rooms', [RoomController::class, 'adminIndex'], [Auth::class, 'requireAdmin']);
$router->post('/admin/rooms', [RoomController::class, 'create'], [Auth::class, 'requireAdmin']);

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
