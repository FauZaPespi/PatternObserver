<?php

namespace Makosc\Observer\Controllers;

use Makosc\Observer\Models\UserManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Makosc\Observer\Models\Thread;

class MainController
{
    function threadsView(Request $req, Response $resp, array $args): Response
    {
        $view = new PhpRenderer(__DIR__ . "/../../view");
        $view->setLayout("layout.php");

        // Récupérer les threads si existants (pour l'exemple)
        $threads = \Makosc\Observer\Models\ThreadManager::getAllThreads();

        $data = [
            'title' => "Accueil",
            'threads' => $threads,
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

    function postNews(Request $req, Response $resp, array $args): Response
    {
        $isAuthenticated = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'];
        
        if (!$isAuthenticated) {
            $resp->getBody()->write(json_encode(['status' => 'error', 'message' => 'Not authentified']));
            return $resp->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $username = $_SESSION['username'] ?? null;
        $user = UserManager::findByUsername($username);
        if (!$user) {
            $resp->getBody()->write(json_encode(['status' => 'error', 'message' => 'User not found']));
            return $resp->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        if (!isset($req->getParsedBody()['content']) || empty(trim($req->getParsedBody()['content']))) {
            $resp->getBody()->write(json_encode(['status' => 'error', 'message' => 'Content cannot be empty']));
            return $resp->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $thread = Thread::fromArray([
            'content' => $req->getParsedBody()['content'],
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
            'user_id' => $user->id,
        ]);

        $createdThread = \Makosc\Observer\Models\ThreadManager::createThread($thread);
        
        $resp->getBody()->write(json_encode(['status' => 'posted']));
        return $resp->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
