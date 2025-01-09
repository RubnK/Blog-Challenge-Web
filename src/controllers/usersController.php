<?php 
namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Users;

class UsersController extends CoreController
{
    public function profil()
    {
        if (!isset($_GET['id']) && isset($_SESSION['user']['id'])) {
            $id = $_SESSION['user']['id'];
        }
        else if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        else {
            $this->redirectToRoute('login');
        }
        $postModels = new Post();
        $userArticles = $postModels->getArticlesByUser($id);
        $usersModel = new Users();
        $user = $usersModel->getUser($id);
        $this->show('profil', ['user' => $user, 'userArticles' => $userArticles]);
    }

    public function create()
    {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = hash('sha512', $_POST['password']);

        $usersModel = new Users();
        $usersModel->createUser($email, $password, $username);

        $this->redirectToRoute('/');
    }

    public function update()
    {
        $id = $_SESSION['id'];
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = hash('sha512', $_POST['password']);

        $usersModel = new Users();
        $usersModel->updateUser($id, $username, $email, $password);

        $this->redirectToRoute('profil?id=' . $id);
    }

    public function delete()
    {
        $id = $_SESSION['id'];
        $usersModel = new Users();
        $usersModel->deleteUser($id);

        $this->redirectToRoute('/');
    }

    function login()
    {
        $error = "";
        if (isset($_SESSION['user']['id'])) {
            $this->redirectToRoute('profil');
        }
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['identifier']) || empty($_POST['password'])) {
                $error = "Veuillez remplir tous les champs";
                $this->show('login', ['error' => $error]);
                return;
            }
            elseif (!filter_var($_POST['identifier'], FILTER_VALIDATE_EMAIL) && !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['identifier'])) {
                $error = "Identifiant invalide";
                $this->show('login', ['error' => $error]);
                return;
            }
            $usersModel = new Users();
            $user = $usersModel->login(htmlspecialchars($_POST['identifier']), hash('sha512', htmlspecialchars($_POST['password'])));
            if (!empty($user)) {
                $_SESSION['user']['id'] = $user['user_id'];
                $this->redirectToRoute('profil');
            }
            else {
                $error = "Identifiant ou mot de passe incorrect";
                $this->show('login', ['error' => $error]);
                return;
            }
        }
        $this->show('login', ['error' => $error]);
    }

    function register()
    {
        $error = "";
        if (isset($_SESSION['user']['id'])) {
            $this->redirectToRoute('profil');
        }
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $usersModel = new Users();
            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
                $error = "Veuillez remplir tous les champs";
                $this->show('register', ['error' => $error]);
                return;
            }
            elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Adresse e-mail invalide";
                $this->show('register', ['error' => $error]);
                return;
            }
            elseif (strlen($_POST['password']) < 8) {
                $error = "Le mot de passe doit contenir au moins 8 caractères";
                $this->show('register', ['error' => $error]);
                return;
            }
            elseif (!empty($usersModel->userExists(htmlspecialchars($_POST['email'])))) {
                $error = "Un compte existe déjà avec cette adresse e-mail";
                $this->show('register', ['error' => $error]);
                return;
            }
            $usersModel = new Users();
            $usersModel->createUser(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['email']), hash('sha512', htmlspecialchars($_POST['password'])));
            $this->redirectToRoute('profil');
        }
        $this->show('register', ['error' => $error]);
    }

    public function logout()
    {
        session_destroy();
        $this->redirectToRoute('/');
    }
}