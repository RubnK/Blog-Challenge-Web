<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\MainController;
use App\Controllers\UsersController;
use App\Controllers\ArticleController;

$MainController = new MainController();
$UsersController = new UsersController();
$ArticleController = new ArticleController();

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
    case '/post':
        $ArticleController->post();
        break;
    case '/article':
        $ArticleController->article();
        break;
    default:
        http_response_code(404);
        echo "Page not found";
}