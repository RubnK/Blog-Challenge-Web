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
    exit();
}

// Supposons que l'utilisateur est connecté et que vous avez son ID
$userId = 1; // Remplacez par l'ID de l'utilisateur connecté

// Récupérer les articles publiés par l'utilisateur
$query = "SELECT a.title, a.content, a.image, a.created_at 
          FROM articles a
          JOIN users u ON a.user_id = u.user_id
          WHERE u.user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();

// Récupérer les résultats
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
        </div>
        <button>Modifier le profil</button>
    </div>

    <div class="articles">
        <h2>Articles publiés</h2>
        <?php foreach ($articles as $article): ?>
            <div class="article">
                <img src="path/to/article-thumbnail.jpg" alt="Image">
                <div class="content">
                    <h3><?= htmlspecialchars($article['title']) ?></h3>
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
