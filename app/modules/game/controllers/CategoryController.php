<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Library\General\GlobalVariable;

class CategoryController extends \Backoffice\Controllers\ProtectedController
{
    protected $_type = 1;
    public function indexAction()
    {
        $view = $this->view;

        $categoryGame = new DLGame();
        $status = GlobalVariable::$threeLayerStatus;

        $view->category = $categoryGame->getAll($this->_type);
        $view->status = $status;

        \Phalcon\Tag::setTitle("Game Category - ".$this->_website->title);
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

                $DLGame = new DLGame();
                $filterData = $DLGame->filterCategoryInput($data);
                $DLGame->validateCategoryAdd($filterData);
                $create = $DLGame->createCategory($filterData);

                $this->db->commit();

                $this->flash->success('game_category_create_success');
                return $this->response->redirect($module."/".$controller."/detail/".$create->getCode())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
                if(isset($data['url'])){
                    return $this->response->redirect($module."/main/add")->send();
                }
            }
        }

        \Phalcon\Tag::setTitle("Add New Game Provider - ".$this->_website->title);
    }

    public function editAction()
    {
        $view = $this->view;

        $currentCode = $this->dispatcher->getParam("code");
        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();

        $DLGame = new DLGame();
        $game = $DLGame->getByCode($currentCode, $this->_type);

        if(!$game){
            $this->flash->error("undefined_game_category_code");
            return $this->response->redirect("/".$module."/".$controller)->send();
        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();
                $data['code'] = $currentCode;
                $data['type'] = $this->_type;
                $data['id'] = $game->getId();

                $filterData = $DLGame->filterCategoryInput($data);
                $DLGame->validateCategoryEdit($filterData);
                $DLGame->setCategory($filterData);

                $this->db->commit();

                $this->flash->success('game_category_update_success');
                return $this->response->redirect("/".$module."/".$controller."/detail/".$game->getCode())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
                return $this->response->redirect("/".$module."/".$controller."/detail/".$game->getCode())->send();
            }
        }
        $view->category = $game;

        \Phalcon\Tag::setTitle("Update Game Provider - ".$this->_website->title);
    }

    public function detailAction()
    {
        $view = $this->view;

        $currentCode = $this->dispatcher->getParam("code");
        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();
        $action = $this->router->getActionName();

        $status = GlobalVariable::$threeLayerStatus;

        $DLGame = new DLGame();
        $gameCategory = $DLGame->getByCode($currentCode, $this->_type);
        if(!$gameCategory){
            $this->flash->error("undefined_game_category_code");
            return $this->response->redirect("/".$module."/".$controller)->send();
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

        $DLGame = new DLGame();
        $game = $DLGame->getById($id);
        if(!isset($currentId) || !$game){
            $this->flash->error("undefined_game");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        try {
            $this->db->begin();

            $DLGame->setStatus($id,$status);

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
