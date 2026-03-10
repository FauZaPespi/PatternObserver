<?php

namespace Makosc\Observer\Controllers;

use Makosc\Observer\Models\UserManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class MainController
{
    function threadsView(Request $req, Response $resp, array $args): Response
    {
        $view = new PhpRenderer(__DIR__ . "/../../view");
        $view->setLayout("layout.php");

        // Récupérer les threads si existants (pour l'exemple)
        $data = [
            'title' => "Accueil",
        ];

        return $view->render($resp, 'threads.php', $data);
    }

    // Méthodes Observer (Pattern)
    function subscribeTo(Request $req, Response $resp, array $args): Response
    {
        // TODO: Implémenter la logique d'abonnement
        $resp->getBody()->write(json_encode(['status' => 'subscribed']));
        return $resp->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    function getNews(Request $req, Response $resp, array $args): Response
    {
        // TODO: Implémenter la logique de récupération des news
        $resp->getBody()->write(json_encode(['status' => 'news']));
        return $resp->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
