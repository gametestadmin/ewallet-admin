<?php
namespace Backoffice\Provider\Controllers;

use System\Datalayer\DLProviderGame;
use System\Library\General\GlobalVariable;

class EditController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        $globalVariable = new GlobalVariable();

        $gmt = $globalVariable->getGmt();

        $currentId = $this->dispatcher->getParam("id");

        $dlProviderGame = new DLProviderGame();
        $providerGame = $dlProviderGame->findFirstById($currentId);

        if(!isset($currentId) || !$providerGame){
            $this->flash->error("undefined_provider_id");
            $this->response->redirect($this->_module."/".$this->_controller."/")->send();
        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();

                $data['id'] = $providerGame['id'];

                $filterData = $dlProviderGame->filterData($data);
                $dlProviderGame->validateSetData($filterData);
                $dlProviderGame->set($filterData);

                $this->db->commit();

                $this->flash->success('provider_game_update_success');

                return $this->response->redirect($this->_module.'/detail/'.$providerGame['id'])->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }
        $view->provider = $providerGame;
        $view->gmt = $gmt;

        \Phalcon\Tag::setTitle("Update Game Provider - ".$this->_website->title);
    }
}
