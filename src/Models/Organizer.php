<?php
namespace App\Models;

use PDO;

class Organizer {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM organizers WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
