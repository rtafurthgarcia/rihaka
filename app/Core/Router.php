<?php

namespace App\Core;

use Slim\App;

use App\Controllers\HomeController;
use App\Controllers\UserController;

class Router {
    public static function defineRoutes(App &$app) {
        $app->get('/', HomeController::class . ':home');
        $app->get('/register', UserController::class . ':registration');
        $app->post('/register', UserController::class . ':registrationFormUpload');
        $app->get('/login', UserController::class . ':login');
    } 
}
