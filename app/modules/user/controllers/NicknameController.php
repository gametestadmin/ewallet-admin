<?php
namespace Backoffice\User\Controllers;

use \System\Datalayer\DLUser;

class NicknameController extends \Backoffice\Controllers\ProtectedController
{

    public function changeAction()
    {
        $view = $this->view;
        if ($this->request->isPost())
        {




        }
//        echo "<pre>";
//        var_dump($this->_user);
//
//        die;

        \Phalcon\Tag::setTitle("Manage Player - ".$this->_website->title);
    }
}
