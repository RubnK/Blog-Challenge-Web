<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        .profile-header .info {
            flex-grow: 1;
            margin-left: 20px;
        }

        .articles {
            padding: 20px;
        }

        .article {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .article img {
            width: 80px;
            height: 80px;
            margin-right: 20px;
            background-color: #ddd;
        }

        .article .content {
            flex-grow: 1;
        }

        .article .actions {
            text-align: right;
        }

        .actions i {
            margin-right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="profile-header">
        <img src="path/to/default-avatar.jpg" alt="Photo de profil">
        <div class="info">
            <h1>Nom utilisateur</h1>
            <p>Inscrit le : date d'inscription</p>
            <?= $viewData['user']['email'] ?>
        </div>
        <button>Modifier le profil</button>
    </div>

    <div class="articles">
        <h2>Articles publiés</h2>
        <?php foreach ($viewData['userArticles'] as $article): ?>
            <div class="article">
                <img src="/uploads/<?= $article['image'] ?>" alt="Image de l'article">
                <div class="content">
                    <h3><?= $article['title'] ?></h3>
                    <p><?= htmlspecialchars($article['content']) ?></p>
                    <p><small>Publié le : <?= htmlspecialchars($article['created_at']) ?></small></p>
                </div>
                <div class="actions">
                    <i>👁</i> <i>❤️</i> <i>↗️</i>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
