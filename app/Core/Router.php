<?php

namespace App\Core;

use Slim\App;

use App\Controllers\HomeController;

class Router {
    public static function defineRoutes(App &$app) {
        $app->get('/', HomeController::class . ':home');    
    
    } 
}
