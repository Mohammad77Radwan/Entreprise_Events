<?php
class Auth {
    public static function check() {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === ROLE_ADMIN;
    }

    public static function isOrganizer() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === ROLE_ORGANIZER;
    }

    public static function isEmployee() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === ROLE_EMPLOYEE;
    }

    public static function redirectIfNotAuthenticated() {
        if (!self::check()) {
            header("Location: " . BASE_URL . "/auth/login");
            exit();
        }
    }

    public static function redirectIfNotAdmin() {
        self::redirectIfNotAuthenticated();
        if (!self::isAdmin()) {
            header("Location: " . BASE_URL . "/home");
            exit();
        }
    }

    public static function redirectIfNotOrganizer() {
        self::redirectIfNotAuthenticated();
        if (!self::isOrganizer()) {
            header("Location: " . BASE_URL . "/home");
            exit();
        }
    }
}