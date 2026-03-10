<?php
// Récupérer les données
$error = $error ?? null;
?\>

<style\>
    /* Style vintage 2016-2017 avec gradient et ombres */
    .register-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: -40px -15px;
        padding: 40px 15px;
    }

    .register-box {
        background: white;
        border-radius: 8px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        padding: 40px;
        width: 100%;
        max-width: 420px;
        position: relative;
        overflow: hidden;
    }

    .register-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
    }

    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .register-header .icon-wrapper {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #764ba2 0%, #f093fb 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 4px 15px rgba(118, 75, 162, 0.4);
    }

    .register-header .icon-wrapper i {
        color: white;
        font-size: 2.5em;
        margin: 0;
    }

    .register-header h2 {
        color: #333;
        font-weight: 300;
        font-size: 1.8em;
        margin-bottom: 5px;
    }

    .register-header .sub.header {
        color: #888;
        font-size: 0.95em;
    }

    .register-form .field {
        margin-bottom: 20px;
    }

    .register-form .field label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
        font-size: 0.9em;
    }

    .register-form .ui.input {
        width: 100%;
    }

    .register-form .ui.input input {
        border-radius: 4px;
        border: 2px solid #e0e0e0;
        padding: 12px 15px 12px 40px;
        font-size: 1em;
        transition: all 0.3s ease;
    }

    .register-form .ui.input input:focus {
        border-color: #764ba2;
        box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.1);
    }

    .register-form .ui.input i {
        left: 12px;
        color: #999;
        opacity: 0.7;
    }

    .register-form .submit.button {
        background: linear-gradient(135deg, #764ba2 0%, #f093fb 100%);
        color: white;
        border-radius: 4px;
        padding: 15px;
        font-size: 1.1em;
        font-weight: 500;
        border: none;
        box-shadow: 0 4px 15px rgba(118, 75, 162, 0.4);
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .register-form .submit.button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(118, 75, 162, 0.5);
    }

    .register-form .submit.button:active {
        transform: translateY(0);
    }

    .register-footer {
        text-align: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .register-footer a {
        color: #764ba2;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s;
    }

    .register-footer a:hover {
        color: #667eea;
        text-decoration: underline;
    }

    .error-message {
        margin-bottom: 20px;
    }

    .ui.negative.message {
        border-radius: 4px;
        border-left: 4px solid #db2828;
    }
</style\>

<div class="register-container"\>
    <div class="register-box"\>
        <!-- Header --\>
        <div class="register-header"\>
            <div class="icon-wrapper"\>
                <i class="user plus icon"></i\>
            </div\>
            <h2\u003eCréer un compte</h2\>
            <div class="sub header"\u003eRejoignez Observer dès aujourd'hui</div\>
        </div\>

        <!-- Error Message --\>
        <?php if ($error): ?\>
        <div class="ui negative message error-message"\>
            <i class="close icon"></i\>
            <div class="header"\u003e
                Erreur d'inscription
            </div\>
            <p\u003e<?= htmlspecialchars($error) ?\></p\>
        </div\>
        <?php endif; ?\>

        <!-- Register Form --\>
        <form action="/register" method="POST" class="register-form"\u003e

            <div class="field"\u003e
                <label for="username"\u003eNom d'utilisateur</label\u003e
                <div class="ui left icon input"\u003e
                    <i class="user icon"></i\u003e
                    <input type="text" name="username" id="username" placeholder="Choisissez un nom d'utilisateur" required autofocus minlength="3" maxlength="50"\u003e
                </div\u003e
            </div\u003e

            <div class="field"\u003e
                <label for="password"\u003eMot de passe</label\u003e
                <div class="ui left icon input"\u003e
                    <i class="lock icon"></i\u003e
                    <input type="password" name="password" id="password" placeholder="Choisissez un mot de passe" required minlength="6"\u003e
                </div\u003e
                <small style="color: #888;"\u003eMinimum 6 caractères</small\u003e
            </div\u003e

            <div class="field"\u003e
                <label for="password_confirm"\u003eConfirmer le mot de passe</label\u003e
                <div class="ui left icon input"\u003e
                    <i class="lock icon"></i\u003e
                    <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirmez votre mot de passe" required\u003e
                </div\u003e
            </div\u003e

            <button type="submit" class="ui fluid submit button"\u003e
                <i class="user plus icon"></i\u003e S'inscrire
            </button\u003e

        </form\u003e

        <!-- Footer --\>
        <div class="register-footer"\u003e
            <p\u003e
                Déjà inscrit ?
                <a href="/login">Connectez-vous</a\u003e
            </p\u003e
        </div\u003e

    </div\u003e
</div\u003e
