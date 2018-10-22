<?php
namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLUser;
use System\Library\General\GlobalVariable;
use System\Library\Security\Agent;

class StatusController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        $previousPage = new GlobalVariable();
        $currentId = $this->dispatcher->getParam("id");

        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();

        $currentId = explode("|",$currentId);
        $id = $currentId[0];
        $status = $currentId[1];

        $DLUser = new DLUser();
        $parent = $this->_user;
        $agent = $DLUser->getById($id);

        if(!isset($currentId) || !$agent){
            $this->flash->error("undefined_agent");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        $agentSecurity = new Agent();

        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());
        if($security <> 2){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/agent/list")->send();
        }

//        $parentUsername = \substr($user->getUsername(), 0, \strlen($parent->getUsername()));
//
//        if($parent->getId() != $user->getParent()){
//            $this->errorFlash("cannot_access");
//            return $this->response->redirect("/agent/list")->send();
//        }
//
//        if(($parent->getType() <> 0 && $parent->getType() <> 9) && $parent->getUsername() <> $parentUsername) {
//            $this->errorFlash("cannot_access");
//            return $this->response->redirect("/agent/list")->send();
//        }

        try {
            $this->db->begin();

            $DLUser->setAgentStatus($id,$status);

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
