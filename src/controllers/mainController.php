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
        $topArticles = $postModel->getTopArticles();
        $listPosts = [];
        $i = 0;
        foreach ($topArticles as $topArticle) {
            foreach ($posts as $post) {
                if ($post['article_id'] == $topArticle['article_id']) {
                    $listPosts[$i] = $post;
                    $listPosts[$i]['likes'] = $postModel->getArticleLikesCount($post['article_id'])['count'];
                    $i++;
                }
            }
            
        }
        $this->show('accueil', ['articles' => $listPosts]);
    }    
}