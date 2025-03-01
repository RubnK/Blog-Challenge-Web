<h1>Les Tendances</h1>

<div class="container">
    <?php if (!empty($viewData['articles'])): ?>
        <?php foreach ($viewData['articles'] as $article): ?>
            <div class="article">
                <img src="<?= '/uploads/'.$article['image'] ?? 'https://via.placeholder.com/300x200' ?>" alt="<?= $article['title'] ?>">
                <div class="content">
                    <h2><?= $article['title'] ?></h2>
                    <p><?= substr($article['content'], 0, 150) ?>...</p>
                    <p>Publié le <?= date('d/m/y', strtotime($article['created_at'])) ?></p>
                    <p>Likes : <?= $article['likes'] ?></p>
                    <a href="article?article_id=<?= $article['article_id'] ?>">Lire plus</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun article disponible pour le moment.</p>
    <?php endif; ?>
</div>