<?php

namespace App\Controllers;

use App\Helpers\Security;
use App\Helpers\Validation;

abstract class Controller {
    protected $security;
    protected $validator;

    public function __construct() {
        $this->security = Security::getInstance();
        $this->validator = Validation::getInstance();
    }

    protected function view($view, $data = []) {
        // Extract data to make it available in view
        extract($data);
        
        // Generate CSRF token for forms
        $csrf_token = $this->security->generateCsrfToken();
        
        // Include the view file
        $viewPath = __DIR__ . '/../../views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            throw new \Exception("View {$view} not found");
        }
    }

    protected function redirect($url) {
        header("Location: " . $url);
        exit;
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function validateRequest($rules) {
        $this->validator->reset();
        foreach ($rules as $field => $validations) {
            foreach ($validations as $validation => $params) {
                if (method_exists($this->validator, $validation)) {
                    $value = $_POST[$field] ?? '';
                    if (is_array($params)) {
                        $this->validator->$validation($value, ...$params);
                    } else {
                        $this->validator->$validation($value);
                    }
                }
            }
        }
        return $this->validator->passed();
    }
}
