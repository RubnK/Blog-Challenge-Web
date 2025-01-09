<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'blog';
$user = 'votre_utilisateur';
$password = 'votre_mot_de_passe';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Gestion des requêtes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        // Inscription
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Vérification si l'email existe déjà
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Cet email est déjà utilisé.');</script>";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:name, :email, :password)");
            if ($stmt->execute(['name' => $name, 'email' => $email, 'password' => $password])) {
                echo "<script>alert('Inscription réussie. Veuillez vous connecter.');</script>";
            } else {
                echo "<script>alert('Erreur lors de l\'inscription.');</script>";
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'login') {
        // Connexion
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user'] = $user;
            echo "<script>alert('Connexion réussie. Bienvenue !');</script>";
        } else {
            echo "<script>alert('Identifiants incorrects.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion et Inscription</title>
</head>
<body>
    <div class="container">
        <h1>Bienvenue</h1>
        <div class="toggle-buttons">
            <button onclick="showForm('login')">Connexion</button>
            <button onclick="showForm('register')">Inscription</button>
        </div>

        <form id="login-form" method="POST" class="active">
            <input type="hidden" name="action" value="login">
            <input type="email" name="email" placeholder="Adresse e-mail" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>

        <form id="register-form" method="POST">
            <input type="hidden" name="action" value="register">
            <input type="text" name="name" placeholder="Nom complet" required>
            <input type="email" name="email" placeholder="Adresse e-mail" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>
    </div>

    <script>
        function showForm(formType) {
            document.getElementById('login-form').classList.remove('active');
            document.getElementById('register-form').classList.remove('active');

            if (formType === 'login') {
                document.getElementById('login-form').classList.add('active');
            } else {
                document.getElementById('register-form').classList.add('active');
            }
        }
    </script>
</body>
</html>
