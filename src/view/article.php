<div class="container">
  <a href="/category?id=<?= $viewData['article']['category_id'] ?>" class="back-link">← Retour à la liste des articles</a>

  <div class="post" id="post-<?php echo $viewData['article']['article_id']; ?>">
    <div class="header">
      <div class="profile">
        <div class="profile-pic"><img src="/uploads/user.png"></div>
        <a href="/profil?id=<?= $viewData['article']['user_id'] ?>" class="username"><?php echo $viewData['article']['username']; ?></a>
      </div>
    </div>

    <div class="post-details">
      <img src="/uploads/<?= $viewData['article']['post_image']; ?>" alt="Publication" class="post-image">
      <h1><?php echo $viewData['article']['title']; ?></h1>
      <p>Aimé <?= $viewData['likesCount']['count']; ?> fois</p>
      <i class="meta">Publié le <?php echo date("d/m/y à H:i", strtotime($viewData['article']['posted_at'])); ?></i>
      <?= $viewData['article']['content']; ?>
    </div>

    <!-- Boutons d'interaction -->
    <div class="action">
      <?php if (isset($_SESSION['user'])): ?>
        <form method="post" class="like-form" id="like-form">
          <input type="hidden" name="like" value="1">
          <button type="submit" class="like-btn">🤍</button>
        </form>
      <?php else: ?>
        <p><a href="/register">Inscrivez-vous</a> pour interagir.</p>
      <?php endif; ?>
    </div>
    <div class="commentaires">
    <h2>Commentaires</h2>
    
    <?php if (isset($_SESSION['user'])){ ?>
        <form method="post" class="comment-form" id="comment-form">
          <input type="hidden" name="comment" value="1">
          <input type="hidden" name="article_id" value="<?php echo $viewData['article']['article_id']; ?>">
          <textarea name="content" id="comment-text-<?php echo $viewData['article']['article_id']; ?>" placeholder="Écrire votre commentaire..."></textarea>
          <button type="submit" class="submit-comment">Publier</button>
        </form>
      <?php }else{ ?>
        <p><a href="/register">Inscrivez-vous</a> pour commenter.</p>
      <?php } ?>

    <div class="comments-section">
      <?php
        foreach ($viewData['comments'] as $comment):
      ?>
      <div class="comment">
        <h3 class="comment-author"><?php echo $comment['username']; ?>:</h3><br>
        <p class="comment-text"><?php echo $comment['content']; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    </div>

  </div>
</div>