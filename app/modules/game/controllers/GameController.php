<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLProviderGame;
use System\Datalayer\DLProviderGameEndpoint;
use System\Datalayer\DLProviderGameIframeUrl;
use System\Datalayer\DLUserGame;
use System\Library\General\GlobalVariable;

class GameController extends \Backoffice\Controllers\ProtectedController
{
    protected $_categoryType = 1;
    protected $_type = 2;
    protected $_limit = 100;
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
        $status = GlobalVariable::$threeLayerStatusTypes;
        $games = $dlGame->findGameType(0,$limit,$this->_type);

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $main,
//                "limit"=> $limit,
//                "page" => $pages
//            )
//        );
//        $page = $paginator->getPaginate();
//
//        $pagination = ceil($main->count()/$limit);
//        $view->page = $page->items;
//        $view->pagination = $pagination;
//        $view->pages = $pages;
//        $view->limit = $limit;

        $view->games = $games;
        $view->status = $status;

        \Phalcon\Tag::setTitle("Game Category - ".$this->_website->title);
    }

    public function addAction()
    {
        $view = $this->view;

        $dlProviderGame = new DLProviderGame();
        $providerGame = $dlProviderGame->findByStatus(1);

        $dlGame = new DLGame();
        $categoryGame = $dlGame->findByTypeAndStatus($this->_categoryType,1);

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();

                $category = $dlGame->findByCode($this->_categoryType,$data['category']);

                $data['parent'] = $category['id'];
                $data['type'] = $this->_type;

                $filterData = $dlGame->filterData($data);
                $dlGame->validateGameCreateData($filterData);
                $game = $dlGame->create($filterData);

                $this->db->commit();

                $this->flash->success('main_game_create_success');
                return $this->response->redirect("/".$this->_module."/".$this->_controller."/detail/".$game['id'])->send();
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

        $dlGame = new DLGame();
        $game = $dlGame->findFirstById($currentId);
        $gameCategory = $dlGame->findFirstById($game['idp']);

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();
                $data['id'] = $game['id'];
                $data['status'] = $game['st'];
                $data['parent_status'] = $game['stp'];

                $filterData = $dlGame->filterData($data);
                $dlGame->validateGameSetData($filterData);
                $dlGame->set($filterData);

                $this->db->commit();

                $this->flash->success('main_game_update_success');
                return $this->response->redirect("/".$this->_module."/".$this->_controller."/detail/".$game['id'])->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }
        $view->game = $game;
        $view->gameCategory = $gameCategory;

        \Phalcon\Tag::setTitle("Update Game - ".$this->_website->title);
    }

    public function detailAction()
    {
        $view = $this->view;

        $currentId = $this->dispatcher->getParam("id");

        $status = GlobalVariable::$threeLayerStatusTypes;

        $dlGame = new DLGame();
        $game = $dlGame->findFirstById($currentId);

        $dlGameCurrency = new DLGameCurrency();
//        $gameCurrency = $dlGameCurrency->getAll($game['id']);
        $gameCurrency = $dlGameCurrency->findByGame($game['id']);

        $dlProviderEndPoint = new DLProviderGameEndpoint();
//        $endPoint = $dlProviderEndPoint->getAll($game['id']);
        $endPoint = $dlProviderEndPoint->findByGame($game['id']);

        $dlProviderGameIframeUrl = new DLProviderGameIframeUrl();
        $iframeUrl = $dlProviderGameIframeUrl->findByGame($game['id']);

        if(!$game){
            $this->flash->error("undefined_game_code");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        $view->game = $game;
        $view->status = $status;
        $view->gameCurrencyData = $gameCurrency;
        $view->providerEndPointData = $endPoint;
        $view->providerIframe = $iframeUrl;

        \Phalcon\Tag::setTitle("Update Game - ".$this->_website->title);
    }

    public function statusAction()
    {
        $data = $this->dispatcher->getParam("id");
        $previousPage = new GlobalVariable();

        $data = explode("|",$data);
        $id = $data[0];
        $status = $data[1];

        $dlGame = new DLGame();
        $game = $dlGame->findFirstById($id);

        if(!isset($data) || !$game){
            $this->flash->error("undefined_game");
            $this->response->redirect($this->_module."/".$this->_controller."/")->send();
        }

        try {
            $this->db->begin();

            $dlUserGame = new DLUserGame();

            $dlGame->setStatus($id,$status);

            $gameStatus = 1;
            if($status == 0 || $status == 2 || $game['pvst'] == 0){
                $gameStatus = 0;
            }

            $userGames = $dlUserGame->findByGame($id);

            foreach ($userGames as $userGame){
                $gameParent = $dlGame->findFirstById($game['idp']);
                if($gameParent['st'] == 0){
                    $gameStatus = 0;
                }
                $postData = array(
                    'id' => $userGame['id'],
                    'gmst' => $gameStatus
                );
                $dlUserGame->set($postData);
            }

            $subGames = $dlGame->findByGameParent($id);
            foreach ($subGames as $subGame){
                $userSubGames = $dlUserGame->findByGame($subGame['id']);
//                if($game['st'] == 0){
//                    $gameStatus = 0;
//                }
                foreach ($userSubGames as $userSubGame){
                    $postData = array(
                        'id' => $userSubGame['id'],
                        'gmst' => $gameStatus
                    );
                    $dlUserGame->set($postData);
                }
            }

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }

        \Phalcon\Tag::setTitle("Update Game Status - ".$this->_website->title);
    }
}