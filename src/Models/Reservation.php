<?php
namespace App\Models;

class Reservation {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function create($eventId, $participantId, $status = RESERVATION_PENDING, $comments = null) {
        $stmt = $this->db->prepare("INSERT INTO reservations (event_id, participant_id, status, comments) 
                                   VALUES (:event_id, :participant_id, :status, :comments)");
        $stmt->execute([
            ':event_id' => $eventId,
            ':participant_id' => $participantId,
            ':status' => $status,
            ':comments' => $comments
        ]);
        return $this->db->lastInsertId();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT r.*, e.title as event_title, p.first_name, p.last_name 
                                   FROM reservations r
                                   JOIN events e ON r.event_id = e.id
                                   JOIN participants p ON r.participant_id = p.id
                                   WHERE r.id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEvent($eventId) {
        $stmt = $this->db->prepare("SELECT r.*, p.first_name, p.last_name, p.email, p.department
                                   FROM reservations r
                                   JOIN participants p ON r.participant_id = p.id
                                   WHERE r.event_id = :event_id
                                   ORDER BY r.reservation_date");
        $stmt->execute([':event_id' => $eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByParticipant($participantId) {
        $stmt = $this->db->prepare("SELECT r.*, e.title, e.start_datetime, e.location
                                   FROM reservations r
                                   JOIN events e ON r.event_id = e.id
                                   WHERE r.participant_id = :participant_id
                                   ORDER BY e.start_datetime");
        $stmt->execute([':participant_id' => $participantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $query = "UPDATE reservations SET ";
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
        $stmt = $this->db->prepare("DELETE FROM reservations WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function exists($eventId, $participantId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM reservations 
                                   WHERE event_id = :event_id AND participant_id = :participant_id");
        $stmt->execute([
            ':event_id' => $eventId,
            ':participant_id' => $participantId
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function getStatusCounts($eventId) {
        $stmt = $this->db->prepare("SELECT status, COUNT(*) as count 
                                   FROM reservations 
                                   WHERE event_id = :event_id 
                                   GROUP BY status");
        $stmt->execute([':event_id' => $eventId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}