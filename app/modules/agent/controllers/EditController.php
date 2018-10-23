<?php
namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLUser;
use System\Library\General\GlobalVariable;
use System\Library\Security\Agent;

class EditController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        $agentId = $this->dispatcher->getParam("id");

        $DLUser = new DLUser();
        $globalVariable = new GlobalVariable();

        $parent = $this->_user;
        $agent = $DLUser->getById($agentId);
        $gmt = $globalVariable->getGmt();

        if(!$agent){
            $this->flash->error("undefined_agent");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        $agentSecurity = new Agent();

        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());
        if($security <> 2){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/agent/list")->send();
        }

//        $parentUsername = \substr($agent->getUsername(), 0, \strlen($parent->getUsername()));
//
//        if($parent->getId() != $agent->getParent()){
//            $this->errorFlash("cannot_access");
//            return $this->response->redirect("/agent/list")->send();
//        }
//
//        if(($parent->getType() <> 0 && $parent->getType() <> 9) && $parent->getUsername() <> $parentUsername) {
//            $this->errorFlash("cannot_access");
//            return $this->response->redirect("/agent/list")->send();
//        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();
                $data = $this->request->getPost();

                $data['id'] = $agentId;
                $data['agent'] = $this->_user;

                $DLUser = new DLUser();
                $filterData = $DLUser->filterInputAgent($data);
                $DLUser->validateEditAgent($filterData);
                $user = $DLUser->setAgent($filterData);

                $this->db->commit();
                $this->flash->success('agent_edit_success');
                return $this->response->redirect("/".$this->_module."/detail/".$user->getId())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }

        }

        $view->agent = $agent;
        $view->gmt = $gmt;

        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
    }
}
