<form id = "register-form" method = "POST" class = "active">
    <input type = "text" name = "username" placeholder = "Nom d'utilisateur" required>
    <input type = "email" name = "email" placeholder = "Adresse e-mail" required>
    <input type = "password" name = "password" placeholder = "Mot de passe" required>
    <button type = "submit">S'inscrire</button>
    <?php if (isset($error)) : ?>
        <p style = "color: red;"><?= $error ?></p>
    <?php endif; ?>
</form>
<p>Déjà un compte ? <a href = "/login">Connectez-vous</a></p>