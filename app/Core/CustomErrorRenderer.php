<?php

namespace App\Core;

use Slim\Interfaces\ErrorRendererInterface;
use Slim\Views\PhpRenderer;
use Throwable;

class CustomErrorRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        $renderer = new PhpRenderer(__DIR__ . '/../Views');
        $renderer->setAttributes([
            "activePage" => 0
        ]);
        $renderer->setLayout("./Base/Layout.php");

        return $renderer->fetch("Error.php", [
            "pageTitle" => "RIHAKA - error " . strval($exception->getCode()),
            "exception" => $exception
        ],
        true);
    }
}
