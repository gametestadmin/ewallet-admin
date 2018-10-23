<?php
namespace Backoffice\Provider\Controllers;

use System\Datalayer\DLProviderGame;
use System\Library\General\GlobalVariable;

class StatusController extends \Backoffice\Controllers\ProtectedController
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function indexAction()
    {
        $view = $this->view;

        $previousPage = new GlobalVariable();
        $currentId = $this->dispatcher->getParam("id");

        $currentId = explode("|",$currentId);
        $id = $currentId[0];
        $status = $currentId[1];

        $DLProviderGame = new DLProviderGame();
        $providerGame = $DLProviderGame->getById($id);
        if(!isset($currentId) || !$providerGame){
            $this->flash->error("undefined_provider_id");
            $this->response->redirect($previousPage->previousPage())->send();
        }

        try {
            $this->db->begin();

            $data['id'] = $id;
            $data['status'] = $status;

            $DLProviderGame->set($data);

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
