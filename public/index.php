<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\MainController;

$controller = new MainController();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($path) {
    case '/':
        $controller->accueil();
        break;
    default:
        http_response_code(404);
        echo "Page not found";
}