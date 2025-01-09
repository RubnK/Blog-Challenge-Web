<?php
namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Users;

class CoreController{
    public function show($viewName, $viewData = [])
    {
        require_once __DIR__ . "/../view/partial/header.php";
        require_once __DIR__ . "/../view/$viewName.php";
        require_once __DIR__ . "/../view/partial/footer.php";
    }
    public function redirectToRoute($route)
    {
        header('Location: ' . $route);
        exit;
    }
}