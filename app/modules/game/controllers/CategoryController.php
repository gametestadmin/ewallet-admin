<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLCategoryGame;
use System\Datalayer\DLGame;
use System\Datalayer\DLMainGame;
use System\Datalayer\DLProviderGame;
use System\Library\General\GlobalVariable;

class CategoryController extends \Backoffice\Controllers\BaseController
{
    protected $_type = 1;
    public function indexAction()
    {
        $DLGame = new DLMainGame();

        var_dump($DLGame->myRecursiveFunction());
        die;
//        $view = $this->view;
//
//        $categoryGame = new DLGame();
//        $status = GlobalVariable::$threeLayerStatus;
//
//        $view->category = $categoryGame->getAll($this->_type);
//        $view->status = $status;

        \Phalcon\Tag::setTitle("Game Provider - ".$this->_website->title);
    }

    public function addAction()
    {
        $view = $this->view;

        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $data['type'] = $this->_type;

            try {
                $this->db->begin();

                $DLProviderGame = new DLGame();
                $DLProviderGame->createCategory($data);

                $this->db->commit();

                $this->flash->success('game_category_create_success');
                return $this->response->redirect($module."/".$controller)->send();
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

    public function detailAction()
    {
        $view = $this->view;

        $currentCode = $this->dispatcher->getParam("code");
        $status = GlobalVariable::$threeLayerStatus;

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
        $view->status = $status;

        \Phalcon\Tag::setTitle("Update Game Provider - ".$this->_website->title);
    }

    public function statusAction()
    {
        $view = $this->view;

        $previousPage = new GlobalVariable();
        $currentId = $this->dispatcher->getParam("id");

        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();

        $currentId = explode("|",$currentId);
        $id = $currentId[0];
        $status = $currentId[1];

        $DLMain = new DLMainGame();
        $mainGame = $DLMain->getById($id);
        if(!isset($currentId) || !$mainGame){
            $this->flash->error("undefined_provider_id");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        try {
            $this->db->begin();

            $data['id'] = $id;
            $data['status'] = $status;

            $mainGame->set($data);

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }

        \Phalcon\Tag::setTitle("Edit Currency - ".$this->_website->title);
    }
}
