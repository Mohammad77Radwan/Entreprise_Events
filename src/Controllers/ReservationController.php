<?php
namespace App\Controllers;


class ReservationController {
    private $reservationModel;
    private $eventModel;
    private $participantModel;

    public function __construct() {
        $this->reservationModel = new Reservation();
        $this->eventModel = new Event();
        $this->participantModel = new Participant();
    }

    public function create($eventId) {
        Auth::redirectIfNotAuthenticated();
        
        $event = $this->eventModel->getById($eventId);
        if (!$event) {
            header("Location: " . BASE_URL . "/events");
            exit();
        }

        $participant = $this->participantModel->getByUserId($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->reservationModel->exists($eventId, $participant['id'])) {
                $_SESSION['error'] = "Vous êtes déjà inscrit à cet événement";
            } else {
                $this->reservationModel->create(
                    $eventId,
                    $participant['id'],
                    RESERVATION_CONFIRMED,
                    trim($_POST['comments'])
                );
                $_SESSION['message'] = "Inscription confirmée!";
                header("Location: " . BASE_URL . "/events/" . $eventId);
                exit();
            }
        }

        include 'views/reservations/create.php';
    }

    public function index() {
        Auth::redirectIfNotAdmin();
        $reservations = $this->reservationModel->getAllWithDetails();
        include 'views/reservations/index.php';
    }
}