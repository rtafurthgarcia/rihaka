<?php

namespace App\Core;

use Slim\App;

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\RecordingController;
use Slim\Routing\RouteCollectorProxy;

class Router {
    public static function defineRoutes(App &$app) {
        $app->get('/', HomeController::class . ':home');
        $app->get('/register', UserController::class . ':getRegistrationForm');
        $app->post('/register', UserController::class . ':registerAccount');
        $app->get('/login', UserController::class . ':getLoginForm');
        $app->post('/login', UserController::class . ':loginThroughForm');
        $app->get('/logout', UserController::class . ':logout');
        $app->group('/user/{username}', function (RouteCollectorProxy $group) {
            $group->get('', UserController::class . ':getUserAccount');
            $group->post('', UserController::class . ':updateUserProfile');
            $group->post('/delete', UserController::class . ':deleteUserAccount');
            $group->get('/security', UserController::class . ':getUserAccountSecurity');
            $group->post('/security', UserController::class . ':changeUserPassword');
        });
        $app->group('/recording/new', function (RouteCollectorProxy $group) {
            $group->get('', RecordingController::class . ':getNewContentPage'); 
            $group->post('', RecordingController::class . ':uploadNewRecording'); 
        });
    } 
}
