<h1>Inscription</h1>
<form id = "register-form" method = "POST" class = "active">
    <input type = "text" name = "username" placeholder = "Nom d'utilisateur">
    <input type = "email" name = "email" placeholder = "Adresse e-mail">
    <input type = "password" name = "password" placeholder = "Mot de passe">
    <button type = "submit">S'inscrire</button>
    <?php if (isset($viewData['error'])) : ?>
        <p style = "color: red;"><?= $viewData['error'] ?></p>
    <?php endif; ?>
</form>
<p>Déjà un compte ? <a href = "/login">Connectez-vous</a></p>