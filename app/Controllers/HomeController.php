<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Slim\Views\PhpRenderer;

class HomeController
{
    private $_renderer;

    public function __construct()
    {
        $this->_renderer = new PhpRenderer(__DIR__ . '/../Views');
    }

    public function home(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {        
        return $this->_renderer->render($response, "Home.php", $args);
    }
}