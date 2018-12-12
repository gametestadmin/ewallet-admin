<?php
namespace Backoffice\Downline\Controllers;

use System\Datalayer\DLUser;
use System\Datalayer\DLUserCurrency;
use System\Library\General\GlobalVariable;
use System\Library\Security\Agent;

class CurrencyController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            $action = $this->request->get('action');

            var_dump(3);die;
        }

        \Phalcon\Tag::setTitle("Downline Currency - ".$this->_website->title);
    }

    public function addAction()
    {
        $previousPage = new GlobalVariable();

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();
                $tab = $data['tab'];
                $userId = $data['user'];

                $DLUser = new DLUser();
                $parent = $this->_user;
                $agent = $DLUser->findFirstById($userId);

                $agentSecurity = new Agent();
                $security = $agentSecurity->checkAgentAction($parent->username,$agent->sn);

                if($security <> 1 && $security <> 3){
                    $this->errorFlash("cannot_access_security");
                    return $this->response->redirect("/".$this->_module."/list")->send();
//                    return $this->response->redirect($previousPage->previousPage())->send();
                }

                $dlUserCurrency = new DLUserCurrency();

                $filterData = $dlUserCurrency->filterData($data);
//                $DLUserCurrency->validateAdd($filterData);
                $dlUserCurrency->create($filterData['idus'],$filterData['idcu']);

                $this->db->commit();
                $this->flash->success('notification_downline_create_currency_success');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
        }

        \Phalcon\Tag::setTitle("Create Downline Currency - ".$this->_website->title);
    }

    public function editAction()
    {
        $previousPage = new GlobalVariable();

        $data["agent_id"] = \intval($this->dispatcher->getParam("id"));
        $data["id"] = \intval($this->request->get("default"));
        $tab = $this->request->get("tab");

        $dlUser = new DLUser();

        $parent = $this->_user;
        $agent = $dlUser->findFirstById($data['agent_id']);

        $agentSecurity = new Agent();
        $security = $agentSecurity->checkAgentAction($parent->username,$agent->sn);

        if($security <> 1 && $security <> 3){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect($previousPage->previousPage())->send();
        }

//        if($this->_allowed == 0){
//            return $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
//        }
        try {
            $this->db->begin();

            $dlUserCurrency = new DLUserCurrency();

            $dlUserCurrency->setDefault($data['id'],$data['agent_id']);
//            $dlUserCurrency->set($data);

            $this->db->commit();
            $this->flash->success('notification_downline_set_currency_success');
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
        $this->response->redirect($previousPage->previousPage()."#".$tab)->send();

        \Phalcon\Tag::setTitle("Update Downline Currency - ".$this->_website->title);
    }

    public function deleteAction()
    {
        $previousPage = new GlobalVariable();

        $data["agent_id"] = \intval($this->dispatcher->getParam("id"));
        $data["id"] = \intval($this->request->get("delete"));
        $tab = $this->request->get("tab");

        $dlUser = new DLUser();
        $parent = $this->_user;
        $agent = $dlUser->findFirstById($data['agent_id']);

        $agentSecurity = new Agent();
        $security = $agentSecurity->checkAgentAction($parent->username,$agent->sn);

        if($security <> 1 && $security <> 3){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect($previousPage->previousPage())->send();
        }

//        if($this->_allowed == 0){
//            return $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
//        }
        try {
            $this->db->begin();

            $dlUserCurrency = new DLUserCurrency();

            $dlUserCurrency->delete($data);

            $this->db->commit();
            $this->flash->success('notification_downline_remove_currency_success');
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
        $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
    }
}
