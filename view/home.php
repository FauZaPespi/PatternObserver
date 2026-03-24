<?php
$isAuthenticated = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'];
$username = $_SESSION['username'] ?? null;
?>

<!-- Hero Section -->
<div class="ui vertical masthead center aligned segment" style="background-color: #1DA1F2; padding: 80px 0; margin: -20px -15px 40px;">
    <div class="ui text container">
        <h1 class="ui inverted header" style="font-size: 3em; font-weight: 300; margin-bottom: 20px;">
            <i class="eye icon"></i>
            Observer
        </h1>

        <p class="ui inverted header" style="font-size: 1.3em; font-weight: 300; opacity: 0.9;">
            Un système de publication/abonnement moderne
        </p>

        <?php if (!$isAuthenticated): ?>
            <div style="margin-top: 30px;">
                <a href="/register" class="ui huge inverted button" style="margin-right: 10px;">
                    <i class="user plus icon"></i> S'inscrire
                </a>
                <a href="/login" class="ui huge inverted button">
                    <i class="sign in icon"></i> Se connecter
                </a>
            </div>
        <?php else: ?>
            <div style="margin-top: 30px;">
                <div class="ui inverted segment" style="background: rgba(255,255,255,0.1); display: inline-block; padding: 20px 40px;">
                    <i class="check circle icon"></i>
                    Bienvenue, <strong><?= htmlspecialchars($username) ?></strong> !
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Features Section -->
<div class="ui three column stackable grid">
    <div class="column">
        <div class="ui card" style="width: 100%; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <div class="content">
                <i class="right floated big blue eye icon"></i>
                <div class="header">Pattern Observer</div>
                <div class="description">
                    <p>Système de notification où les abonnés reçoivent automatiquement les mises à jour des publications.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="column">
        <div class="ui card" style="width: 100%; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <div class="content">
                <i class="right floated big purple users icon"></i>
                <div class="header">Gestion des utilisateurs</div>
                <div class="description">
                    <p>Système d'authentification complet avec MariaDB, sessions sécurisées et gestion des utilisateurs.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="column">
        <div class="ui card" style="width: 100%; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <div class="content">
                <i class="right floated big teal server icon"></i>
                <div class="header">Architecture moderne</div>
                <div class="description">
                    <p>PHP 8.5, Slim Framework 4, MariaDB, Docker, Semantic UI - une stack moderne et performante.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thread Demo Section -->
<div class="ui segment" style="margin-top: 40px;">
    <h2 class="ui dividing header">
        <i class="rss icon"></i>
        <div class="content">
            Démonstration du Pattern Observer
            <div class="sub header">Exemple d'utilisation du système de publication/abonnement</div>
        </div>
    </h2>

    <div class="ui relaxed divided list">
        <div class="item">
            <i class="large middle aligned broadcast tower icon"></i>
            <div class="content">
                <div class="header">Publisher</div>
                <div class="description">Diffuse les nouvelles à tous les abonnés</div>
            </div>
        </div>

        <div class="item">
            <i class="large middle aligned user icon"></i>
            <div class="content">
                <div class="header">Subscribers</div>
                <div class="description">Reçoivent les notifications automatiquement</div>
            </div>
        </div>

        <div class="item">
            <i class="large middle aligned sync icon"></i>
            <div class="content">
                <div class="header">Mise à jour en temps réel</div>
                <div class="description">Les abonnés sont notifiés instantanément des nouvelles publications</div>
            </div>
        </div>
    </div>

    <?php if ($isAuthenticated): ?>
        <div style="margin-top: 20px;">
            <button class="ui primary button" onclick="alert('Fonctionnalité à venir !')">
                <i class="bell icon"></i> S'abonner aux notifications
            </button>

            <button class="ui button" onclick="alert('Fonctionnalité à venir !')">
                <i class="newspaper icon"></i> Publier une news
            </button>
        </div>
    <?php else: ?>
        <div class="ui info message">
            <i class="info circle icon"></i>
            <div class="content">
                <div class="header">Connectez-vous pour interagir</div>
                <p>Connectez-vous ou inscrivez-vous pour vous abonner aux notifications et publier des news.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Stats Section -->
<div class="ui three statistics" style="margin-top: 40px;">
    <div class="statistic">
        <div class="value">
            <i class="users icon"></i>
            <?php
            // Compter les utilisateurs (si connecté)
            if ($isAuthenticated) {
                try {
                    $users = \Makosc\Observer\Models\UserManager::getAllUsers();
                    echo count($users);
                } catch (\Exception $e) {
                    echo '?';
                }
            } else {
                echo '?';
            }
            ?>
        </div>
        <div class="label">Utilisateurs</div>
    </div>

    <div class="statistic">
        <div class="value">
            <i class="rss icon"></i> 0
        </div>
        <div class="label">Abonnements</div>
    </div>

    <div class="statistic">
        <div class="value">
            <i class="newspaper icon"></i> 0
        </div>
        <div class="label">Publications</div>
    </div>
</div>
