<?php
namespace Backoffice\Downline\Controllers;

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

        $currentId = \explode("|",$currentId);
        $id = \intval($currentId[0]);
        $status = \intval($currentId[1]);

        $dlUser = new DLUser();
        $parent = $this->_user;
        $agent = $dlUser->findFirstById($id);

        if(!isset($currentId) || !$agent){
            $this->flash->error("notification_undefined_downline");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        $agentSecurity = new Agent();

        $security = $agentSecurity->checkAgentAction($parent->username,$agent->sn);
        if($security <> 1 && $security <> 3){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/".$this->_module."/list")->send();
        }

        try {
            $this->db->begin();

            $dlUser->setAgentStatus($id,$status);

            $this->db->commit();
            $this->flash->success("notification_downline_set_status");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
