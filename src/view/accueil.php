<?php
// Connexion à la base de données PostgreSQL
$host = 'localhost';
$dbname = 'blog';
$user = 'root';
$password = '-Ey39&Ma15';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


// Démarrer la session
session_start();

// Redirection si l'utilisateur est déjà connecté
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// Récupérer les articles depuis la base de données
$query = "SELECT * FROM articles ORDER BY created_at DESC";
$articles = $pdo->query($query)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Inscription et connexion</title>
</head>
<body>
    <header>
        <h1>Les Tendances</h1>
    </header>

    <div>
        <a href="register.php">Inscription</a>
        <a href="login.php">Connexion</a>
    </div>

    <div class="container">
        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <div class="article">
                    <img src="<?= htmlspecialchars($article['image_url'] ?? 'https://via.placeholder.com/300x200') ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                    <h2><?= htmlspecialchars($article['title']) ?></h2>
                    <p><?= htmlspecialchars(substr($article['content'], 0, 150)) ?>...</p>
                    <p>Last update: <?= htmlspecialchars(date('Y-m-d', strtotime($article['created_at']))) ?></p>
                    <a href="article.php?id=<?= htmlspecialchars($article['article_id']) ?>">Lire plus</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
