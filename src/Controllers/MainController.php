<?php

namespace Makosc\Observer\Controllers;

use Makosc\Observer\Models\UserManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Makosc\Observer\Models\Thread;
use Makosc\Observer\Models\ThreadManager;
use Makosc\Observer\Models\FollowManager;

class MainController
{
    function threadsView(Request $req, Response $resp, array $args): Response
    {
        $view = new PhpRenderer(__DIR__ . "/../../view");
        $view->setLayout("layout.php");

        $isAuthenticated = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'];
        $threads = ThreadManager::getAllThreads();
        $followingThreads = [];

        if ($isAuthenticated && isset($_SESSION['user_id'])) {
            $followingThreads = ThreadManager::getAllByFollowing((int) $_SESSION['user_id']);
        }

        $data = [
            'title' => 'Threads',
            'threads' => $threads,
            'followingThreads' => $followingThreads,
        ];

        return $view->render($resp, 'threads.php', $data);
    }

    function userProfile(Request $req, Response $resp, array $args): Response
    {
        $view = new PhpRenderer(__DIR__ . "/../../view");
        $view->setLayout("layout.php");

        $username = $args['username'] ?? '';
        $profileUser = UserManager::findByUsername($username);

        if (!$profileUser) {
            $_SESSION['flash_message'] = 'Utilisateur introuvable.';
            $_SESSION['flash_type'] = 'error';
            return $resp->withHeader('Location', '/')->withStatus(302);
        }

        $isAuthenticated = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'];
        $isOwnProfile = $isAuthenticated && isset($_SESSION['user_id']) && (int) $_SESSION['user_id'] === $profileUser->id;
        $isFollowing = false;

        if ($isAuthenticated && !$isOwnProfile && isset($_SESSION['user_id'])) {
            $isFollowing = FollowManager::isFollowing((int) $_SESSION['user_id'], $profileUser->id);
        }

        $data = [
            'title' => '@' . $profileUser->username,
            'profileUser' => $profileUser,
            'threads' => ThreadManager::getAllByUserId($profileUser->id),
            'followerCount' => FollowManager::getFollowerCount($profileUser->id),
            'followingCount' => FollowManager::getFollowingCount($profileUser->id),
            'isOwnProfile' => $isOwnProfile,
            'isFollowing' => $isFollowing,
            'isAuthenticated' => $isAuthenticated,
        ];

        return $view->render($resp, 'user_profile.php', $data);
    }

    function followToggle(Request $req, Response $resp, array $args): Response
    {
        $isAuthenticated = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'];

        if (!$isAuthenticated) {
            return $resp->withHeader('Location', '/login')->withStatus(302);
        }

        $username = $args['username'] ?? '';
        $targetUser = UserManager::findByUsername($username);

        if (!$targetUser || $targetUser->id === (int) $_SESSION['user_id']) {
            return $resp->withHeader('Location', '/user/' . urlencode($username))->withStatus(302);
        }

        $currentUserId = (int) $_SESSION['user_id'];

        if (FollowManager::isFollowing($currentUserId, $targetUser->id)) {
            FollowManager::unfollow($currentUserId, $targetUser->id);
            $_SESSION['flash_message'] = 'Vous ne suivez plus @' . htmlspecialchars($targetUser->username) . '.';
        } else {
            FollowManager::follow($currentUserId, $targetUser->id);
            $_SESSION['flash_message'] = 'Vous suivez maintenant @' . htmlspecialchars($targetUser->username) . ' !';
        }

        $_SESSION['flash_type'] = 'success';
        return $resp->withHeader('Location', '/user/' . urlencode($username))->withStatus(302);
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

        $createdThread = ThreadManager::createThread($thread);

        $resp->getBody()->write(json_encode(['status' => 'posted']));
        return $resp->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
