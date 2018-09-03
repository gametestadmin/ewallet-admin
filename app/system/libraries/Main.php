<?php
namespace System\Library;

use \Phalcon\Session\Adapter\Files as SessionAdapter;

class Main
{
    protected $session ;

    public function __construct()
    {
        $this->session = new SessionAdapter();
        $this->session->start();


    }

}
