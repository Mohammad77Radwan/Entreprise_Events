<?php
namespace App\Controllers;



use App\models\Event;
use App\models\Reservation;
use App\models\Organizer;

class EventController {
    private $eventModel;
    private $reservationModel;
    private $organizerModel;

    public function __construct() {
        $this->eventModel = new Event();
        $this->reservationModel = new Reservation();
        $this->organizerModel = new Organizer();
    }

    public function index() {
        $events = $this->eventModel->getAll();
        include __DIR__ . '/../views/events/index.php';
    }

    public function show($id) {
        $event = $this->eventModel->getById($id);
        if (!$event) {
            header("Location: " . BASE_URL . "/events");
            exit();
        }

        $participants = $this->reservationModel->getByEvent($id);
        $statusCounts = $this->reservationModel->getStatusCounts($id);
        $participantCount = $this->eventModel->getParticipantCount($id);

        include __DIR__ . '/../views/events/show.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'organizer_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'start_datetime' => trim($_POST['start_datetime']),
                'end_datetime' => trim($_POST['end_datetime']),
                'location' => trim($_POST['location']),
                'max_participants' => intval($_POST['max_participants']),
                'status' => STATUS_PLANNED
            ];

            if ($this->eventModel->create(
                $data['organizer_id'],
                $data['title'],
                $data['description'],
                $data['start_datetime'],
                $data['end_datetime'],
                $data['location'],
                $data['max_participants'],
                $data['status']
            )) {
                $_SESSION['message'] = 'Événement créé avec succès';
                header("Location: " . BASE_URL . "/events");
                exit();
            } else {
                $error = "Une erreur est survenue lors de la création de l'événement";
            }
        }

        include __DIR__ . '/../views/events/create.php';
    }

    public function edit($id) {
        $event = $this->eventModel->getById($id);
        if (!$event) {
            header("Location: " . BASE_URL . "/events");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'start_datetime' => trim($_POST['start_datetime']),
                'end_datetime' => trim($_POST['end_datetime']),
                'location' => trim($_POST['location']),
                'max_participants' => intval($_POST['max_participants']),
                'status' => trim($_POST['status'])
            ];

            if ($this->eventModel->update($id, $data)) {
                $_SESSION['message'] = 'Événement mis à jour avec succès';
                header("Location: " . BASE_URL . "/events/" . $id);
                exit();
            } else {
                $error = "Une erreur est survenue lors de la mise à jour de l'événement";
            }
        }

        include __DIR__ . '/../views/events/edit.php';
    }

    public function delete($id) {
        if ($this->eventModel->delete($id)) {
            $_SESSION['message'] = 'Événement supprimé avec succès';
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de la suppression de l'événement";
        }
        header("Location: " . BASE_URL . "/events");
        exit();
    }

    public function search() {
        $criteria = [
            'title' => $_GET['title'] ?? '',
            'location' => $_GET['location'] ?? '',
            'start_date' => $_GET['start_date'] ?? '',
            'end_date' => $_GET['end_date'] ?? '',
            'status' => $_GET['status'] ?? ''
        ];

        $events = $this->eventModel->search($criteria);
        include __DIR__ . '/../views/events/index.php';
    }
}
