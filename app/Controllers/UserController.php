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
            "hide_signup" => true
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
            "hide_signup" => true,
            "user" => $newUser,
            "successful" => $isSuccessful,
            "errors" => $errors
        ]);
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->_renderer->render($response, "Login.php", [
            "page_title" => "RIHAKA - log-in",
            "hide_login" => true
        ]);
    }

    public function loginFormUpload(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $newUser = New User();
        $formData = $request->getParsedBody();
        $errors = array();

        try {
            $newUser->login($formData['email'], $formData['password']);
        } catch (\Exception $error) {
            $errors["email"] = $error->getMessage();
        }

        if (count($errors) > 0) {
            return $this->_renderer->render($response, "Login.php", [
                "page_title" => "RIHAKA - log-in",
                "hide_login" => true,
                "errors" => $errors
            ]);
        } else {
            //$newUser->save();
            return $response->withHeader('Location', "/user/" . $_SESSION['username'])->withStatus(200);
        }
    }

    public function userAccount(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $user = new User();

        if ($_SESSION["authenticated"]) {
            $user->get($_SESSION['id']);

            return $this->_renderer->render($response, "UserAccount.php", [
                "page_title" => "RIHAKA - log-in",
                "hide_signup" => true,
                "user" => $user
            ]);
        } else {
            try {
                $user->get($args['username']);
    
                return $this->_renderer->render($response, "UserAccount.php", [
                    "page_title" => "RIHAKA - log-in",
                    "user" => $user
                ]);
            } catch (\Throwable $th) {
                //return 
            }
        }
    } 

    public function logoutOfAccount(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        session_unset();
        session_destroy();

        return $response->withHeader('Location', "/")->withStatus(200);
    }
}