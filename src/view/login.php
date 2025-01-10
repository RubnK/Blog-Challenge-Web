<h1>Connexion</h1>
<form id="login-form" method="POST" class="active">
    <input type="text" name="identifier" placeholder="Adresse e-mail ou nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
    <?php if (isset($viewData['error'])) : ?>
        <p style="color: red;"><?= $viewData['error'] ?></p>
    <?php endif; ?>
</form>
<p>Pas encore de compte ? <a href="/register">Inscrivez-vous</a></p>