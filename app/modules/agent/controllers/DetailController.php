<?php
namespace Backoffice\Agent\Controllers;

class DetailController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;
//        echo 3;die;
        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
    }
}
