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

        /* Navigation style 2016-2017 */
        .ui.inverted.menu {
            border-radius: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #667eea !important;
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
