<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLProviderGameEndpoint;
use System\Library\General\GlobalVariable;

class EndpointController extends \Backoffice\Controllers\ProtectedController
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
            try {
                $this->db->begin();

                $data = $this->request->getPost();

                $dlProviderGameEndpoint = new DLProviderGameEndpoint();
                $dlGame = new DLGame();
                $game = $dlGame->findFirstById($data['game']);

                $data['provider_game'] = $game['idpv'];
                $data['game_type'] = $game['tp'];

                $filterData = $dlProviderGameEndpoint->filterData($data);
                $dlProviderGameEndpoint->validateCreate($filterData);
                $dlProviderGameEndpoint->create($filterData);

                $this->db->commit();
                $this->flash->success('game_currency_added');
                $this->response->redirect($previousPage->previousPage()."#".$data['tab'])->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }
    }

    public function editAction()
    {
        $previousPage = new GlobalVariable();

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            try {
                $this->db->begin();

                $dlProviderGameEndpoint = new DLProviderGameEndpoint();

                $filterData = $dlProviderGameEndpoint->filterData($data);
                $dlProviderGameEndpoint->validateSet($filterData);
                $dlProviderGameEndpoint->set($filterData);

                $this->db->commit();
                $this->flash->success('game_endpoint_edited');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage() . "#" . $data['tab'])->send();
        }

        \Phalcon\Tag::setTitle("Game Currency - ".$this->_website->title);
    }
}
