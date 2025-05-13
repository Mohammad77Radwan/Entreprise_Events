<?php
class Validator {
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validatePassword($password) {
        return strlen($password) >= 8;
    }

    public static function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public static function sanitizeInput($input) {
        return htmlspecialchars(trim($input));
    }

    public static function validateEventData($data) {
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = "Le titre est requis";
        }

        if (empty($data['start_datetime'])) {
            $errors['start_datetime'] = "La date de début est requise";
        } elseif (!self::validateDate($data['start_datetime'], 'Y-m-d\TH:i')) {
            $errors['start_datetime'] = "Format de date invalide";
        }

        if (empty($data['end_datetime'])) {
            $errors['end_datetime'] = "La date de fin est requise";
        } elseif (!self::validateDate($data['end_datetime'], 'Y-m-d\TH:i')) {
            $errors['end_datetime'] = "Format de date invalide";
        } elseif ($data['end_datetime'] <= $data['start_datetime']) {
            $errors['end_datetime'] = "La date de fin doit être après la date de début";
        }

        if (empty($data['location'])) {
            $errors['location'] = "Le lieu est requis";
        }

        if (empty($data['max_participants'])) {
            $errors['max_participants'] = "Le nombre maximum de participants est requis";
        } elseif (!is_numeric($data['max_participants']) || $data['max_participants'] <= 0) {
            $errors['max_participants'] = "Nombre de participants invalide";
        }

        return $errors;
    }
}