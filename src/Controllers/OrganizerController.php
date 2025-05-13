<?php
namespace App\Controllers;


class OrganizerController {
    private $organizerModel;
    private $userModel;

    public function __construct() {
        $this->organizerModel = new Organizer();
        $this->userModel = new User();
    }

    public function index() {
        Auth::redirectIfNotAdmin();
        $organizers = $this->organizerModel->getAllWithUserDetails();
        include 'views/organizers/index.php';
    }

    public function show($id) {
        Auth::redirectIfNotAdmin();
        $organizer = $this->organizerModel->getByIdWithUserDetails($id);
        if (!$organizer) {
            header("Location: " . BASE_URL . "/organizers");
            exit();
        }
        include 'views/organizers/show.php';
    }
}