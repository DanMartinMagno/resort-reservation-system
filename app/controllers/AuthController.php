<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller {
    private $user;

    public function __construct() {
        parent::__construct();
        $this->user = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!$this->security->verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                return $this->json(['error' => 'Invalid token']);
            }

            // Check rate limiting
            if (!$this->security->checkRateLimit('login')) {
                return $this->json(['error' => 'Too many login attempts. Please try again later.']);
            }

            // Validate input
            $rules = [
                'email' => ['required' => true, 'email' => true],
                'password' => ['required' => true]
            ];

            if (!$this->validateRequest($rules)) {
                return $this->json(['errors' => $this->validator->getErrors()]);
            }

            try {
                $user = $this->user->findByEmail($_POST['email']);

                if ($user && password_verify($_POST['password'], $user->mypassword)) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['username'] = $user->username;
                    
                    // Regenerate session ID after successful login
                    session_regenerate_id(true);
                    
                    return $this->redirect(APP_URL);
                }

                return $this->view('auth/login', [
                    'error' => 'Invalid email or password'
                ]);
            } catch (\Exception $e) {
                error_log("Login error: " . $e->getMessage());
                return $this->view('auth/login', [
                    'error' => 'An error occurred during login'
                ]);
            }
        }

        return $this->view('auth/login');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify CSRF token
            if (!$this->security->verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                return $this->json(['error' => 'Invalid token']);
            }

            // Validate input
            $rules = [
                'username' => ['required' => true, 'length' => [3, 50]],
                'email' => ['required' => true, 'email' => true],
                'password' => ['required' => true]
            ];

            if (!$this->validateRequest($rules)) {
                return $this->json(['errors' => $this->validator->getErrors()]);
            }

            // Check if password meets requirements
            if (!$this->security->validatePassword($_POST['password'])) {
                return $this->view('auth/register', [
                    'error' => 'Password must be at least 8 characters and include uppercase, lowercase, numbers, and special characters'
                ]);
            }

            try {
                // Check if email already exists
                if ($this->user->findByEmail($_POST['email'])) {
                    return $this->view('auth/register', [
                        'error' => 'Email already registered'
                    ]);
                }

                // Sanitize input
                $input = $this->security->sanitizeInput($_POST);
                
                // Create user
                $this->user->create([
                    'username' => $input['username'],
                    'email' => $input['email'],
                    'mypassword' => $input['password']
                ]);

                return $this->redirect('/auth/login');
            } catch (\Exception $e) {
                error_log("Registration error: " . $e->getMessage());
                return $this->view('auth/register', [
                    'error' => 'An error occurred during registration'
                ]);
            }
        }

        return $this->view('auth/register');
    }

    public function logout() {
        // Clear session data
        session_unset();
        session_destroy();
        
        // Clear session cookie
        setcookie(session_name(), '', time() - 3600, '/');
        
        return $this->redirect(APP_URL);
    }
}
