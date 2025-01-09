<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un article</title>
</head>
<body>
    <h1>Créer un nouvel article</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Titre :</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="content">Contenu :</label><br>
        <textarea id="content" name="content" required></textarea><br><br>

        <label for="image">Image :</label><br>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <label for="category">Catégorie :</label><br>
        <select id="category" name="category" required>
            <?php foreach ($viewData['categories'] as $category): ?>
                <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Créer l'article</button>
    </form>
</body>
</html>