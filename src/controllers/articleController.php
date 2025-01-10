<?php 

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Users;

class ArticleController extends CoreController
{
    public function article()
    {        
        if(!isset($_GET['article_id'])) {
            $this->redirectToRoute('/');
        }
        $postModel = new Post();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
            $comment = htmlspecialchars($_POST['content']);
            $author = $_SESSION['user']['id'];
            $article_id = $_GET['article_id'];

            $postModel->createComment($article_id, $author, $comment);
        }
        if (isset($_POST['like'])) {

            $likes = $postModel->getArticleLikes($_GET['article_id']);

            foreach ($likes as $like) {
                if ($like['user_id'] == $_SESSION['user']['id']) {
                    ?>
                    <script>
                        alert('Vous avez déjà liké cet article');
                    </script>
                    <?php
                    $err = true;
                }
            }
            if (!isset($err)) {
                $author = $_SESSION['user']['id'];
                $article_id = $_GET['article_id'];

                $postModel->likeArticle($author, $article_id);
            }
        }
        $id = $_GET['article_id'];

        $articleData = $postModel->getArticle($id);

        $commentsData = $postModel->getComments($id);

        $likesCount = $postModel->getArticleLikesCount($id);


        $this->show('article', ['article' => $articleData, 'comments' => $commentsData, 'likesCount' => $likesCount]);
    }

    public function post()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirectToRoute('login');
        }
        if (isset($_POST['title']) && isset($_POST['content'])) {
            $title = htmlspecialchars($_POST['title']);
            $content = htmlspecialchars($_POST['content']);
            $category = htmlspecialchars($_POST['category']);
            $author = $_SESSION['user']['id'];
            $image = $_FILES['image'];

            if ($image['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                $imagePath = $uploadDir . basename($image['name']);

                // Vérification et déplacement de l'image
                if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                    $relativePath = '/../../public/uploads/' . basename($image['name']);
                } else {
                    throw new \Exception("Erreur lors de l'upload de l'image");
                }
            } else {
                throw new \Exception("Aucune image sélectionnée ou erreur d'upload");
            }
            $postModel = new Post();
            $postModel->createArticle($title, $content, $author, basename($image['name']), $category);

            $this->redirectToRoute('/');
        }
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();
        $this->show('post', ['categories' => $categories]);
    }

    public function delete()
    {
        $id = $_GET['id'];
        $postModel = new Post();
        $postModel->deleteArticle($id);

        $this->redirectToRoute('/');
    }
}