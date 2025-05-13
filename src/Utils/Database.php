<?php

namespace App\utils;

use PDO;
use PDOException;

class Database {
    private $host = 'mysql';
    private $db_name = 'events_db';
    private $username = 'event_user';
    private $password = 'event_pass';
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES utf8mb4");
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw $e;
        }

        return $this->conn;
    }

    public function getLastInsertId() {
        return $this->conn->lastInsertId();
    }
}
