<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories</title>
</head>
<body>
    <header>
        <div class="logo">Nom du Blog</div>
        <div class="actions">
            <a href="#">Publier</a>
            <a href="#">Se connecter</a>
        </div>
    </header>
    <nav>
        <?php 
        foreach ($viewData['categories'] as $category) {
            echo '<a href="/category.php?id='.$category['category_id'].'">'.$category['name'].'</a>';
        }
        ?>
    </nav>