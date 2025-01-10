<div class="profile-header">
    <img src="/uploads/user.png" alt="Photo de profil">
    <div class="info">
        <h1><?= $viewData['user']['username'] ?></h1>
        <p>Inscrit le : <?= date('d/m/y', strtotime($viewData['user']['created_at'])) ?></p>
        <a href="mailto:<?= $viewData['user']['email'] ?>"> <?= $viewData['user']['email'] ?></a>
    </div>
    <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $viewData['user']['user_id']): ?>
    <a href="/logout" class="logout">Déconnexion</a>
    <?php endif; ?>
</div>

<div class="articles">
    <h2>Articles publiés</h2>
    <?php foreach ($viewData['userArticles'] as $article): ?>
        <div class="article">
            <img src="/uploads/<?= $article['image'] ?>" alt="Image de l'article">
            <div class="content">
                <h3><a href="/article?article_id=<?= $article['article_id'] ?>"><?= $article['title'] ?></h3></a>
                <p><?= $article['content'] ?></p>
                <p><small>Publié le : <?= date("d/m/y à H:i", strtotime($article['created_at'])) ?></small></p>
            </div>
            <div class="actions">
                <i>👁</i> <i>❤️</i> <i>↗️</i>
            </div>
        </div>
    <?php endforeach; ?>
</div>