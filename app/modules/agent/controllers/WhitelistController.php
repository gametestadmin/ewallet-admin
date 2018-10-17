<?php
namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLUser;
use System\Datalayer\DLUserWhitelistIp;
use System\Library\General\GlobalVariable;

class WhitelistController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            $action = $this->request->get('action');

            var_dump(3);die;
        }
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
//                if($this->_allowed == 0){
//                    return $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
//                }

                $DLUser = new DLUser();
                $parent = $this->_user;
                $agent = $DLUser->getById($userId);

                if($parent->getId() != $agent->getParent()){
                    $this->errorFlash("cannot_access");
                    return $this->response->redirect("/agent/list")->send();
                }

                $DLUserWhitelistIp = new DLUserWhitelistIp();

                $filterData = $DLUserWhitelistIp->filterInput($data);
                $DLUserWhitelistIp->validateAdd($filterData);
                $DLUserWhitelistIp->create($filterData['user'],$filterData['ip']);

                $this->db->commit();
                $this->flash->success('user_whitelist_ip_created');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
        }
    }

    public function editAction()
    {
        $previousPage = new GlobalVariable();

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $tab = $data['tab'];
            $userId = $data['user'];

            $DLUser = new DLUser();
            $parent = $this->_user;
            $agent = $DLUser->getById($userId);

            if($parent->getId() != $agent->getParent()){
                $this->errorFlash("cannot_access");
                return $this->response->redirect("/agent/list")->send();
            }

            try {
                $this->db->begin();

                $DLUserWhitelistIp = new DLUserWhitelistIp();

                $filterData = $DLUserWhitelistIp->filterInput($data);
                $DLUserWhitelistIp->validateEdit($filterData);
                $DLUserWhitelistIp->set($data);

                $this->db->commit();
                $this->flash->success('user_whitelist_ip_edited');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage() . "#" . $tab)->send();
        }
    }

    public function deleteAction()
    {
        $previousPage = new GlobalVariable();
//        $currentId = $this->dispatcher->getParam("id");
        $data["agent_id"] = $this->dispatcher->getParam("id");
        $data["whitelist_id"] = $this->request->get("delete");

        $userId = $data['agent_id'];

        $DLUser = new DLUser();
        $parent = $this->_user;
        $agent = $DLUser->getById($userId);

        if($parent->getId() != $agent->getParent()){
            $this->errorFlash("cannot_access");
            return $this->response->redirect("/agent/list")->send();
        }

        $DLUserWhitelistIp = new DLUserWhitelistIp();

        try {
            $this->db->begin();

            $DLUserWhitelistIp->delete($data["whitelist_id"]);

            $this->db->commit();
            $this->flash->success("ip_deleted");
            $this->response->redirect($previousPage->previousPage() . "#tab-ip")->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
