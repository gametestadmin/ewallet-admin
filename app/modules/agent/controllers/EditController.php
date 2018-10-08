<?php
namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLUser;
use System\Library\General\GlobalVariable;

class EditController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        $userId = $this->dispatcher->getParam("id");

        $DLUser = new DLUser();
        $globalVariable = new GlobalVariable();

        $agent = $DLUser->getById($userId);
        $gmt = $globalVariable->getGmt();

        if(!$agent){
            $this->flash->error("undefined_agent");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();
                $data = $this->request->getPost();

                $data['agent'] = $this->_user;
                $data['id'] = $userId;

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
