<?php

namespace App\Controllers;

use App\Core\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PrivacyPolicyController extends AbstractController
{
    public function __construct()
    {
        parent::__construct([
            "activePage" => 0,
            "activeMenu" => 0,
            "contributionsOnly" => true
        ]);
    }

    public function getPrivacyPolicy(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {        
        return $this->_renderer->render($response, "PrivacyPolicy.php", [
            "pageTitle" => "RIHAKA - Privacy Policy"
        ]);
    }
}