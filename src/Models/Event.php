<?php

namespace App\models;

use PDO;

class Event {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getUpcomingEvents($limit = 5) {
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE start_datetime >= NOW() ORDER BY start_datetime ASC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByOrganizer($organizerId) {
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE organizer_id = :organizer_id");
        $stmt->bindParam(':organizer_id', $organizerId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT e.*, o.first_name AS organizer_first_name, o.last_name AS organizer_last_name
            FROM events e
            JOIN organizers o ON e.organizer_id = o.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($criteria) {
        $query = "SELECT e.*, o.first_name AS organizer_first_name, o.last_name AS organizer_last_name
                  FROM events e
                  JOIN organizers o ON e.organizer_id = o.id
                  WHERE 1 = 1";

        $params = [];

        if (!empty($criteria['title'])) {
            $query .= " AND e.title LIKE :title";
            $params[':title'] = '%' . $criteria['title'] . '%';
        }

        if (!empty($criteria['location'])) {
            $query .= " AND e.location LIKE :location";
            $params[':location'] = '%' . $criteria['location'] . '%';
        }

        if (!empty($criteria['start_date'])) {
            $query .= " AND e.start_datetime >= :start_date";
            $params[':start_date'] = $criteria['start_date'];
        }

        if (!empty($criteria['end_date'])) {
            $query .= " AND e.end_datetime <= :end_date";
            $params[':end_date'] = $criteria['end_date'];
        }

        if (!empty($criteria['status'])) {
            $query .= " AND e.status = :status";
            $params[':status'] = $criteria['status'];
        }

        $query .= " ORDER BY e.start_datetime ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
