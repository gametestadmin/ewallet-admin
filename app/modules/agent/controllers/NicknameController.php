<?php
namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLUser;
use System\Library\General\GlobalVariable;

class NicknameController extends \Backoffice\Controllers\ProtectedController
{
    public function resetAction()
    {
        $view = $this->view;

        $previousPage = new GlobalVariable();
        $agentId = $this->dispatcher->getParam("id");

        $DLUser = new DLUser();
        $agent = $DLUser->getById($agentId);
        $parent = $this->_user;

        if(!isset($agentId) || !$agent){
            $this->flash->error("undefined_agent");
            $this->response->redirect($this->_module."/".$this->_controller."/")->send();
        }

        if($parent->getId() != $agent->getParent()){
            $this->errorFlash("cannot_access");
            return $this->response->redirect("/agent/list")->send();
        }
        $parentUsername = \substr($agent->getUsername(), 0, \strlen($parent->getUsername()));

        if(($parent->getType() <> 0 && $parent->getType() <> 9) && $parent->getUsername() <> $parentUsername) {
            $this->errorFlash("cannot_access");
            return $this->response->redirect("/agent/list")->send();
        }

        try {
            $this->db->begin();

            $DLUser->resetNickname($agentId);

            $this->db->commit();
            $this->flash->success("reset_nickname_success");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
