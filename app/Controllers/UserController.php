<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Slim\Views\PhpRenderer;
use App\Models\User;

use App\Core\NetworkHelper;

class UserController
{
    private $_renderer;

    public function __construct()
    {
        $this->_renderer = new PhpRenderer(__DIR__ . '/../Views');
        $this->_renderer->setLayout("./Base/Layout.php");
    }

    public function registration(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {        
        return $this->_renderer->render($response, "Registration.php", [
            "page_title" => "RIHAKA - registration",
            "hide_login_panel" => true
        ]);
    }

    public function registrationFormUpload(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {   
        $newUser = New User();
        $formData = $request->getParsedBody();
        $errors = array();
        
        try {
            $newUser->setUserName($formData['username']);
            $newUser->verifyUsername();
        } catch (\Exception $error) {
            $errors["username"] = $error->getMessage();
        }
        try {
            $newUser->setEmail($formData['email']);
            $newUser->verifyEmail();
        } catch (\Exception $error) {
            $errors["email"] = $error->getMessage();
        }

        try {
            $newUser->setPassword($formData['password'], $formData['password-confirmation']);
        } catch (\Exception $error) {
            $errors["password"] = $error->getMessage();
        }

        $newUser->setIpAddress(NetworkHelper::getIPAddress());
    
        $isSuccessful = true;
        if (count($errors) > 0) {
            $isSuccessful = false;
        } else {
            $newUser->save();
        }
        //$response->withStatus()
        return $this->_renderer->render($response, "Registration.php", [
            "page_title" => "RIHAKA - registration",
            "hide_login_panel" => true,
            "user" => $newUser,
            "successful" => $isSuccessful,
            "errors" => $errors
        ]);
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->_renderer->render($response, "Login.php", [
            "page_title" => "RIHAKA - log-in",
            "hide_login_panel" => true
        ]);
    }
}