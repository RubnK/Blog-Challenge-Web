<div class="container">
  <a href="/category?id=<?= $viewData['article']['category_id'] ?>" class="back-link">← Retour à la liste des articles</a>

  <div class="post" id="post-<?php echo $viewData['article']['article_id']; ?>">
    <div class="header">
      <div class="profile">
        <div class="profile-pic"></div>
        <span class="username"><?php echo $viewData['article']['username']; ?></span>
      </div>
    </div>

    <div class="post-details">
      <img src="/uploads/<?= $viewData['article']['post_image']; ?>" alt="Publication" class="post-image">
      <h1><?php echo $viewData['article']['title']; ?></h1>
      <i class="meta">Publié le <?php echo date("d/m/y à H:i", strtotime($viewData['article']['posted_at'])); ?></i>
      <p class="content"><?php echo nl2br($viewData['article']['content']); ?></p>
    </div>

    <!-- Boutons d'interaction -->
    <div class="action">
      <?php if (isset($_SESSION['user'])): ?>
        <button class="like-btn" data-article-id="<?php echo $article['article_id']; ?>">🤍</button>
        <span class="like-animation">❤</span>
        <button class="comment-btn">💬</button>
        <button class="share-btn">🔗</button>
      <?php else: ?>
        <p><a href="login_reister.php">Inscrivez-vous</a> pour interagir.</p>
      <?php endif; ?>
    </div>

    <h2>Commentaires</h2>
    <div class="comments-section">
      <?php
        foreach ($viewData['comments'] as $comment):
      ?>
      <div class="comment">
        <span class="comment-author"><?php echo $comment['username']; ?> :</span>
        <span class="comment-text"><?php echo $comment['content']; ?></span>
        <?php if (isset($_SESSION['user']) && $comment['user_id'] == $_SESSION['user']): ?>
          <button class="delete-comment" data-comment-id="<?php echo $comment['comment_id']; ?>">Supprimer</button>
          <button class="reply-comment" data-comment-id="<?php echo $comment['comment_id']; ?>">Répondre</button>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Formulaire pour ajouter un commentaire -->
    <div class="comment-box">
      <?php if (isset($_SESSION['user'])): ?>
        <textarea id="comment-text-<?php echo $article['article_id']; ?>" placeholder="Écrire votre commentaire..."></textarea>
        <button class="submit-comment" data-article-id="<?php echo $article['article_id']; ?>">Publier</button>
      <?php else: ?>
        <p><a href="login_reister.php">Inscrivez-vous</a> pour commenter.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  document.addEventListener('click', function (e) {
    // Like
    if (e.target.classList.contains('like-btn')) {
      const articleId = e.target.getAttribute('data-article-id');
      if (<?= !isset($_SESSION['user']) ?>) {
        alert('Vous devez être connecté pour aimer un article.');
        return;
      }

      const likeButton = e.target;
      likeButton.classList.toggle('liked');
      likeButton.textContent = likeButton.classList.contains('liked') ? '❤' : '🤍';

    }
  });
</script>