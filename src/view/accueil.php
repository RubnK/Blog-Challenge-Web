<h1>Les Tendances</h1>

<div class="container">
    <?php if (!empty($viewData['articles'])): ?>
        <?php foreach ($viewData['articles'] as $article): ?>
            <div class="article">
                <img src="<?= htmlspecialchars($article['image'] ?? 'https://via.placeholder.com/300x200') ?>" alt="<?= htmlspecialchars($article['title']) ?>">
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
