<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Users;

class MainController extends CoreController
{
    /**
     * Affiche la page d'accueil du site
     */
    public function accueil()
    {
        if (isset($_SESSION['user']['id'])) {
            $usersModel = new Users();
            $user = $usersModel->getUser($_SESSION['user']['id']);
            $this->show('accueil', ['user' => $user]);
        }
        else {
            $this->show('accueil');
        }
    }    
}