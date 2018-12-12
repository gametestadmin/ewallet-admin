<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLUserGame;
use System\Library\General\GlobalVariable;

class CategoryController extends \Backoffice\Controllers\ProtectedController
{
    protected $_type = 1;
    protected $_limit = 10;
    protected $_pages = 1;

    public function indexAction()
    {
        $view = $this->view;

        $limit = $this->_limit;
        $pages = $this->_pages;

        if ($this->request->has("pages")){
            $pages = $this->request->get("pages");

        }elseif($this->session->has("pages")){
            $pages = $this->session->get("pages");

        }

        $dlGame = new DLGame();
        $status = GlobalVariable::$threeLayerStatus;
//        $category = $categoryGame->getAll($this->_type);
        $categories = $dlGame->findGameType(0,$limit,$this->_type);

//        echo "<pre>";
//        foreach ($categories as $category){
//            var_dump($category);
//        }
//        die;

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $category,
//                "limit"=> $limit,
//                "page" => $pages
//            )
//        );
//        $page = $paginator->getPaginate();
//
//        $pagination = ceil($category->count()/$limit);
//        $view->page = $page->items;
//        $view->pagination = $pagination;
//        $view->pages = $pages;
//        $view->limit = $limit;

        $view->categories = $categories;
        $view->status = $status;

        \Phalcon\Tag::setTitle("List Game Category - ".$this->_website->title);
    }

    public function addAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $data['type'] = $this->_type;

            try {
                $this->db->begin();

                $dlGame = new DLGame();
                $filterData = $dlGame->filterData($data);
                $dlGame->validateCategoryCreateData($filterData);
                $category = $dlGame->create($filterData);

                $this->db->commit();

                $this->flash->success('game_category_create_success');
                return $this->response->redirect($this->_module."/".$this->_controller."/detail/".$category['id'])->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
                if(isset($data['url'])){
                    return $this->response->redirect($this->_module."/main/add")->send();
                }
            }
        }

        \Phalcon\Tag::setTitle("Create Game Category - ".$this->_website->title);
    }

    public function editAction()
    {
        $view = $this->view;

        $currentId= $this->dispatcher->getParam("id");

        $dlGame = new DLGame();
        $game = $dlGame->findFirstById($currentId);

        if(!$game){
            $this->flash->error("undefined_game_category_code");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();
                $data['id'] = $currentId;
                $data['type'] = $this->_type;
                $data['id'] = $game['id'];

                $filterData = $dlGame->filterData($data);
                $dlGame->validateCategorySetData($filterData);
                $dlGame->set($filterData);

                $this->db->commit();

                $this->flash->success('game_category_update_success');

            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            return $this->response->redirect("/".$this->_module."/".$this->_controller."/detail/".$game['id'])->send();
        }

        $view->category = $game;

        \Phalcon\Tag::setTitle("Update Game Category - ".$this->_website->title);
    }

    public function detailAction()
    {
        $view = $this->view;

        $currentId = $this->dispatcher->getParam("id");

        $status = GlobalVariable::$threeLayerStatusTypes;

        $dlGame = new DLGame();
        $gameCategory = $dlGame->findFirstById($currentId);

        if(!$gameCategory){
            $this->flash->error("undefined_game_category_code");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        $view->category = $gameCategory;
        $view->status = $status;

        \Phalcon\Tag::setTitle("Game Category Detail - ".$this->_website->title);
    }

    public function statusAction()
    {
        $previousPage = new GlobalVariable();
        $data = $this->dispatcher->getParam("id");

        $data = \explode("|",$data);
        $id = \intval($data[0]);
        $status = \intval($data[1]);

        $dlGame = new DLGame();
        $category = $dlGame->findFirstById($id);

        if(!isset($data) || !$category){
            $this->flash->error("undefined_game");
            $this->response->redirect($this->_module."/".$this->_controller."/")->send();
        }

        try {
            $this->db->begin();

            $dlGame->setStatus($id,$status);

            $gameStatus = 1;
            if($status == 0 || $status == 2){
                $gameStatus = 0;
            }

            $dlUserGame = new DLUserGame();
            $games = $dlGame->findByGameParent($id);

            $subGames = array();
            foreach ($games as $game){
                $subGameRecords = $dlGame->findByGameParent($game['id']);
                $userGames = $dlUserGame->findByGame($game['id']);
                $subGames = $subGameRecords;

                if($game['pvst'] == 0){
                    $gameStatus = 0;
                }
                foreach ($userGames as $userGame){
                    $gameData = array(
                        'id' => $userGame['id'],
                        'gmst' => $gameStatus
                    );
                    $dlUserGame->set($gameData);
                }
            }

            foreach ($subGames as $subGame){
                $userSubGames = $dlUserGame->findByGame($subGame['id']);

                foreach ($userSubGames as $userSubGame){
                    $subGameData = array(
                        'id' => $userSubGame['id'],
                        'gmst' => $gameStatus
                    );
                    $dlUserGame->set($subGameData);
                }
            }

//            foreach ($userGames as $userGame){
//                $postData = array(
//                    'id' => $userGame['id'],
//                    'gmst' => $gameStatus
//                );
//                $dlUserGame->set($postData);
//            }

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
