<?php
class Participant {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function create($userId, $firstName, $lastName, $email, $phone = null, $department = null) {
        $stmt = $this->db->prepare("INSERT INTO participants (user_id, first_name, last_name, email, phone, department) 
                                   VALUES (:user_id, :first_name, :last_name, :email, :phone, :department)");
        $stmt->execute([
            ':user_id' => $userId,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':phone' => $phone,
            ':department' => $department
        ]);
        return $this->db->lastInsertId();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM participants WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM participants WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM participants");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWithUserDetails() {
        $stmt = $this->db->prepare("SELECT p.*, u.username, u.role 
                                   FROM participants p 
                                   JOIN users u ON p.user_id = u.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByIdWithUserDetails($id) {
        $stmt = $this->db->prepare("SELECT p.*, u.username, u.role 
                                   FROM participants p 
                                   JOIN users u ON p.user_id = u.id 
                                   WHERE p.id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $query = "UPDATE participants SET ";
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
        $stmt = $this->db->prepare("DELETE FROM participants WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}