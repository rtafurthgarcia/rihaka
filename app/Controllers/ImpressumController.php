<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\SessionHelper;
use DateTime;
use ErrorException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Core\NetworkHelper;
use Ramsey\Uuid\Uuid;
use SessionHandler;
use SessionHandlerInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;

class ImpressumController extends AbstractController
{
    public function __construct()
    {
        parent::__construct([
            "activePage" => 0,
            "activeMenu" => 0,
            "contributionsOnly" => true
        ]);
    }

    public function getImpressumInformation(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {        
        return $this->_renderer->render($response, "Impressum.php", [
            "pageTitle" => "RIHAKA - Impressum"
        ]);
    }
}