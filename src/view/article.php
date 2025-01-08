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

// Récupérer les articles depuis la base de données
$articlesQuery = "SELECT a.article_id, a.title, a.content, a.created_at, u.username, a.image 
                  FROM articles a
                  JOIN users u ON a.user_id = u.user_id
                  ORDER BY a.created_at DESC";
$articlesStmt = $pdo->query($articlesQuery);
$articles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);

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
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <?php foreach ($articles as $article): ?>
    <div class="post" id="post-<?php echo $article['article_id']; ?>">
      <div class="header">
        <div class="profile">
          <div class="profile-pic" id="profile-pic"></div>
          <span class="username"><?php echo htmlspecialchars($article['username']); ?></span>
        </div>
      </div>

      <div class="post-details">
        <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="Publication" class="post-image">
        <h1><?php echo htmlspecialchars($article['title']); ?></h1>
        <i class="meta">Publié le <?php echo date("d F Y", strtotime($article['created_at'])); ?></i>
        <p class="content"><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>

        <!-- Bouton de suppression (si l'utilisateur est le propriétaire de l'article) -->
        <button class="delete-post-btn">🗑️</button>
      </div>

      <!-- Boutons d'interaction -->
      <div class="action">
        <button class="like-btn" data-article-id="<?php echo $article['article_id']; ?>">🤍</button>
        <span class="like-animation">❤️</span>
        <button class="comment-btn">💬</button>
        <button class="share-btn">🔗</button>
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
          <div class="profile-pic" style="background-color: #FFAA00;"></div>
          <span class="comment-author"><?php echo htmlspecialchars($comment['username']); ?> :</span>
          <span class="comment-text"><?php echo htmlspecialchars($comment['content']); ?></span>
          <div class="actions">
            <button class="reply-btn">Répondre</button>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- Formulaire pour ajouter un commentaire -->
      <div class="comment-box">
        <textarea id="comment-text-<?php echo $article['article_id']; ?>" placeholder="Écrire votre commentaire..."></textarea>
        <button class="submit-comment" data-article-id="<?php echo $article['article_id']; ?>">Publier</button>
      </div>

    </div>
    <?php endforeach; ?>
  </div>

  <script>
    // Gestion des interactions de la publication (Like, Commentaire)
    document.addEventListener('click', function (e) {
      // Like
      if (e.target.classList.contains('like-btn')) {
        const articleId = e.target.getAttribute('data-article-id');
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
        if (commentText) {
          fetch('comment_article.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ article_id: articleId, content: commentText })
          })
          .then(response => response.json())
          .then(data => {
            const newComment = document.createElement('div');
            newComment.className = 'comment';
            newComment.innerHTML = `<div class="profile-pic" style="background-color: #77DD77;"></div>
                                    <span class="comment-author">Vous :</span>
                                    <span class="comment-text">${data.content}</span>
                                    <div class="actions">
                                      <button class="reply-btn">Répondre</button>
                                    </div>`;
            document.querySelector(`#post-${articleId} .comments-section`).appendChild(newComment);
          });
        }
      }
    });
  </script>
</body>
</html>
