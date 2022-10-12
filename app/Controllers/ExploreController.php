<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\SessionHelper;
use DateTime;
use ErrorException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Models\Recording;

class ExploreController extends AbstractController
{
    public function __construct()
    {
        parent::__construct([
            "activePage" => 0,
            "activeMenu" => 0,
            "contributionsOnly" => true
        ]);
    }

    public function explore(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {        
        return $this->_renderer->render($response, "Explore.php", [
            "pageTitle" => "RIHAKA - Explore"
        ]);
    }
}