<h1>Connexion</h1>
<form id="login-form" method="POST" class="active">
    <input type="text" name="identifier" placeholder="Adresse e-mail ou nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
    <?php if (isset($error)) : ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
</form>
<p>Pas encore de compte ? <a href="/register">Inscrivez-vous</a></p>