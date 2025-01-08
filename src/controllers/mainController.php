<?php

namespace App\Controllers;

use App\Models\Post;

class MainController
{
    /**
     * Affiche la page d'accueil du site
     */
    public function accueil()
    {
        $articlesModel = new Post();
        $topArticles = $articlesModel->getTopArticles();
        $this->show('accueil');
    }

    /**
     * Show legal mentions page
     */
    public function legalMentions()
    {
        // Affiche la vue dans le dossier views
        $this->show('mentions');
    }

    public function show($viewName, $viewData = [])
    {
        require_once __DIR__ . "/../view/partial/header.php";
        require_once __DIR__ . "/../view/$viewName.php";
        require_once __DIR__ . "/../view/partial/footer.php";
    }
}