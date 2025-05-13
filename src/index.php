<?php
session_start();
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/Utils/helpers.php';

// Autoloader
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/';
    $prefix = 'App\\';

    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Get relative class name
    $relativeClass = substr($class, $len);

    // Replace namespace separators with directory separators
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Route handling
$request = $_SERVER['REQUEST_URI'];
$basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
$route = str_replace($basePath, '', $request);
$routeParts = explode('?', $route);
$route = $routeParts[0];

// Default values
$controller = DEFAULT_CONTROLLER;
$action = DEFAULT_ACTION;
$params = [];

if (!empty($route)) {
    $routeParts = explode('/', trim($route, '/'));
    $controller = !empty($routeParts[0]) ? $routeParts[0] : $controller;
    $action = !empty($routeParts[1]) ? $routeParts[1] : $action;
    $params = array_slice($routeParts, 2);
}

// Use autoloaded controller
$controllerClass = 'App\\Controllers\\' . ucfirst($controller) . 'Controller';

if (class_exists($controllerClass)) {
    $controllerInstance = new $controllerClass();

    if (method_exists($controllerInstance, $action)) {
        call_user_func_array([$controllerInstance, $action], $params);
    } else {
        http_response_code(404);
        echo "Action not found: $action in $controllerClass";
    }
} else {
    http_response_code(404);
    echo "Controller not found: $controllerClass";
}
