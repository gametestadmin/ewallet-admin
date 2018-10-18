<?php
namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLUser;
use System\Library\General\GlobalVariable;

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
        $user = $DLUser->getById($id);
        if(!isset($currentId) || !$user){
            $this->flash->error("undefined_agent");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        $parent = $this->_user;
        $agent = $DLUser->getById($this->_user->getId());

//        $agentSecurity = new Agent();
//        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$parent->getType(),$user->getUsername(),1);
//        if($security == false){
//            $this->errorFlash("cannot_access1");
//            return $this->response->redirect("/agent/list")->send();
//        }

        $parentUsername = \substr($user->getUsername(), 0, \strlen($parent->getUsername()));

        if($parent->getId() != $user->getParent()){
            $this->errorFlash("cannot_access");
            return $this->response->redirect("/agent/list")->send();
        }

        if(($parent->getType() <> 0 && $parent->getType() <> 9) && $parent->getUsername() <> $parentUsername) {
            $this->errorFlash("cannot_access");
            return $this->response->redirect("/agent/list")->send();
        }

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
