<?php
namespace Backoffice\Report\Controllers;

use System\Datalayer\DLUserPlayer ;
use System\Library\General\GlobalVariable ;

class TransactionController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        $data['type'] = 0 ;
        $data['date_start'] = date("d-m-Y");
        $data['date_end'] = date("d-m-Y");

        $DLUserPlayer= new DLUserPlayer();
        $user_player = $DLUserPlayer->getUserPlayer($this->_realUser->getType() , $this->_realUser->getId() , null );

        $TransactionType = GlobalVariable::$TransactionType;
        if ($this->request->isPost()) $data = $this->request->getPost();


        $this->view->post = $data ;
        $this->view->user_player = new \Phalcon\Config($user_player) ;
        $this->view->transactiontype = $TransactionType ;
        \Phalcon\Tag::setTitle("Transaction History List - ".$this->_website->title);
    }


    protected function errorUserPlayerNotFound(){
        $this->flash->error("player_not_exist");
        $this->response->redirect($this->_module."/player")->send();
        return null ;
    }

}
