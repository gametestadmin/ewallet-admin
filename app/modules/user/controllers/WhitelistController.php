<?php
namespace Backoffice\User\Controllers;

use \System\Datalayer\DLUserWhitelistIp;

class WhitelistController extends \Backoffice\Controllers\ProtectedController
{

    public function indexAction()
    {
        $whitelist = new DLUserWhitelistIp();
        $iplist = $whitelist->getByUser($this->_realUser->getId());

        $this->view->iplist = $iplist ;
        \Phalcon\Tag::setTitle("Profile - ".$this->_website->title);
    }

    public function addAction(){
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            if(isset($data['ip'])){
                $whitelist = new DLUserWhitelistIp();
                if($whitelist->create($this->_realUser->getId() , $data['ip'])){
                    $this->successFlash("whitelist_ip_add_successfull");
                    return $this->response->redirect("/user/whitelist/");
                }
            }
        } else {
            $this->errorFlash("cannot_access");
            return $this->response->redirect("/user/whitelist/");
        }
    }

    public function deleteAction(){
        $id = $this->dispatcher->getParam("id");
        if (isset($id)) {
            $whitelist = new DLUserWhitelistIp();
            if($whitelist->delete($id)){
                $this->successFlash("whitelist_ip_delete_successfull");
                return $this->response->redirect("/user/whitelist/");
            }

        } else {
            $this->errorFlash("cannot_access");
            return $this->response->redirect("/user/whitelist/");
        }
    }

}
