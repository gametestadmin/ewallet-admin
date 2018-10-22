<?php
namespace Backoffice\Agent\Controllers;

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

        \Phalcon\Tag::setTitle("User Currency - ".$this->_website->title);
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
                $agent = $DLUser->getById($userId);

                $agentSecurity = new Agent();
                $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());

                if($security <> 2){
                    $this->errorFlash("cannot_access_security");
                    return $this->response->redirect("/agent/list")->send();
                }

                $DLUserCurrency = new DLUserCurrency();

                $filterData = $DLUserCurrency->filterInput($data);
                $DLUserCurrency->validateAdd($filterData);
                $DLUserCurrency->create($filterData['user'],$filterData['currency']);

                $this->db->commit();
                $this->flash->success('user_currency_added');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
        }

        \Phalcon\Tag::setTitle("User Currency - ".$this->_website->title);
    }

    public function editAction()
    {
        $previousPage = new GlobalVariable();

        $data["agent_id"] = $this->dispatcher->getParam("id");
        $data["currency_id"] = $this->request->get("default");
        $tab = $this->request->get("tab");

        $userId = $data['agent_id'];

        $DLUser = new DLUser();
        $parent = $this->_user;
        $agent = $DLUser->getById($userId);

        $agentSecurity = new Agent();
        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());

        if($security <> 2){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/agent/list")->send();
        }

        if($this->_allowed == 0){
            return $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
        }
        try {
            $this->db->begin();

            $DLUserCurrency = new DLUserCurrency();

            $DLUserCurrency->set($data);

            $this->db->commit();
            $this->flash->success('user_currency_default');
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
        $this->response->redirect($previousPage->previousPage()."#".$tab)->send();

        \Phalcon\Tag::setTitle("User Currency - ".$this->_website->title);
    }

    public function deleteAction()
    {
        $previousPage = new GlobalVariable();

        $data["agent_id"] = $this->dispatcher->getParam("id");
        $data["currency_id"] = $this->request->get("delete");
        $tab = $this->request->get("tab");

        $DLUser = new DLUser();
        $parent = $this->_user;
        $agent = $DLUser->getById($data['agent_id']);

        $agentSecurity = new Agent();
        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());

        if($security <> 2){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/agent/list")->send();
        }

        if($this->_allowed == 0){
            return $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
        }
        try {
            $this->db->begin();

            $DLUserCurrency = new DLUserCurrency();

            $DLUserCurrency->delete($data);

            $this->db->commit();
            $this->flash->success('user_currency_remove');
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
        $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
    }
}
