<?php
namespace Backoffice\Provider\Controllers;

use System\Datalayer\DLProviderGame;
use System\Library\General\GlobalVariable;

class AddController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        $globalVariable = new GlobalVariable();
        $gmt = $globalVariable->getGmt();

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();

                $DLProviderGame = new DLProviderGame();
                $filterData = $DLProviderGame->filterInput($data);
                $DLProviderGame->validateAdd($filterData);
                $providerGameId = $DLProviderGame->create($filterData);

                $this->db->commit();

                $this->flash->success('provider_game_create_success');
                return $this->response->redirect($this->_module.'/detail/'.$providerGameId)->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }
        $view->gmt = $gmt;

        \Phalcon\Tag::setTitle("Add New Game Provider - ".$this->_website->title);
    }
}
