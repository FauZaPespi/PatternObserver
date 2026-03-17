<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Observer') ?></title>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.3/dist/semantic.min.css">

    <style>
        /* CSS Flexbox pour garder le footer en bas de la page */
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f4f6f8;
        }

        /* Conteneur principal qui prend tout l'espace restant */
        main {
            flex: 1;
            padding-top: 20px;
            padding-bottom: 40px;
        }

        /* Ajustement de la marge du footer */
        .ui.footer.segment {
            margin-top: auto;
        }

        /* Navigation style 2017 Twitter */
        .ui.inverted.menu {
            border-radius: 0;
            background: #1DA1F2;
        }

        .ui.inverted.menu .item {
            color: rgba(255,255,255,0.9);
        }

        .ui.inverted.menu .item:hover {
            background: rgba(255,255,255,0.15);
            color: white;
        }

        .ui.inverted.menu .active.item {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        /* Messages flash */
        .flash-messages {
            margin-bottom: 20px;
        }

        .ui.message {
            margin-bottom: 10px;
        }

        /* User dropdown in nav */
        .ui.inverted.menu .ui.dropdown .menu {
            background: white;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .ui.inverted.menu .ui.dropdown .menu > .item {
            color: #333 !important;
        }

        .ui.inverted.menu .ui.dropdown .menu > .item:hover {
            background: #f4f6f8 !important;
            color: #1DA1F2 !important;
        }

        /* ---- Auth card layout ---- */
        .login-container,
        .register-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 40px;
        }

        .login-box,
        .register-box {
            background: #ffffff;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        .login-header,
        .register-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: #E8F5FE;
            border-radius: 50%;
            margin-bottom: 12px;
        }

        .icon-wrapper i {
            color: #1DA1F2;
            font-size: 1.5em;
            margin: 0;
        }

        .login-header h2,
        .register-header h2 {
            color: #14171A;
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .login-header .sub.header,
        .register-header .sub.header {
            color: #657786;
            font-size: 0.9rem;
        }

        .login-form .field,
        .register-form .field {
            margin-bottom: 16px;
        }

        .login-form label,
        .register-form label {
            color: #14171A;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .login-footer,
        .register-footer {
            text-align: center;
            margin-top: 20px;
            color: #657786;
            font-size: 0.9rem;
            border-top: 1px solid #E1E8ED;
            padding-top: 16px;
        }

        .login-footer a,
        .register-footer a {
            color: #1DA1F2;
            font-weight: 600;
            text-decoration: none;
        }

        .login-footer a:hover,
        .register-footer a:hover {
            text-decoration: underline;
        }

        .error-message {
            margin-bottom: 16px !important;
        }

        /* Override Semantic UI button to match 2017 Twitter style */
        .login-form .ui.fluid.submit.button,
        .register-form .ui.fluid.submit.button {
            background-color: #1DA1F2 !important;
            color: #ffffff !important;
            border-radius: 4px !important;
            font-weight: 700;
            letter-spacing: 0.3px;
            padding: 12px;
            margin-top: 8px;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }

        .login-form .ui.fluid.submit.button:hover,
        .register-form .ui.fluid.submit.button:hover {
            background-color: #1a91da !important;
        }

        /* ---- Profile page ---- */
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 40px;
        }

        .profile-card {
            background: #ffffff;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
        }

        .profile-header {
            text-align: center;
            padding: 32px 40px 24px;
        }

        .profile-header h2 {
            color: #14171A;
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0 0 8px;
        }

        .profile-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
            color: #657786;
            font-size: 0.875rem;
        }

        .profile-meta i {
            margin-right: 4px;
        }

        .profile-divider {
            height: 1px;
            background: #E1E8ED;
        }

        .profile-section {
            padding: 24px 40px;
        }

        .profile-section-title {
            color: #14171A;
            font-size: 0.95rem;
            font-weight: 700;
            margin: 0 0 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-form .field {
            margin-bottom: 16px;
        }

        .profile-form label {
            color: #14171A;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .optional-label {
            color: #657786;
            font-weight: 400;
            font-size: 0.8rem;
        }

        .profile-form .ui.fluid.submit.button {
            background-color: #1DA1F2 !important;
            color: #ffffff !important;
            border-radius: 4px !important;
            font-weight: 700;
            letter-spacing: 0.3px;
            padding: 12px;
            margin-top: 8px;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }

        .profile-form .ui.fluid.submit.button:hover {
            background-color: #1a91da !important;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="ui inverted menu">
        <div class="ui container">
            <a href="/" class="header item">
                <i class="eye icon"></i>
                <b>Observer</b>
            </a>

            <div class="right menu">
                <?php if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated']): ?>
                    <!-- Menu utilisateur connecté -->
                    <div class="ui dropdown item">
                        <i class="user circle icon"></i>
                        <?= htmlspecialchars($_SESSION['username'] ?? 'Utilisateur') ?>
                        <i class="dropdown icon"></i>

                        <div class="menu">
                            <div class="header">Mon compte</div>
                            <a href="/profile" class="item">
                                <i class="id card icon"></i> Profil
                            </a>
                            <div class="divider"></div>
                            <a href="/logout" class="item">
                                <i class="sign out icon"></i> Déconnexion
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Menu visiteur -->
                    <a href="/login" class="item">
                        <i class="sign in icon"></i> Connexion
                    </a>
                    <a href="/register" class="item">
                        <i class="user plus icon"></i> Inscription
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <main class="ui container">
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="flash-messages">
                <?php
                $flashType = $_SESSION['flash_type'] ?? 'info';
                $messageClasses = [
                    'success' => 'positive',
                    'error' => 'negative',
                    'warning' => 'warning',
                    'info' => 'info',
                ];
                $messageClass = $messageClasses[$flashType] ?? 'info';
                ?>
                <div class="ui <?= $messageClass ?> message">
                    <i class="close icon"></i>
                    <div class="header">
                        <?= $flashType === 'success' ? 'Succès' : ($flashType === 'error' ? 'Erreur' : 'Information') ?>
                    </div>
                    <p><?= htmlspecialchars($_SESSION['flash_message']) ?></p>
                </div>
            </div>
            <?php
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
            ?>
        <?php endif; ?>

        <?= $content ?? '' ?>
    </main>

    <footer class="ui inverted vertical footer segment">
        <div class="ui center aligned container">
            <div class="ui horizontal inverted small divided link list">
                <span class="item">
                    Observer &copy; <?= date("Y") == "2026" ? date("Y") : "2026 - " . date("Y") ?>
                </span>
                <span class="item">Ptytsia Maksym & Calvo Oscar</span>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.3/dist/semantic.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialise automatiquement les menus déroulants
            $('.ui.dropdown').dropdown();

            // Permet de fermer les messages d'alerte (flash messages)
            $('.message .close').on('click', function() {
                $(this).closest('.message').transition('fade');
            });
        });
    </script>
</body>

</html>
