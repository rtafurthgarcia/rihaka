<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\SessionHelper;
use DateTime;
use ErrorException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Models\User;

use App\Core\NetworkHelper;
use Ramsey\Uuid\Uuid;
use SessionHandler;
use SessionHandlerInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;

class VideoController extends AbstractController
{
    public function __construct()
    {
        parent::__construct([
            "activePage" => 0,
            "activeMenu" => 0,
            "contributionsOnly" => true
        ]);
    }

    public function getNewContentPage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $user = new User();
        
        if ($_SESSION["authenticated"]) {
            $user->getById($_SESSION['id']);

            return $this->_renderer->render($response, "SSHSession.php", [
                "pageTitle" => "RIHAKA - new upload",
                "hideSignup" => true,
                "user" => $user,
                "activeMenu" => 1,
                "contributionsOnly" => false
            ]);
        } else {
            throw new HttpForbiddenException($request);
        }
    } 
}