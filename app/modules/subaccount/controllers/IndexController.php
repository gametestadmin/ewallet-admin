<?php
namespace Backoffice\Subaccount\Controllers;


class IndexController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        $view = $this->view;

        echo 1;die;

        \Phalcon\Tag::setTitle("Subaccount - ".$this->_website->title);
    }
}
