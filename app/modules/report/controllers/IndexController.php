<?php
namespace Backoffice\Report\Controllers;


class IndexController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        $view = $this->view;

        echo 1;die;

        \Phalcon\Tag::setTitle("Report - ".$this->_website->title);
    }
}
