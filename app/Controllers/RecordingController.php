<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\ConverterHelper;
use App\Core\SessionHelper;
use App\Models\Recording;
use DateTime;
use ErrorException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Models\User;

use App\Core\NetworkHelper;
use Ramsey\Uuid\Uuid;
use SessionHandler;
use SessionHandlerInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;

class RecordingController extends AbstractController
{
    public function __construct()
    {
        parent::__construct([
            "activePage" => 0,
            "activeMenu" => 0,
            "contributionsOnly" => true
        ]);
    }

    public function getNewContentPage(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $user = new User();
        
        if ($_SESSION["authenticated"]) {
            $user->getById($_SESSION['id']);

            return $this->_renderer->render($response, "Recording.php", [
                "pageTitle" => "RIHAKA - new upload",
                "hideSignup" => true,
                "user" => $user,
                "activeMenu" => 1,
                "contributionsOnly" => false
            ]);
        } else {
            throw new HttpForbiddenException($request);
        }
    } 

    public function uploadNewRecording(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        
        $uploadedFileName = null;

        if ($_SESSION["authenticated"]) {
            $formData = $request->getParsedBody();
            $errors = array();
            $isSuccessful = true;
            $directory = $_ENV['VIDEO_UPLOAD_DIRECTORY'];

            $user = new User();
            $user->getById($_SESSION['id']);

            $recording = new Recording();

            $recording->setTitle($formData["title"]);
            $recording->setDescription($formData["description"]);
            $recording->setUserId($_SESSION["id"]);
            $recording->setCommentsAuthorized(isset($formData["commentsAuthorized"]));
            $recording->setIsPrivate(isset($formData["isPrivate"]));

            try {
                $uploadedFiles = $request->getUploadedFiles();
                $uploadedFile = null;

                if (isset($uploadedFiles["recording-file"])) {
                    $uploadedFile = $uploadedFiles['recording-file'];
                }

                if (isset($uploadedFile) && $uploadedFile->getError() ==! UPLOAD_ERR_NO_FILE) {

                    if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
                        throw new ErrorException('Error on upload: upload failed, sorry');
                    }

                    if ($uploadedFile->getSize() > 10000000) {
                        throw new ErrorException('Error on upload: Exceeded file size limit');
                    }

                    if ($uploadedFile->getClientMediaType() ==! 'application/octet-stream') {
                        throw new ErrorException('Error on upload: Wrong file type');
                    }

                    $uploadedFileName = $directory . Uuid::uuid4()->toString();
                    $uploadedFile->moveTo($uploadedFileName);
                    $convertedFileName = ConverterHelper::convertUMLtoASCIInema($uploadedFileName);

                    $data = file_get_contents($convertedFileName); 
                    $recording_json = json_decode($data); 

                    if ((int)$recording_json->duration < 15) {
                        throw new ErrorException('Recording: not really worth it if less than 15 seconds tbh.');
                    }
                    
                    $recording->setVideoLink($convertedFileName);

                    $recording->save();
                }
            } catch (Exception $error) {
                $errors["upload"] = $error->getMessage();
                $isSuccessful = false;
            } finally {
                unlink($uploadedFileName);
            }

            return $this->_renderer->render($response, "Recording.php", [
                "pageTitle" => "RIHAKA - new upload",
                "hideSignup" => true,
                "user" => $user,
                "recording" => $recording,
                "activeMenu" => 1,
                "contributionsOnly" => false,
                "successful" => $isSuccessful,
                "errors" => $errors
            ]);
        } else {
            throw new HttpForbiddenException($request);
        }
    } 
}