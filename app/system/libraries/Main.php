<?php
namespace System\Library;

use \Phalcon\Session\Adapter\Files as SessionAdapter;
use \Phalcon\Http\Request ;
use System\Language\Language;

class Main
{
    protected $session ;

    public function __construct()
    {
        $this->session = new SessionAdapter();
        $this->session->start();


        $language = new Language();
        $this->_language = $language->getTranslation();
//        $this->_language = Language::getTranslation();
        $request = new Request();
        $this->_server = $request->getServer("HTTP_HOST");


    }

}
