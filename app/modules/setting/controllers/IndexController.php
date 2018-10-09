<?php
namespace Backoffice\Currency\Controllers;


class IndexController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        $view = $this->view;

        echo 3;die;

        \Phalcon\Tag::setTitle("Currency - ".$this->_website->title);
    }
}
