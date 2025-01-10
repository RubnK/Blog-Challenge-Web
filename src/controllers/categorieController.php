<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;

class CategorieController extends CoreController
{
    // Affiche une catégorie avec ses articles
    public function categorie()
    {
        if (!isset($_GET['id'])) {
            $this->redirectToRoute('/');
        }

        $id = $_GET['id'];
        $categoryModel = new Category();

        // Récupérer les données de la catégorie
        $categoryData = $categoryModel->getCategory($id);

        // Récupérer les articles associés à la catégorie
        $postModel = new Post();
        $articles = $postModel->getArticlesByCategorie($id);

        // Passer les données à la vue
        $this->show('categorie', ['category' => $categoryData, 'articles' => $articles]);
    }

}
