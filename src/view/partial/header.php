<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>BlogEfrei</title>
    <?php
    if($_SERVER['REQUEST_URI'] == '/login' || $_SERVER['REQUEST_URI'] == '/register' || $_SERVER['REQUEST_URI'] == '/profil') {
        echo '<link rel="stylesheet" href="/css/users.css">';
    }
    if($_SERVER['REQUEST_URI'] == '/article' || $_SERVER['REQUEST_URI'] == '/post') {
        echo '<link rel="stylesheet" href="/css/article.css">';
    }
    ?>
</head>
<body>
    <header>
        <a href="/"><div class="logo">BlogEfrei</div></a>
        <div class="actions">
            <?php
            if(isset($_SESSION['user'])) {
                echo '<a href="/post" class="button">Publier</a>';
                echo '<a href="/profil" class="button">Profil</a>';
            }
            else {
                echo '<a href="/login" class="button">Se connecter</a>';
            }
            ?>
        </div>
    </header>
    <nav>
        <?php 
        foreach ($viewData['categories'] as $category) {
            echo '<a href="/category?id='.$category['category_id'].'">'.$category['name'].' </a>';
        }
        ?>
    </nav>
