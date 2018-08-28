<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLCategoryGame;
use System\Datalayer\DLProviderGame;

class CategoryController extends \Backoffice\Controllers\BaseController
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

                $DLProviderGame = new DLCategoryGame();
                $DLProviderGame->create($data);

                $this->db->commit();

                $this->flash->success('game_category_create_success');
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

        $currentCode = $this->dispatcher->getParam("code");

        $DLGameCategory = new DLCategoryGame();
        $gameCategory = $DLGameCategory->getByCode($currentCode);
        if(!$gameCategory){
            $this->flash->error("undefined_game_category_code");
            $this->response->redirect("/game/category")->send();
        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $module = $this->router->getModuleName();
                $controller = $this->router->getControllerName();
                $action = $this->router->getActionName();

                $data = $this->request->getPost();
                $data['code'] = $currentCode;
                $data['id'] = $gameCategory->getId();

                $setGameCategory = $DLGameCategory->set($data);

                $this->db->commit();

                $this->flash->success('game_category_update_success');
                return $this->response->redirect("/".$module."/".$controller."/".$action."/".$setGameCategory->getCode())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }
        $view->category = $gameCategory;

        \Phalcon\Tag::setTitle("Update Game Provider - ".$this->_website->title);
    }
}
