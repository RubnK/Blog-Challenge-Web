<h1>Connexion</h1>
<form id="login-form" method="POST" class="active">
    <label for="identifier">Adresse e-mail ou nom d'utilisateur :</label><br>
    <input type="text" name="identifier" placeholder="utilisateur@mail.fr">
    <label for="password">Mot de passe :</label><br>
    <input type="password" name="password" placeholder="********">
    <button type="submit">Se connecter</button>
    <?php if (isset($viewData['error'])) : ?>
        <p style="color: red;"><?= $viewData['error'] ?></p>
    <?php endif; ?>
    <br>
    <p>Pas encore de compte ? <a href="/register">Inscrivez-vous</a></p>
</form>