<?php

namespace Makosc\Observer\Config;

use Makosc\Observer\Controllers\MainController;
use Makosc\Observer\Controllers\AuthController;

// Démarrer la session si pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400, // 24 heures
        'cookie_httponly' => true,
        'cookie_secure' => false, // Mettre à true en production avec HTTPS
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true,
    ]);
}

// Routes publiques
$app->get('/', [MainController::class, 'threadsView']);

// Routes d'authentification
$app->get('/login', [AuthController::class, 'loginView']);
$app->post('/login', [AuthController::class, 'login']);
$app->get('/register', [AuthController::class, 'registerView']);
$app->post('/register', [AuthController::class, 'register']);
$app->get('/logout', [AuthController::class, 'logout']);
$app->post('/logout', [AuthController::class, 'logout']);

// Routes de l'API (à conserver si nécessaire)
$app->post('/subscribe', [MainController::class, 'subscribeTo']);
$app->post('/news', [MainController::class, 'getNews']);
