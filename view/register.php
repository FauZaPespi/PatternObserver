<?php
// Récupérer les données
$error = $error ?? null;
?>

<div class="register-container">
    <div class="register-box">
        <!-- Header -->
        <div class="register-header">
            <div class="icon-wrapper">
                <i class="user plus icon"></i>
            </div>
            <h2>Créer un compte</h2>
            <div class="sub header">Rejoignez Observer dès aujourd'hui</div>
        </div>

        <!-- Error Message -->
        <?php if ($error): ?>
        <div class="ui negative message error-message">
            <i class="close icon"></i>
            <div class="header">
                Erreur d'inscription
            </div>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
        <?php endif; ?>

        <!-- Register Form -->
        <form action="/register" method="POST" class="register-form">

            <div class="field">
                <label for="username">Nom d'utilisateur</label>
                <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input type="text" name="username" id="username" placeholder="Choisissez un nom d'utilisateur" required autofocus minlength="3" maxlength="50">
                </div>
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <div class="ui left icon input">
                    <i class="lock icon"></i>
                    <input type="password" name="password" id="password" placeholder="Choisissez un mot de passe" required minlength="6">
                </div>
                <small style="color: #888;">Minimum 6 caractères</small>
            </div>

            <div class="field">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <div class="ui left icon input">
                    <i class="lock icon"></i>
                    <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirmez votre mot de passe" required>
                </div>
            </div>

            <button type="submit" class="ui fluid submit button">
                <i class="user plus icon"></i> S'inscrire
            </button>

        </form>

        <!-- Footer -->
        <div class="register-footer">
            <p>
                Déjà inscrit ?
                <a href="/login">Connectez-vous</a>
            </p>
        </div>

    </div>
</div>
