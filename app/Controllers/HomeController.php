<?php

namespace App\Controllers;

use App\Core\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends AbstractController
{
    public function __construct()
    {
        parent::__construct([
            "activePage" => 1
        ]);
    }

    public function home(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {        
        return $this->_renderer->render($response, "Home.php", [
            "pageTitle" => "RIHAKA - honeypot records database"
        ]);
    }

    //public function about(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
}