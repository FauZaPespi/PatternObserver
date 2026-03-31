<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'Observer') ?></title>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.3/dist/semantic.min.css">
    <script src="js/notification.js" defer></script>

    <link rel="stylesheet" href="/css/base.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/auth.css">
    <link rel="stylesheet" href="/css/profile.css">

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
                        <a href="/user/<?= urlencode($_SESSION['username'] ?? '') ?>" style="color: inherit; text-decoration: none;">
                            <?= htmlspecialchars($_SESSION['username'] ?? 'Utilisateur') ?>
                        </a>
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
