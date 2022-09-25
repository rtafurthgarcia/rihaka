<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Slim\Views\PhpRenderer;

class UserController
{
    private $_renderer;

    public function __construct()
    {
        $this->_renderer = new PhpRenderer(__DIR__ . '/../Views');
        $this->_renderer->setLayout("./Base/Layout.php");
    }

    public function registration(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {        
        return $this->_renderer->render($response, "Registration.php", [
            "page_title" => "RIHAKA - registration",
            "hide_login_panel" => true
        ]);
    }
}