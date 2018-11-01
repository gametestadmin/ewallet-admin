<?php
namespace Backoffice\User\Controllers;

class PlayerController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {

        $user_player = $this->postgre->query(
                'SELECT * FROM api.user_player WHERE agent_id = '.$this->_user->getId().' AND status = 1 '
            )->fetchAll();

        $this->view->user_player = $user_player ;
        \Phalcon\Tag::setTitle("Player List - ".$this->_website->title);
    }
}
