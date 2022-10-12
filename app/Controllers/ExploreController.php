<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\SessionHelper;
use App\Models\User;
use DateTime;
use ErrorException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Models\Recording;
use Slim\Exception\HttpNotFoundException;

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

   /*public function explore(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {        
        return $this->_renderer->render($response, "Explore.php", [
            "pageTitle" => "RIHAKA - Explore"
        ]);
    }*/

    public function explore(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $recordings = array();

        try {
            $recordings = (new Recording())->getAllRecords();
    
            $formData = $request->getParsedBody();  
        } catch (\Throwable $th) {
            throw new HttpNotFoundException($request);
        }

        return $this->_renderer->render($response, "Explore.php", [
            "pageTitle" => "RIHAKA - Explore",
            "hideSignup" => true,
            "activeMenu" => 1,
            "contributionsOnly" => true,
            "user" => false,
            "recordings" => $recordings
        ]);
    } 


}