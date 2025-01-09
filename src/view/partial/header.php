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
        <!-- Liens des catégories récupérés depuis la base de données -->
        <?php

        // Configuration de la base de données
        $host = 'localhost';
        $dbname = 'blog';
        $user = 'postgres';
        $password = '-Ey39&Ma15';
        try {
            $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            $query = $pdo->query("SELECT name FROM categories");
            while ($row = $query->fetch()) {
                echo '<a href="#">' . htmlspecialchars($row['name']) . '</a>';
            }
        } catch (PDOException $e) {
            echo "<p>Erreur : " . $e->getMessage() . "</p>";
        }
        ?>
    </nav>
