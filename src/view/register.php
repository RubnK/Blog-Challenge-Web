<h1>Inscription</h1>
<form id = "register-form" method = "POST" class = "active">
    <label for = "username">Nom d'utilisateur :</label><br>
    <input type = "text" name = "username" placeholder = "Utilisateur">
    <label for = "email">Adresse e-mail :</label><br>
    <input type = "email" name = "email" placeholder = "utilisateur@mail.fr">
    <label for = "password">Mot de passe :</label><br>
    <input type = "password" name = "password" placeholder = "********">
    <button type = "submit">S'inscrire</button>
    <?php if (isset($viewData['error'])) : ?>
        <p style = "color: red;"><?= $viewData['error'] ?></p>
    <?php endif; ?>
    <br>
    <p>Déjà un compte ? <a href = "/login">Connectez-vous</a></p>
</form>