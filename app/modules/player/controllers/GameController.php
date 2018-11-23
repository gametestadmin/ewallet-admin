<?php
namespace Backoffice\Player\Controllers;

class GameController extends \Backoffice\Controllers\ProtectedController
{

    public function detailAction()
    {
        $id = $this->dispatcher->getParam("id");
        $id = \intval($id);
        if(!isset($id)) $this->errorUserPlayerNotFound();
        $data['game'] = 0 ;
        $data['date_start'] = date("d-m-Y");
        $data['date_end'] = date("d-m-Y");



        if ($this->request->isPost()) {
            $data = $this->request->getPost();
//
//            $data['date_start'] = date('Y-m-d 00:00:00', strtotime($data['date_start']) );
//            $data['date_end'] = date('Y-m-d 23:59:59', strtotime($data['date_start']) );
//
//            $sql = "SELECT * FROM api.user_player_game_access_log WHERE user_player = " .$id. " AND access_time >= ' ".$data['date_start']." ' AND access_time <= ' ".$data['date_end']." ' ";
//            $game_access_log = $this->postgre->query( $sql )->fetchAll();
//
//
//            echo "here is something <pre>";
//            var_dump(date("Y-m-d"));
//            var_dump($sql);
//            var_dump($data);
//            var_dump($game_access_log);
//            die;
        }


        if($this->_realUser->getType() == 9) {
            $sql = 'SELECT * FROM api.user_player_game_access_log WHERE user_player = ' .$id. ' AND company = '.$this->_realUser->getId() ;
        } else {
            $sql = 'SELECT * FROM api.user_player_game_access_log WHERE user_player = ' .$id. ' AND agent = '.$this->_realUser->getId();
        }
        $game_access_log = $this->postgre->query( $sql )->fetchAll();


//        echo "something <pre>";
//        var_dump($data);
//        die;

        $this->view->post = $data ;
        $this->view->game_access_log = $game_access_log ;
        $this->view->id = $id ;
        \Phalcon\Tag::setTitle("Game List - ".$this->_website->title);
    }


    protected function errorUserPlayerNotFound(){
        $this->flash->error("player_not_exist");
        $this->response->redirect($this->_module."/player")->send();
        return null ;
    }
}
