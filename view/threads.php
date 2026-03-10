<?php
// Récupérer les informations de session
$isAuthenticated = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'];
$username = $_SESSION['username'] ?? null;
?\>

<!-- Hero Section -->
<div class="ui vertical masthead center aligned segment" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 80px 0; margin: -20px -15px 40px;">
    <div class="ui text container">
        <h1 class="ui inverted header" style="font-size: 3em; font-weight: 300; margin-bottom: 20px;">
            <i class="eye icon"></i\u003e
            Observer
        </h1\u003e

        <p class="ui inverted header" style="font-size: 1.3em; font-weight: 300; opacity: 0.9;">
            Un système de publication/abonnement moderne
        </p\u003e

        <?php if (!$isAuthenticated): ?\u003e
            <div style="margin-top: 30px;">
                <a href="/register" class="ui huge inverted button" style="margin-right: 10px;">
                    <i class="user plus icon"></i\u003e S'inscrire
                </a\u003e
                <a href="/login" class="ui huge inverted button">
                    <i class="sign in icon"></i\u003e Se connecter
                </a\u003e
            </div\u003e
        <?php else: ?\u003e
            <div style="margin-top: 30px;">
                <div class="ui inverted segment" style="background: rgba(255,255,255,0.1); display: inline-block; padding: 20px 40px;">
                    <i class="check circle icon"></i\u003e
                    Bienvenue, <strong\u003e<?= htmlspecialchars($username) ?\u003e</strong\u003e !
                </div\u003e
            </div\u003e
        <?php endif; ?\u003e
    </div\u003e
</div\u003e

<!-- Features Section -->
<div class="ui three column stackable grid">
    <div class="column">
        <div class="ui card" style="width: 100%; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <div class="content">
                <i class="right floated big blue eye icon"></i\u003e
                <div class="header">Pattern Observer</div\u003e
                <div class="description">
                    <p\u003eSystème de notification où les abonnés reçoivent automatiquement les mises à jour des publications.</p\u003e
                </div\u003e
            </div\u003e
        </div\u003e
    </div\u003e

    <div class="column">
        <div class="ui card" style="width: 100%; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <div class="content">
                <i class="right floated big purple users icon"></i\u003e
                <div class="header">Gestion des utilisateurs</div\u003e
                <div class="description">
                    <p\u003eSystème d'authentification complet avec MariaDB, sessions sécurisées et gestion des utilisateurs.</p\u003e
                </div\u003e
            </div\u003e
        </div\u003e
    </div\u003e

    <div class="column">
        <div class="ui card" style="width: 100%; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <div class="content">
                <i class="right floated big teal server icon"></i\u003e
                <div class="header">Architecture moderne</div\u003e
                <div class="description">
                    <p\u003ePHP 8.5, Slim Framework 4, MariaDB, Docker, Semantic UI - une stack moderne et performante.</p\u003e
                </div\u003e
            </div\u003e
        </div\u003e
    </div\u003e
</div\u003e

<!-- Thread Demo Section -->
<div class="ui segment" style="margin-top: 40px;">
    <h2 class="ui dividing header">
        <i class="rss icon"></i\u003e
        <div class="content">
            Démonstration du Pattern Observer
            <div class="sub header">Exemple d'utilisation du système de publication/abonnement</div\u003e
        </div\u003e
    </h2\u003e

    <div class="ui relaxed divided list">
        <div class="item">
            <i class="large middle aligned broadcast tower icon"></i\u003e
            <div class="content">
                <div class="header">Publisher</div\u003e
                <div class="description">Diffuse les nouvelles à tous les abonnés</div\u003e
            </div\u003e
        </div\u003e

        <div class="item">
            <i class="large middle aligned user icon"></i\u003e
            <div class="content">
                <div class="header">Subscribers</div\u003e
                <div class="description">Reçoivent les notifications automatiquement</div\u003e
            </div\u003e
        </div\u003e

        <div class="item">
            <i class="large middle aligned sync icon"></i\u003e
            <div class="content">
                <div class="header">Mise à jour en temps réel</div\u003e
                <div class="description">Les abonnés sont notifiés instantanément des nouvelles publications</div\u003e
            </div\u003e
        </div\u003e
    </div\u003e

    <?php if ($isAuthenticated): ?\u003e
        <div style="margin-top: 20px;">
            <button class="ui primary button" onclick="alert('Fonctionnalité à venir !')">
                <i class="bell icon"></i\u003e S'abonner aux notifications
            </button\u003e

            <button class="ui button" onclick="alert('Fonctionnalité à venir !')">
                <i class="newspaper icon"></i\u003e Publier une news
            </button\u003e
        </div\u003e
    <?php else: ?\u003e
        <div class="ui info message">
            <i class="info circle icon"></i\u003e
            <div class="content">
                <div class="header">Connectez-vous pour interagir</div\u003e
                <p\u003eConnectez-vous ou inscrivez-vous pour vous abonner aux notifications et publier des news.</p\u003e
            </div\u003e
        </div\u003e
    <?php endif; ?\u003e
</div\u003e

<!-- Stats Section -->
<div class="ui three statistics" style="margin-top: 40px;">
    <div class="statistic">
        <div class="value">
            <i class="users icon"></i\u003e
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
            ?\u003e
        </div\u003e
        <div class="label">Utilisateurs</div\u003e
    </div\u003e

    <div class="statistic">
        <div class="value">
            <i class="rss icon"></i\u003e 0
        </div\u003e
        <div class="label">Abonnements</div\u003e
    </div\u003e

    <div class="statistic">
        <div class="value">
            <i class="newspaper icon"></i\u003e 0
        </div\u003e
        <div class="label">Publications</div\u003e
    </div\u003e
</div\u003e
