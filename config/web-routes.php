<?php
namespace Makosc\Observer\Config;
use Makosc\Observer\Controllers\MainController;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$app->get('/', [ MainController::class, 'threadsView' ]);
$app->get('/register', [ MainController::class, 'registerView']);
$app->post('/subscribe', [ MainController::class, 'subscribeTo' ]);
$app->post('/news', [ MainController::class, 'getNews' ]);
