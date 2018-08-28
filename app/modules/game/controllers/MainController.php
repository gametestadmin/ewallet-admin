<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLCategoryGame;
use System\Datalayer\DLMainGame;
use System\Datalayer\DLProviderGame;

class MainController extends \Backoffice\Controllers\BaseController
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

        $DLProviderGame = new DLProviderGame();
        $providerGame = $DLProviderGame->getAll();
        $DLCategoryGame = new DLCategoryGame();
        $categoryGame = $DLCategoryGame->getAll();

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            try {
                $this->db->begin();

                $DlMainGame = new DLMainGame();
                $DlMainGame->create($data);

                $this->db->commit();

                $this->flash->success('main_game_create_success');
                return $this->response->redirect($this->router->getRewriteUri())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        $view->providerGame = $providerGame;
        $view->categoryGame = $categoryGame;
        \Phalcon\Tag::setTitle("Add New Main Game - ".$this->_website->title);
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
