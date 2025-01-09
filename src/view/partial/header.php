<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories</title>
</head>
<body>
    <header>
        <a href="/"><div class="logo">BlogEfrei</div></a>
        <div class="actions">
            <?php
            if(isset($_SESSION['user'])) {
                echo '<a href="/post">Publier</a>';
                echo '<a href="/profil">Profil</a>';
                echo '<a href="/logout">Se déconnecter</a>';
            }
            else {
                echo '<a href="/login">Se connecter</a>';
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
