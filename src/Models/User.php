<?php
namespace App\models;

use App\Utils\Database;
use PDO;

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function create($username, $email, $password, $role = ROLE_EMPLOYEE) {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_BCRYPT),
            ':role' => $role
        ]);
        return $this->db->lastInsertId();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $query = "UPDATE users SET ";
        $params = [];
        foreach ($data as $key => $value) {
            $query .= "$key = :$key, ";
            $params[":$key"] = $value;
        }
        $query = rtrim($query, ', ') . " WHERE id = :id";
        $params[':id'] = $id;

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}