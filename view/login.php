<?php
// Récupérer les données
$error = $error ?? null;
?>


<div class="login-container">
    <div class="login-box">
        <!-- Header -->
        <div class="login-header">
            <div class="icon-wrapper">
                <i class="user icon"></i>
            </div>
            <h2>Connexion</h2>
            <div class="sub header">Connectez-vous à votre compte Observer</div>
        </div>

        <!-- Error Message -->
        <?php if ($error): ?>
        <div class="ui negative message error-message">
            <i class="close icon"></i>
            <div class="header">
                Erreur de connexion
            </div>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="/login" method="POST" class="login-form">

            <div class="field">
                <label for="username">Nom d'utilisateur</label>
                <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" name="username" id="username" placeholder="Entrez votre nom d'utilisateur" required autofocus>
                </div>
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <div class="ui left icon input">
                    <i class="lock icon"></i>
                    <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required>
                </div>
            </div>

            <button type="submit" class="ui fluid submit button">
                <i class="sign in icon"></i> Se connecter
            </button>

        </form>

        <!-- Footer -->
        <div class="login-footer">
            <p>
                Pas encore de compte ?
                <a href="/register">Inscrivez-vous</a>
            </p>
        </div>

    </div>
</div>
