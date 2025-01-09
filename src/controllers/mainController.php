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
        $postModel = new Post();
        $posts = $postModel->getAllArticles();
        foreach ($posts as $key => $post) {
            $posts[$key]['likes'] = $postModel->getArticleLikesCount($post['article_id'])['count'];
        }
        usort($posts, function($a, $b) {
            return $b['likes'] <=> $a['likes'];
        });
        $posts = array_slice($posts, 0, 6);
        $this->show('accueil', ['articles' => $posts]);
    }    
}