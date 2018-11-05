<?php
namespace Backoffice\User\Controllers;


class IndexController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        $view = $this->view;

        echo 1;die;

        \Phalcon\Tag::setTitle("User - ".$this->_website->title);
    }
}
