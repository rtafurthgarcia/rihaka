<?php

namespace App\Controllers;

use App\Core\AbstractController;
use ErrorException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Models\User;

use App\Core\NetworkHelper;

class UserController extends AbstractController
{
    public function __construct()
    {
        parent::__construct([
            "activePage" => 0
        ]);
    }

    public function registration(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {        
        return $this->_renderer->render($response, "Registration.php", [
            "pageTitle" => "RIHAKA - registration",
            "hideSignup" => true
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
        } catch (Exception $error) {
            $errors["username"] = $error->getMessage();
        }
        try {
            $newUser->setEmail($formData['email']);
            $newUser->verifyEmail();
        } catch (Exception $error) {
            $errors["email"] = $error->getMessage();
        }

        try {
            $newUser->setPassword($formData['password'], $formData['password-confirmation']);
        } catch (Exception $error) {
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
            "pageTitle" => "RIHAKA - registration",
            "hideSignup" => true,
            "user" => $newUser,
            "successful" => $isSuccessful,
            "errors" => $errors
        ]);
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        return $this->_renderer->render($response, "Login.php", [
            "pageTitle" => "RIHAKA - log-in",
            "hide_login" => true
        ]);
    }

    public function loginFormUpload(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $newUser = New User();
        $formData = $request->getParsedBody();
        $errors = array();

        try {
            $newUser->login($formData['email'], $formData['password']);
        } catch (Exception $error) {
            $errors["password"] = $error->getMessage();
            $response->withStatus(301);
        }

        if (count($errors) > 0) {
            return $this->_renderer->render($response, "Login.php", [
                "pageTitle" => "RIHAKA - log-in",
                "hide_login" => true,
                "errors" => $errors
            ])->withStatus(403);
        } else {
            //$newUser->save();
            return $response->withHeader('Location', "/user/" . $_SESSION['username'])->withStatus(303);
        }
    }

    public function userAccount(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $user = new User();
        
        if ($_SESSION["authenticated"]) {
            if ($_SESSION['username'] === $args['username']) {
                $user->getById($_SESSION['id']);
                
                return $this->_renderer->render($response, "UserAccount.php", [
                    "pageTitle" => "RIHAKA - log-in",
                    "hideSignup" => true,
                    "user" => $user
                ]);
            } else {
                return $response->withStatus(403);
            }
        } else {
            $user->getByUsername($args['username']);

            return $this->_renderer->render($response, "UserAccount.php", [
                "pageTitle" => "RIHAKA - log-in",
                "user" => $user
            ]);
        }
    } 

    public function userAccountSecurity(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $user = new User();

        if ($_SESSION["authenticated"]) {
            if ($_SESSION['username'] === $args['username']) {
                $user->getById($_SESSION['id']);
    
                return $this->_renderer->render($response, "PasswordChange.php", [
                    "pageTitle" => "RIHAKA - log-in",
                    "hideSignup" => true,
                    "user" => $user
                ]);
            } else {
                return $response->withStatus(403);
            }
        } else {
            return $response->withHeader('Location', '/login')->withStatus(303);    
        }
    } 

    public function userAccountSecurityFormUpload(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        
        if ($_SESSION["authenticated"]) {
            if ($_SESSION['username'] === $args['username']) {
                $user = new User();
                $user->getById($_SESSION['id']);

                $formData = $request->getParsedBody();
                $errors = array();
                $successful = true;
        
                try {
                    if (!password_verify($formData['current-password'], $user->getPassword())) {
                        throw new ErrorException("Wrong password.", 1);
                    }
                } catch (Exception $error) {
                    $errors["currentPassword"] = $error->getMessage();
                    $response->withStatus(301);
                    $successful = false;
                }

                try {
                    $user->setPassword($formData['password'], $formData['password-confirmation']);
                } catch (Exception $error) {
                    $errors["newPassword"] = $error->getMessage();
                    $response->withStatus(301);
                    $successful = false;
                }
    
                return $this->_renderer->render($response, "PasswordChange.php", [
                    "pageTitle" => "RIHAKA - log-in",
                    "hideSignup" => true,
                    "user" => $user,
                    "errors" => $errors,
                    "successful" => $successful
                ]);
            } else {
                return $response->withStatus(403);
            }
        } else {
            return $response->withHeader('Location', '/login')->withStatus(303);    
        }
    } 

    public function logout(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        session_unset();
        session_destroy();

        return $response->withHeader('Location', '/')->withStatus(303); // 303 -> see other -> perfect after post or operation
    }
}