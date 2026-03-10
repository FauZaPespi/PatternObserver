<?php

namespace Makosc\Observer\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use UserManager;

class MainController
{
    function threadsView(Request $req, Response $resp, array $args): Response
    {
        $view = new PhpRenderer("../view");
        $view->setLayout("layout.php");
        $data = [
            'title' => "Homepage",
        ];
        return $view->render($resp, 'threads.php', $data);
    }
    function registerView(Request $req, Response $resp, array $args): Response
    {
        $view = new PhpRenderer("../view");
        $view->setLayout("layout.php");
        $data = [
            'title' => "Register",
        ];
        return $view->render($resp, 'register.php', $data);
    }

    function register(Request $req, Response $resp, array $args): Response
    {
        $username = filter_input(INPUT_POST, "username", FILTER_UNSAFE_RAW);
        $password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);

        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

        $user = UserManager::createAnUser($username, $hashed_pass);

        $resp->getBody()->write("Slim API is working !!");
        return $resp->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
