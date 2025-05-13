<?php
namespace App\Controllers;


class ParticipantController {
    private $participantModel;
    private $userModel;

    public function __construct() {
        $this->participantModel = new Participant();
        $this->userModel = new User();
    }

    public function index() {
        Auth::redirectIfNotAdmin();
        $participants = $this->participantModel->getAllWithUserDetails();
        include 'views/participants/index.php';
    }

    public function show($id) {
        Auth::redirectIfNotAdmin();
        $participant = $this->participantModel->getByIdWithUserDetails($id);
        $reservations = (new Reservation())->getByParticipant($id);
        
        if (!$participant) {
            header("Location: " . BASE_URL . "/participants");
            exit();
        }
        include 'views/participants/show.php';
    }
}