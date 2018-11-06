<?php
namespace Backoffice\User\Controllers;

class PlayerController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        $sql = 'SELECT * FROM api.user_player WHERE agent_id = '.$this->_user->getId().' AND status = 1 ';
//        $sql = 'SELECT * FROM api.user_player WHERE status = 1 ';
        $user_player = $this->postgre->query(
            $sql
            )->fetchAll();
//        echo "something <pre>";
//        var_dump($user_player);
//        die;

        $this->view->user_player = $user_player ;
        \Phalcon\Tag::setTitle("Player List - ".$this->_website->title);
    }
}
