<?php 

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Users;

class ArticleController extends CoreController
{
    public function article()
    {
        if(!isset($_GET['id'])) {
            $this->redirectToRoute('/');
        }
        $id = $_GET['id'];
        $postModel = new Post();

        // Fetch article data from the database based on $id
        $articleData = $postModel->getArticle($id);

        // Fetch comments data from the database based on $id
        $commentsData = $postModel->getComments($id);

        // Pass the article data to the view
        $this->show('article', ['article' => $articleData, 'comments' => $commentsData]);
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