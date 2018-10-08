<?php
namespace Backoffice\Agent\Controllers;

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
                if($this->_allowed == 0){
                    return $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
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
        $currentId = $this->dispatcher->getParam("id");

        $DLUserWhitelistIp = new DLUserWhitelistIp();

        try {
            $this->db->begin();

            $DLUserWhitelistIp->delete($currentId);

            $this->db->commit();
            $this->flash->success("ip_deleted");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
