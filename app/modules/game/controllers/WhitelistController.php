<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameWhitelistIp;
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
            $data = $this->request->getPost();
            try {
                $this->db->begin();
//                if($this->_allowed == 0){
//                    return $this->response->redirect($previousPage->previousPage()."#".$data['tab'])->send();
//                }

                $dlGameWhitelistIp = new DLGameWhitelistIp();

                $filterData = $dlGameWhitelistIp->filterData($data);
                $dlGameWhitelistIp->validateCreate($filterData);
                $dlGameWhitelistIp->create($filterData);

                $this->db->commit();
                $this->flash->success('game_whitelist_ip_created');

            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage()."#".$data['tab'])->send();
        }
    }

//    public function editAction()
//    {
//        $previousPage = new GlobalVariable();
//
//        if ($this->request->getPost()) {
//            $data = $this->request->getPost();
//            $tab = $data['tab'];
//
//            try {
//                $this->db->begin();
//
//                $DLProviderGameEndpoint = new DLGameWhitelistIp();
//
//                $filterData = $DLProviderGameEndpoint->filterInput($data);
//                $DLProviderGameEndpoint->validateEdit($filterData);
//                $DLProviderGameEndpoint->set($data);
//
//                $this->db->commit();
//                $this->flash->success('game_whitelist_ip_edited');
//            } catch (\Exception $e) {
//                $this->db->rollback();
//                $this->flash->error($e->getMessage());
//            }
//            $this->response->redirect($previousPage->previousPage() . "#" . $tab)->send();
//        }
//    }

    public function deleteAction()
    {
        $previousPage = new GlobalVariable();
        $data["game_id"] = $this->dispatcher->getParam("id");
        $data["whitelist_id"] = $this->request->get("delete");

        $dlGameWhitelistIp = new DLGameWhitelistIp();

        // TODO :: Temporary Code
//        if($this->_user->getType() != 9){
        if($this->_user->tp != 9){
            $this->flash->error("cannot_access");
            return $this->response->redirect($previousPage->previousPage() . "#tab-ip")->send();
        }

        try {
            $this->db->begin();

            $dlGameWhitelistIp->delete($data["whitelist_id"]);

            $this->db->commit();
            $this->flash->success("ip_deleted");
            $this->response->redirect($previousPage->previousPage() . "#tab-ip")->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
