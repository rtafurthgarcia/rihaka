<?php

namespace App\Core;

use Slim\App;

use App\Controllers\HomeController;
use App\Controllers\ImpressumController;
use App\Controllers\FAQsController; 
use App\Controllers\PrivacyPolicyController;
use App\Controllers\ContactController;
use App\Controllers\UserController;
use App\Controllers\RecordingController;
use Slim\Routing\RouteCollectorProxy;

class Router {
    public static function defineRoutes(App &$app) {
        $app->get('/', HomeController::class . ':home');
        $app->get('/impressum', ImpressumController::class . ':getImpressumInformation');
        $app->get('/faqs', FAQsController::class . ':getFAQs');
        $app->get('/privacypolicy', PrivacyPolicyController::class . ':getPrivacyPolicy');
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
            $group->get('/recordings', UserController::class . ':getRecordingsFromUser');
        });
        $app->group('/recording/new', function (RouteCollectorProxy $group) {
            $group->get('', RecordingController::class . ':getNewContentPage'); 
            $group->post('', RecordingController::class . ':uploadNewRecording'); 
        });
        $app->group('/recording/{videoId}', function (RouteCollectorProxy $group) {
            $group->get('', RecordingController::class . ':displayRecording'); 
            $group->post('', RecordingController::class . ':updateRecording');
            $group->get('/delete', RecordingController::class . ':deleteRecording'); 
        });
        $app->group('/contact', function  (RouteCollectorProxy $group){
            $group->get('', ContactController::class . ':getContactPage');
        });
    } 
}
