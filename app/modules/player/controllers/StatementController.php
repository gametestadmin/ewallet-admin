<?php
namespace Backoffice\Player\Controllers;

class StatementController extends \Backoffice\Controllers\ProtectedController
{

    public function detailAction()
    {
        $id = $this->dispatcher->getParam("id");
        if($this->_realUser->getType() == 9) {
            $sql = 'SELECT * FROM api.user_player WHERE company_id = '.$this->_realUser->getId().' AND status = 1 ';
            $user_player = $this->postgre->query(
                $sql
            )->fetchAll();
        } else {
            $sql = 'SELECT * FROM api.user_player WHERE agent_id = '.$this->_realUser->getId().' AND status = 1 ';
            $user_player = $this->postgre->query(
                $sql
            )->fetchAll();
        }






//        echo "something <pre>";
//        var_dump($user_player);
//        die;

        $this->view->user_player = $user_player ;
        $this->view->id = $id ;
        \Phalcon\Tag::setTitle("Player List - ".$this->_website->title);
    }
}
