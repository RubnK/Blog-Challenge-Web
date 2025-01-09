<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\MainController;
use App\Controllers\UsersController;

$MainController = new MainController();
$UsersController = new UsersController();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($path) {
    case '/':
        $MainController->accueil();
        break;
    case '/profil':
        $UsersController->profil();
        break;
    case '/login':
        $UsersController->login();
        break;
    case '/register':
        $UsersController->register();
        break;
    case '/logout':
        $UsersController->logout();
        break;
    default:
        http_response_code(404);
        echo "Page not found";
}