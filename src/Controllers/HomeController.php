<?php
namespace App\Controllers;



use App\Models\Event;
use App\Models\Organizer;

class HomeController {
    private $eventModel;

    public function __construct() {
        $this->eventModel = new Event();
    }

    public function index() {
        $upcomingEvents = $this->eventModel->getUpcomingEvents(5);
        
        $myEvents = [];
        if (isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] === ROLE_ORGANIZER) {
                $organizerModel = new Organizer();
                $organizer = $organizerModel->getByUserId($_SESSION['user_id']);
                if ($organizer) {
                    $myEvents = $this->eventModel->getByOrganizer($organizer['id']);
                }
            } elseif ($_SESSION['user_role'] === ROLE_ADMIN) {
                $myEvents = $this->eventModel->getAll();
            }
        }

        include __DIR__ . '/../views/home.php';

    }
}