<?php
function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

function asset($path) {
    return BASE_URL . '/assets/' . ltrim($path, '/');
}

function redirect($path) {
    header("Location: " . url($path));
    exit();
}

function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function formatDateTime($datetime, $format = 'd/m/Y H:i') {
    $date = new DateTime($datetime);
    return $date->format($format);
}

function isCurrentPage($path) {
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $currentPath = str_replace(BASE_URL, '', $currentPath);
    return $currentPath === $path;
}