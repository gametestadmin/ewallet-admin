<?php
namespace Backoffice\Game\Controllers;


class IndexController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        echo "provider";die;

        \Phalcon\Tag::setTitle("Currency - ".$this->_website->title);
    }
}
