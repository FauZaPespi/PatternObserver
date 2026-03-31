<?php

namespace Makosc\Observer\Config;

use Makosc\Observer\Controllers\MainController;
use Makosc\Observer\Controllers\AuthController;
use Makosc\Observer\Middlewares\RateLimitMiddleware;

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
$app->get('/login', [AuthController::class, 'loginView'])->add(new RateLimitMiddleware());
$app->post('/login', [AuthController::class, 'login'])->add(new RateLimitMiddleware());
$app->get('/register', [AuthController::class, 'registerView'])->add(new RateLimitMiddleware());
$app->post('/register', [AuthController::class, 'register'])->add(new RateLimitMiddleware());
$app->get('/logout', [AuthController::class, 'logout'])->add(new RateLimitMiddleware());
$app->post('/logout', [AuthController::class, 'logout'])->add(new RateLimitMiddleware());
$app->get('/profile', [AuthController::class, 'profile'])->add(new RateLimitMiddleware());
$app->post('/profile/update', [AuthController::class, 'profileUpdate'])->add(new RateLimitMiddleware());
$app->post('/profile/password', [AuthController::class, 'profilePassword'])->add(new RateLimitMiddleware());

// Routes de l'API (à conserver si nécessaire)
$app->post('/subscribe', [MainController::class, 'subscribeTo'])->add(new RateLimitMiddleware());
$app->post('/news', [MainController::class, 'getNews'])->add(new RateLimitMiddleware());
$app->post('/post', [MainController::class, 'postNews'])->add(new RateLimitMiddleware());
$app->get('/user/{username}', [MainController::class, 'userProfile'])->add(new RateLimitMiddleware());
$app->post('/follow/{username}', [MainController::class, 'followToggle'])->add(new RateLimitMiddleware());
