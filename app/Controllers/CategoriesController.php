<?php

namespace App\Controllers;

use App\Core\AbstractController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class CategoriesController extends AbstractController
{
    public function __construct()
    {
        parent::__construct([
            "activePage" => 0,
            "activeMenu" => 0,
            "contributionsOnly" => true
        ]);
    }

    public function getCategories(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {        
        return $this->_renderer->render($response, "Categories.php", [
            "pageTitle" => "RIHAKA - Categories"
        ]);
    }
}