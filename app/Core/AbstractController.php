<?php

namespace App\Core;

use Slim\Views\PhpRenderer;

abstract class AbstractController {
    protected $_renderer;

    public function __construct($templateVariables)
    {
        if (! array_key_exists("activePage", $templateVariables)) {
            throw new \InvalidArgumentException("Active menu number has to be set. If null then has to be 0.");
        }

        $this->_renderer = new PhpRenderer(__DIR__ . '/../Views');
        $this->_renderer->setAttributes($templateVariables);
        $this->_renderer->setLayout("./Base/Layout.php");
    }
}
