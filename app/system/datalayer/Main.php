<?php
namespace System\Datalayer;

class Main
{
    public $_config = null;
    public $_lang = null;
    public $_server = null;

    public function __construct()
    {
        $request = new Request();
        $this->_config = require __DIR__ . '/../../config/config.php';
        $this->_lang = language::getTranslation();
        $this->_server = $request->getServer("HTTP_HOST");
    }
}