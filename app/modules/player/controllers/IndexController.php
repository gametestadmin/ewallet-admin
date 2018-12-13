<?php
namespace Backoffice\Player\Controllers;


class IndexController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        $view = $this->view;

        echo 1;die;

        \Phalcon\Tag::setTitle("Player - ".$this->_website->title);
    }
}
