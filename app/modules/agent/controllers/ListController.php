<?php
namespace Backoffice\User\Controllers;

use System\Library\User\General as GeneralUser;

class ListController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        $view = $this->view;

        $userLibrary = new GeneralUser();



        $view->user = $userLibrary->check();

        \Phalcon\Tag::setTitle("Manage Player - ".$this->_website->title);
    }
}
