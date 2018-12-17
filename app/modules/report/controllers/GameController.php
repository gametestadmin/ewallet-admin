<?php
namespace Backoffice\Report\Controllers;

use System\Datalayer\DLUserPlayer ;
use System\Datalayer\DLGame ;

class GameController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        $data['game'] = 0 ;
        $data['date_start'] = date("d-m-Y");
        $data['date_end'] = date("d-m-Y");

        $DLUserPlayer= new DLUserPlayer();
        $user_player = $DLUserPlayer->getUserPlayer($this->_realUser->getType() , $this->_realUser->getId() , null );

        $DLGame = new DLGame();
        $gamelist = $DLGame->getGameCategory();

        if ($this->request->isPost()) $data = $this->request->getPost();

        $this->view->post = $data ;
        $this->view->user_player = new \Phalcon\Config($user_player) ;
        $this->view->gamelist = new \Phalcon\Config($gamelist) ;
        \Phalcon\Tag::setTitle("Game Log List - ".$this->_website->title);
    }


    protected function errorUserPlayerNotFound(){
        $this->flash->error("player_not_exist");
        $this->response->redirect($this->_module."/player")->send();
        return null ;
    }
}
