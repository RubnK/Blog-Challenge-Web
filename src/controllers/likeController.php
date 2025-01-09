<?php
namespace App\Controllers;

use App\Models\Post;

class LikeController extends CoreController
{
    public function like()
    {
        $postModel = new Post();
        $postModel->likeArticle($_GET['id']);
        $this->redirectToRoute('article?id=' . $_GET['id']);
    }

    public function unlike()
    {
        $postModel = new Post();
        $postModel->unlikeArticle($_GET['id']);
        $this->redirectToRoute('article?id=' . $_GET['id']);
    }
}