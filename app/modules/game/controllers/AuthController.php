<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLProviderGame;
use System\Datalayer\DLProviderGameEndpoint;
use System\Datalayer\DLProviderGameEndpointAuth;
use System\Library\General\GlobalVariable;

class AuthController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            $action = $this->request->get('action');

            var_dump(3);die;
        }

        \Phalcon\Tag::setTitle("Game Currency - ".$this->_website->title);
    }

    public function addAction()
    {
        $previousPage = new GlobalVariable();

        if ($this->request->getPost()) {

            $data = $this->request->getPost();

            try {
                $this->db->begin();

                if($this->_allowed == 0){
                    return $this->response->redirect($previousPage->previousPage()."#".$data['tab'])->send();
                }

                $dlProviderGameEndpointAuth = new DLProviderGameEndpointAuth();
                $dlGame = new DLGame();

                $game = $dlGame->findFirstById($data['game']);
                $data['provider_game'] = $game['idpv'];

                $filterData = $dlProviderGameEndpointAuth->filterData($data);
                $dlProviderGameEndpointAuth->validateCreate($filterData);
                $dlProviderGameEndpointAuth->create($filterData);

                $this->db->commit();
                $this->flash->success('game_auth_added');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage()."#".$data['tab'])->send();
        }
    }

    public function editAction()
    {
        $previousPage = new GlobalVariable();

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            try {
                $this->db->begin();

                $dlProviderGameEndpointAuth = new DLProviderGameEndpointAuth();

                $filterData = $dlProviderGameEndpointAuth->filterData($data);
                $dlProviderGameEndpointAuth->validateSet($filterData);
                $dlProviderGameEndpointAuth->set($filterData);

                $this->db->commit();
                $this->flash->success('game_auth_edited');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage()."#".$data['tab'])->send();
        }

        \Phalcon\Tag::setTitle("Game Auth - ".$this->_website->title);
    }
}
