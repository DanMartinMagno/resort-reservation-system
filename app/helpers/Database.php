<?php

namespace App\Helpers;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();

            $this->conn = new PDO(
                "mysql:host=" . $_ENV['DB_HOST'] . 
                ";dbname=" . $_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS']
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Connection Error: " . $e->getMessage());
            throw new \Exception("Database connection failed");
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            error_log("Query Error: " . $e->getMessage());
            throw new \Exception("Database query failed");
        }
    }
}
