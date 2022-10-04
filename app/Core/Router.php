<?php

namespace App\Core;

use Slim\App;

use App\Controllers\HomeController;
use App\Controllers\UserController;
use Slim\Routing\RouteCollectorProxy;

class Router {
    public static function defineRoutes(App &$app) {
        $app->get('/', HomeController::class . ':home');
        $app->get('/register', UserController::class . ':registration');
        $app->post('/register', UserController::class . ':registrationFormUpload');
        $app->get('/login', UserController::class . ':login');
        $app->post('/login', UserController::class . ':loginFormUpload');
        $app->get('/logout', UserController::class . ':logout');
        $app->group('/user/{username}', function (RouteCollectorProxy $group) {
            $group->get('', UserController::class . ':userAccount');
            $group->get('/security', UserController::class . ':userAccountSecurity');
            $group->post('/security', UserController::class . ':userAccountSecurityFormUpload');
        });
    } 
}
