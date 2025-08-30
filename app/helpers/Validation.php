<?php

namespace App\Helpers;

class Validation {
    private $errors = [];
    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Validation();
        }
        return self::$instance;
    }

    /**
     * Required field validation
     */
    public function required($value, $field) {
        if (empty(trim($value))) {
            $this->errors[$field] = ucfirst($field) . " is required";
            return false;
        }
        return true;
    }

    /**
     * Email validation
     */
    public function email($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Invalid email format";
            return false;
        }
        return true;
    }

    /**
     * Date validation
     */
    public function validateDate($date, $format = 'Y-m-d') {
        $d = \DateTime::createFromFormat($format, $date);
        if ($d && $d->format($format) === $date) {
            return true;
        }
        $this->errors['date'] = "Invalid date format";
        return false;
    }

    /**
     * Phone number validation
     */
    public function phone($phone) {
        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $this->errors['phone'] = "Invalid phone number format";
            return false;
        }
        return true;
    }

    /**
     * Number range validation
     */
    public function range($value, $min, $max, $field) {
        if ($value < $min || $value > $max) {
            $this->errors[$field] = ucfirst($field) . " must be between $min and $max";
            return false;
        }
        return true;
    }

    /**
     * String length validation
     */
    public function length($value, $min, $max, $field) {
        $length = strlen($value);
        if ($length < $min || $length > $max) {
            $this->errors[$field] = ucfirst($field) . " must be between $min and $max characters";
            return false;
        }
        return true;
    }

    /**
     * Get validation errors
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Check if validation passed
     */
    public function passed() {
        return empty($this->errors);
    }

    /**
     * Reset validation errors
     */
    public function reset() {
        $this->errors = [];
    }
}
