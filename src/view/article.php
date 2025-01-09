<?php
// Connexion à la base de données
$host = "localhost";
$dbname = "blog";
$user = "postgres";
$password = "cactus4705";
$dsn = "pgsql:host=$host;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}

// Démarrage de la session
session_start();

// Vérification si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);
$currentUserId = $isLoggedIn ? $_SESSION['user_id'] : null;

// Récupérer un article spécifique si l'ID est passé dans l'URL
if (isset($_GET['article_id'])) {
    $articleId = $_GET['article_id'];
    $articlesQuery = "SELECT a.article_id, a.title, a.content, a.created_at, u.username, a.image 
                      FROM articles a
                      JOIN users u ON a.user_id = u.user_id
                      WHERE a.article_id = :article_id";
    $articlesStmt = $pdo->prepare($articlesQuery);
    $articlesStmt->execute(['article_id' => $articleId]);
    $articles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Sinon, afficher tous les articles
    $articlesQuery = "SELECT a.article_id, a.title, a.content, a.created_at, u.username, a.image 
                      FROM articles a
                      JOIN users u ON a.user_id = u.user_id
                      ORDER BY a.created_at DESC";
    $articlesStmt = $pdo->query($articlesQuery);
    $articles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les commentaires pour chaque article
$commentsQuery = "SELECT c.comment_id, c.content, c.created_at, u.username 
                  FROM comments c
                  JOIN users u ON c.user_id = u.user_id
                  WHERE c.article_id = :article_id
                  ORDER BY c.created_at DESC";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publication</title>
  <link rel="stylesheet" href="../css/article.css">
</head>
<body>
  <div class="container">
    <!-- Lien pour revenir à la liste des articles -->
    <?php if (isset($_GET['article_id'])): ?>
      <a href="index.php" class="back-link">← Retour à la liste des articles</a>
    <?php endif; ?>

    <?php foreach ($articles as $article): ?>
      <div class="post" id="post-<?php echo $article['article_id']; ?>">
        <div class="header">
          <div class="profile">
            <div class="profile-pic"></div>
            <span class="username"><?php echo htmlspecialchars($article['username']); ?></span>
          </div>
        </div>

        <div class="post-details">
          <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="Publication" class="post-image">
          <h1><?php echo htmlspecialchars($article['title']); ?></h1>
          <i class="meta">Publié le <?php echo date("d F Y", strtotime($article['created_at'])); ?></i>
          <p class="content"><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
        </div>

        <!-- Boutons d'interaction -->
        <div class="action">
          <?php if ($isLoggedIn): ?>
            <button class="like-btn" data-article-id="<?php echo $article['article_id']; ?>">🤍</button>
            <span class="like-animation">❤️</span>
            <button class="comment-btn">💬</button>
            <button class="share-btn">🔗</button>
          <?php else: ?>
            <p><a href="login_reister.php">Inscrivez-vous</a> pour interagir.</p>
          <?php endif; ?>
        </div>

        <h2>Commentaires</h2>
        <div class="comments-section">
          <?php
            $commentsStmt = $pdo->prepare($commentsQuery);
            $commentsStmt->execute(['article_id' => $article['article_id']]);
            $comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($comments as $comment):
          ?>
          <div class="comment">
            <span class="comment-author"><?php echo htmlspecialchars($comment['username']); ?> :</span>
            <span class="comment-text"><?php echo htmlspecialchars($comment['content']); ?></span>
            <?php if ($isLoggedIn && $comment['user_id'] == $currentUserId): ?>
              <button class="delete-comment" data-comment-id="<?php echo $comment['comment_id']; ?>">Supprimer</button>
              <button class="reply-comment" data-comment-id="<?php echo $comment['comment_id']; ?>">Répondre</button>
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Formulaire pour ajouter un commentaire -->
        <div class="comment-box">
          <?php if ($isLoggedIn): ?>
            <textarea id="comment-text-<?php echo $article['article_id']; ?>" placeholder="Écrire votre commentaire..."></textarea>
            <button class="submit-comment" data-article-id="<?php echo $article['article_id']; ?>">Publier</button>
          <?php else: ?>
            <p><a href="login_reister.php">Inscrivez-vous</a> pour commenter.</p>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <script>
    document.addEventListener('click', function (e) {
      // Like
      if (e.target.classList.contains('like-btn')) {
        const articleId = e.target.getAttribute('data-article-id');
        if (!<?php echo json_encode($isLoggedIn); ?>) {
          alert('Vous devez être connecté pour aimer un article.');
          return;
        }

        const likeButton = e.target;
        likeButton.classList.toggle('liked');
        likeButton.textContent = likeButton.classList.contains('liked') ? '❤️' : '🤍';

        // Logique pour ajouter un like dans la base de données
        fetch('like_article.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ article_id: articleId })
        });
      }

      // Commentaire
      if (e.target.classList.contains('submit-comment')) {
        const articleId = e.target.getAttribute('data-article-id');
        const commentText = document.getElementById('comment-text-' + articleId).value.trim();
        if (!commentText) return;

        fetch('comment_article.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ article_id: articleId, content: commentText })
        })
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            alert(data.error);
          } else {
            const newComment = document.createElement('div');
            newComment.className = 'comment';
            newComment.innerHTML = `
              <span class="comment-author">Vous :</span>
              <span class="comment-text">${data.content}</span>
            `;
            document.querySelector(`#post-${articleId} .comments-section`).appendChild(newComment);
          }
        });
      }
    });
  </script>
</body>
</html>
