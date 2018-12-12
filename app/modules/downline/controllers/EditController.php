<?php
namespace Backoffice\Downline\Controllers;

use System\Datalayer\DLUser;
use System\Library\General\GlobalVariable;
use System\Library\Security\Agent;

class EditController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        $agentId = $this->dispatcher->getParam("id");

        $dlUser = new DLUser();
        $globalVariable = new GlobalVariable();

        $parent = $this->_user;
        $agent = $dlUser->findFirstById($agentId);
        $gmt = $globalVariable->getGmt();

        if(!$agent){
            $this->flash->error("notification_undefined_downline");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        $agentSecurity = new Agent();

        $security = $agentSecurity->checkAgentAction($parent->username,$agent->sn);
        if($security <> 1 && $security <> 3){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/".$this->_module."/list")->send();
        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();
                $data = $this->request->getPost();

                $data['id'] = $agentId;
//                $data['agent'] = $this->_user;

                $filterData = $dlUser->filterInputAgentData($data);
                $dlUser->validateEditAgentData($filterData);
                $dlUser->set($filterData);

                $this->db->commit();
                $this->flash->success('notification_downline_set_success');
                return $this->response->redirect("/".$this->_module."/detail/".$agent['id'])->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }

        }

        $view->agent = $agent;
        $view->gmt = $gmt;
        $view->realParent = $security;

        \Phalcon\Tag::setTitle("Downline System - ".$this->_website->title);
    }
}
