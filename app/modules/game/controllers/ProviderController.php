<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLProviderGame;

class ProviderController extends \Backoffice\Controllers\BaseController
{

    public function indexAction()
    {
        $view = $this->view;

        $providerGame = new DLProviderGame();

        \Phalcon\Tag::setTitle("Game Provider - ".$this->_website->title);
    }

    public function addAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            try {
                $this->db->begin();

                $DLProviderGame = new DLProviderGame();
                $DLProviderGame->create($data);

                $this->db->commit();

                $this->flash->success('provider_game_create_success');
                return $this->response->redirect($this->router->getRewriteUri())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        \Phalcon\Tag::setTitle("Add New Game Provider - ".$this->_website->title);
    }

    public function editAction()
    {
        $view = $this->view;

        $currentId = $this->dispatcher->getParam("id");

        $DLProviderGame = new DLProviderGame();
        $providerGame = $DLProviderGame->getById($currentId);

        if ($this->request->getPost()) {

            $data = $this->request->getPost();

            $data['id'] = $providerGame->getId();

            try {
                $this->db->begin();

                $DLProviderGame->set($data);

                $this->db->commit();

                $this->flash->success('provider_game_update_success');
                return $this->response->redirect($this->router->getRewriteUri())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }
        $view->provider = $providerGame;

        \Phalcon\Tag::setTitle("Update Game Provider - ".$this->_website->title);
    }
}
