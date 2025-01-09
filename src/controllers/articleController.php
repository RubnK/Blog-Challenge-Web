<?php 

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Users;

class ArticleController extends CoreController
{
    public function article($id)
    {
        $postModel = new Post();

        // Fetch article data from the database based on $id
        $articleData = $postModel->getArticle($id);

        // Fetch comments data from the database based on $id
        $commentsData = $postModel->getComments($id);

        // Pass the article data to the view
        $this->show('article', ['article' => $articleData, 'comments' => $commentsData]);
    }

    public function create()
    {
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $category = htmlspecialchars($_POST['category']);
        $author = $_SESSION['id'];

        $postModel = new Post();
        $postModel->createArticle($title, $content, $category, $author);

        $this->redirectToRoute('/');
    }

    public function delete()
    {
        $id = $_GET['id'];
        $postModel = new Post();
        $postModel->deleteArticle($id);

        $this->redirectToRoute('/');
    }
}