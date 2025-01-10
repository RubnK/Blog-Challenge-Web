<h1>Catégorie : <?= $viewData['category']['name'] ?></h1>

<div class="container">
    <?php if (count($viewData['articles']) > 0): ?>
        <?php foreach ($viewData['articles'] as $article): ?>
            <div class="article">
                <img src="<?= '/uploads/'.$article['image'] ?? 'https://via.placeholder.com/300x200' ?>" alt="<?= $article['title'] ?>">
                <div class="content">
                    <h2><?= $article['title'] ?></h2>
                    <p><strong>Publié le :</strong> <?= $article['created_at'] ?></p>
                    <p><?= substr($article['content'], 0, 200) ?>...</p>
                    <a href="article?article_id=<?= $article['article_id'] ?>">Lire plus</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun article trouvé pour cette catégorie.</p>
    <?php endif; ?>
</div>
</body>
</html>