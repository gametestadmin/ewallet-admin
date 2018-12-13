<?php
namespace Backoffice\Downline\Controllers;

use System\Datalayer\DLUser;
use System\Library\General\GlobalVariable;
use System\Library\Security\Agent;

class NicknameController extends \Backoffice\Controllers\ProtectedController
{
    public function resetAction()
    {
        $view = $this->view;

        $previousPage = new GlobalVariable();
        $agentId = $this->dispatcher->getParam("id");

        $DLUser = new DLUser();
        $parent = $this->_user;
        $agent = $DLUser->getById($agentId);

        if(!isset($agentId) || !$agent){
            $this->flash->error("notification_undefined_downline");
            $this->response->redirect($this->_module."/".$this->_controller."/")->send();
        }

        $agentSecurity = new Agent();

        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());
        if($security <> 1 && $security <> 3){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/".$this->_module."/list")->send();
        }

//        if($parent->getId() != $agent->getParent()){
//            $this->errorFlash("cannot_access");
//            return $this->response->redirect("/agent/list")->send();
//        }
//        $parentUsername = \substr($agent->getUsername(), 0, \strlen($parent->getUsername()));
//
//        if(($parent->getType() <> 0 && $parent->getType() <> 9) && $parent->getUsername() <> $parentUsername) {
//            $this->errorFlash("cannot_access");
//            return $this->response->redirect("/agent/list")->send();
//        }

        try {
            $this->db->begin();

            $DLUser->resetNickname($agentId);

            $this->db->commit();
            $this->flash->success("notification_downline_reset_nickname_success");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
