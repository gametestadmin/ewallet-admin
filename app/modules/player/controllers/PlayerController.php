<?php
namespace Backoffice\Player\Controllers;

use System\Library\General\GlobalVariable;

class PlayerController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        if($this->_realUser->getType() == 9) {
            $sql = 'SELECT * FROM api.user_player WHERE company_id = '.$this->_realUser->getId().' AND status = 1 ';
        } else {
            $sql = 'SELECT * FROM api.user_player WHERE agent_id = '.$this->_realUser->getId().' AND status = 1 ';
        }
        $user_player = $this->postgre->query( $sql )->fetchAll();

        $this->view->user_player = $user_player ;
        \Phalcon\Tag::setTitle("Player List - ".$this->_website->title);
    }

    public function detailAction()
    {
        $id = $this->dispatcher->getParam("id");
        $id = \intval($id);
        if(!isset($id)) $this->errorUserPlayerNotFound();


        if($this->_realUser->getType() == 9) {
            $sql = 'SELECT * FROM api.user_player WHERE company_id = '.$this->_realUser->getId().' AND id = '.$id.' AND status = 1 ';
        } else {
            $sql = 'SELECT * FROM api.user_player WHERE agent_id = '.$this->_realUser->getId().' AND id = '.$id.'  AND status = 1 ';
        }
        $user_player = $this->postgre->query( $sql )->fetchArray();

        if( empty($user_player) ) $this->errorUserPlayerNotFound();
        if($this->_realUser->getType() == 9) {
            if( !($this->_realUser->getId() == $user_player['company_id']) ) $this->errorAgentNotMatch();
        } else {
            if( !($this->_realUser->getId() == $user_player['agent_id']) ) $this->errorAgentNotMatch();
        }

        $this->view->user_player = new \Phalcon\Config($user_player) ;
        $this->view->id = $id ;
        \Phalcon\Tag::setTitle("Player Detail - ".$this->_website->title);
    }

    protected function errorUserPlayerNotFound(){
        $this->flash->error("player_not_exist");
        $this->response->redirect($this->_module."/player")->send();
        return null ;
    }

    protected function errorAgentNotMatch(){
        $this->flash->error("agent_dont_have_this_player");
        $this->response->redirect($this->_module."/player")->send();
        return null ;
    }

}
