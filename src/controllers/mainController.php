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
        $articlesModel = new Post();
        $articles = $articlesModel->getAllArticles();
        $this->show('accueil', ['articles' => $articles]);
    }    
}