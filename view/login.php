<?php
// Récupérer les données
$error = $error ?? null;
?>

<style>
    /* Style vintage 2016-2017 avec gradient et ombres */
    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: -40px -15px;
        padding: 40px 15px;
    }

    .login-box {
        background: white;
        border-radius: 8px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        padding: 40px;
        width: 100%;
        max-width: 420px;
        position: relative;
        overflow: hidden;
    }

    .login-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-header .icon-wrapper {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .login-header .icon-wrapper i {
        color: white;
        font-size: 2.5em;
        margin: 0;
    }

    .login-header h2 {
        color: #333;
        font-weight: 300;
        font-size: 1.8em;
        margin-bottom: 5px;
    }

    .login-header .sub.header {
        color: #888;
        font-size: 0.95em;
    }

    .login-form .field {
        margin-bottom: 20px;
    }

    .login-form .field label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
        font-size: 0.9em;
    }

    .login-form .ui.input {
        width: 100%;
    }

    .login-form .ui.input input {
        border-radius: 4px;
        border: 2px solid #e0e0e0;
        padding: 12px 15px 12px 40px;
        font-size: 1em;
        transition: all 0.3s ease;
    }

    .login-form .ui.input input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .login-form .ui.input i {
        left: 12px;
        color: #999;
        opacity: 0.7;
    }

    .login-form .submit.button {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 4px;
        padding: 15px;
        font-size: 1.1em;
        font-weight: 500;
        border: none;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .login-form .submit.button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    .login-form .submit.button:active {
        transform: translateY(0);
    }

    .login-footer {
        text-align: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .login-footer a {
        color: #667eea;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s;
    }

    .login-footer a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .error-message {
        margin-bottom: 20px;
    }

    .ui.negative.message {
        border-radius: 4px;
        border-left: 4px solid #db2828;
    }
</style>

<div class="login-container">
    <div class="login-box">
        <!-- Header -->
        <div class="login-header">
            <div class="icon-wrapper">
                <i class="user icon"></i>
            </div>
            <h2\u003eConnexion</h2>
            <div class="sub header"\u003eConnectez-vous à votre compte Observer</div>
        </div>

        <!-- Error Message -->
        <?php if ($error): ?>
        <div class="ui negative message error-message">
            <i class="close icon"></i>
            <div class="header"\u003e
                Erreur de connexion
            </div>
            <p\u003e<?= htmlspecialchars($error) ?></p>
        </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="/login" method="POST" class="login-form"\u003e

            <div class="field"\u003e
                <label for="username"\u003eNom d'utilisateur</label\u003e
                <div class="ui left icon input"\u003e
                    <i class="user icon"></i\u003e
                    <input type="text" name="username" id="username" placeholder="Entrez votre nom d'utilisateur" required autofocus\u003e
                </div\u003e
            </div\u003e

            <div class="field"\u003e
                <label for="password"\u003eMot de passe</label\u003e
                <div class="ui left icon input"\u003e
                    <i class="lock icon"></i\u003e
                    <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required\u003e
                </div\u003e
            </div\u003e

            <button type="submit" class="ui fluid submit button"\u003e
                <i class="sign in icon"></i\u003e Se connecter
            </button\u003e

        </form\u003e

        <!-- Footer -->
        <div class="login-footer"\u003e
            <p\u003e
                Pas encore de compte ?
                <a href="/register">Inscrivez-vous</a\u003e
            </p\u003e
        </div\u003e

    </div\u003e
</div\u003e
