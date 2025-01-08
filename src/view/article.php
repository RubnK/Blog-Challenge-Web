<?php
$host = 'localhost';
$dbname = 'blog';
$user = 'postgres'; // Remplacez par votre nom d'utilisateur
$pass = 'cactus4705'; // Remplacez par votre mot de passe

// Créer une connexion à la base de données
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>

<?php

// Récupérer l'ID de l'article
$article_id = $_GET['article_id']; // L'ID de l'article passé via l'URL

// Récupérer l'article de la base de données
$stmt = $pdo->prepare("SELECT * FROM articles WHERE article_id = :article_id");
$stmt->execute(['article_id' => $article_id]);
$article = $stmt->fetch();

// Récupérer les commentaires associés à l'article
$comments_stmt = $pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id ORDER BY created_at DESC");
$comments_stmt->execute(['article_id' => $article_id]);
$comments = $comments_stmt->fetchAll();

// Traitement du formulaire de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $user_id = 1; // ID de l'utilisateur connecté (à ajuster selon votre gestion d'utilisateur)
    $content = $_POST['comment'];

    $insert_comment = $pdo->prepare("INSERT INTO comments (article_id, user_id, content) VALUES (:article_id, :user_id, :content)");
    $insert_comment->execute([
        'article_id' => $article_id,
        'user_id' => $user_id,
        'content' => $content
    ]);

    // Rediriger vers la même page pour afficher le nouveau commentaire
    header("Location: index.php?article_id=" . $article_id);
    exit();
}

// Traitement du like
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like'])) {
    $user_id = 1; // ID de l'utilisateur connecté (à ajuster)

    $like_stmt = $pdo->prepare("SELECT * FROM likes WHERE article_id = :article_id AND user_id = :user_id");
    $like_stmt->execute(['article_id' => $article_id, 'user_id' => $user_id]);

    // Si l'utilisateur n'a pas encore aimé l'article, ajouter le like
    if ($like_stmt->rowCount() === 0) {
        $insert_like = $pdo->prepare("INSERT INTO likes (article_id, user_id) VALUES (:article_id, :user_id)");
        $insert_like->execute(['article_id' => $article_id, 'user_id' => $user_id]);

        // Incrémenter le nombre de likes
        $update_likes = $pdo->prepare("UPDATE articles SET shares = shares + 1 WHERE article_id = :article_id");
        $update_likes->execute(['article_id' => $article_id]);

        // Rediriger pour afficher le nombre de likes mis à jour
        header("Location: index.php?article_id=" . $article_id);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?></title>
</head>
<body>

<h1><?= htmlspecialchars($article['title']) ?></h1>
<img src="<?= htmlspecialchars($article['image']) ?>" alt="Image de l'article">
<p><?= htmlspecialchars($article['content']) ?></p>

<form method="post">
    <button type="submit" name="like">🤍 J'aime</button>
</form>

<p>Likes: <?= $article['shares'] ?></p>

<!-- Affichage des commentaires -->
<h2>Commentaires</h2>
<?php foreach ($comments as $comment): ?>
    <div class="comment">
        <p><strong>Utilisateur <?= $comment['user_id'] ?>:</strong> <?= htmlspecialchars($comment['content']) ?></p>
        <p><em>Publié le <?= $comment['created_at'] ?></em></p>
    </div>
<?php endforeach; ?>

<!-- Formulaire de commentaire -->
<h3>Ajouter un commentaire</h3>
<form method="post">
    <textarea name="comment" placeholder="Votre commentaire" required></textarea>
    <button type="submit">Publier</button>
</form>

</body>
</html>

