<?php

namespace Makosc\Observer\Controllers;

use Makosc\Observer\Models\UserManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class AuthController
{
    private PhpRenderer $view;

    public function __construct()
    {
        $this->view = new PhpRenderer(__DIR__ . "/../../view");
        $this->view->setLayout("layout.php");
    }

    /**
     * Affiche la page de connexion
     */
    public function loginView(Request $request, Response $response, array $args): Response
    {
        // Si déjà connecté, rediriger vers l'accueil
        if ($this->isAuthenticated()) {
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        $data = [
            'title' => 'Connexion',
            'error' => $_SESSION['login_error'] ?? null,
        ];

        unset($_SESSION['login_error']);

        return $this->view->render($response, 'login.php', $data);
    }

    /**
     * Affiche la page d'inscription
     */
    public function registerView(Request $request, Response $response, array $args): Response
    {
        // Si déjà connecté, rediriger vers l'accueil
        if ($this->isAuthenticated()) {
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        $data = [
            'title' => 'Inscription',
            'error' => $_SESSION['register_error'] ?? null,
        ];

        unset($_SESSION['register_error']);

        return $this->view->render($response, 'register.php', $data);
    }

    /**
     * Traite la connexion
     */
    public function login(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        // Validation
        if (empty($username) || empty($password)) {
            $_SESSION['login_error'] = 'Veuillez remplir tous les champs.';
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        // Authentification
        $user = UserManager::authenticate($username, $password);

        if ($user) {
            // Connexion réussie
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['is_authenticated'] = true;

            // Message de succès
            $_SESSION['flash_message'] = 'Bienvenue, ' . htmlspecialchars($user->username) . ' !';
            $_SESSION['flash_type'] = 'success';

            return $response->withHeader('Location', '/')->withStatus(302);
        }

        // Échec de la connexion
        $_SESSION['login_error'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    /**
     * Traite l'inscription
     */
    public function register(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';
        $passwordConfirm = $data['password_confirm'] ?? '';

        // Validation
        $errors = [];

        if (empty($username)) {
            $errors[] = 'Le nom d\'utilisateur est requis.';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Le nom d\'utilisateur doit contenir au moins 3 caractères.';
        } elseif (strlen($username) > 50) {
            $errors[] = 'Le nom d\'utilisateur ne doit pas dépasser 50 caractères.';
        }

        if (empty($password)) {
            $errors[] = 'Le mot de passe est requis.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
        }

        if ($password !== $passwordConfirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        if (!empty($errors)) {
            $_SESSION['register_error'] = implode(' ', $errors);
            return $response->withHeader('Location', '/register')->withStatus(302);
        }

        // Création de l'utilisateur
        $user = UserManager::createUser($username, $password);

        if ($user) {
            // Inscription réussie, connexion automatique
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['is_authenticated'] = true;

            $_SESSION['flash_message'] = 'Inscription réussie ! Bienvenue, ' . htmlspecialchars($user->username) . ' !';
            $_SESSION['flash_type'] = 'success';

            return $response->withHeader('Location', '/')->withStatus(302);
        }

        // Échec de l'inscription (utilisateur existe déjà)
        $_SESSION['register_error'] = 'Ce nom d\'utilisateur est déjà pris.';
        return $response->withHeader('Location', '/register')->withStatus(302);
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request, Response $response, array $args): Response
    {
        // Détruire toutes les données de session
        $_SESSION = [];

        // Détruire le cookie de session
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', [
                'expires' => time() - 3600,
                'path' => '/',
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }

        // Détruire la session
        session_destroy();

        // Rediriger vers l'accueil
        return $response->withHeader('Location', '/')->withStatus(302);
    }

    /**
     * Vérifie si l'utilisateur est authentifié
     */
    private function isAuthenticated(): bool
    {
        return isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] === true;
    }

    /**
     * Récupère l'utilisateur connecté
     */
    public static function getCurrentUser(): ?\Makosc\Observer\Models\User
    {
        if (isset($_SESSION['user_id'])) {
            return UserManager::findById($_SESSION['user_id']);
        }
        return null;
    }

    /**
     * Vérifie si un utilisateur est connecté (méthode statique)
     */
    public static function check(): bool
    {
        return isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] === true;
    }
}
