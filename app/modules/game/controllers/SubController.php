<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLCurrency;
use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLProviderGame;
use System\Datalayer\DLUserGame;
use System\Library\General\GlobalVariable;

class SubController extends \Backoffice\Controllers\ProtectedController
{
    protected $_categoryType = 1;
    protected $_gameType = 2;
    protected $_type = 3;
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
        $status = GlobalVariable::$threeLayerStatusTypes;
        $subGames = $dlGame->findGameType(0,$limit,$this->_type);

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $sub,
//                "limit"=> $limit,
//                "page" => $pages
//            )
//        );
//        $page = $paginator->getPaginate();
//
//        $pagination = ceil($sub->count()/$limit);
//        $view->page = $page->items;
//        $view->pagination = $pagination;
//        $view->pages = $pages;
//        $view->limit = $limit;

        $view->subGames = $subGames;
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
        $game = $dlGame->findByTypeAndStatus($this->_gameType,1);

        if ($this->request->getPost()) {
            try {
                $this->db->begin();
                $data = $this->request->getPost();

                $mainGame = $dlGame->findByCode($this->_gameType,$data['game_code']);

                $data['parent'] = $mainGame['id'];
                $data['type'] = $this->_type;

                $filterData = $dlGame->filterData($data);
//                echo "<pre>";
//                var_dump($data);
//                echo "<br>";
//                var_dump($filterData);
//                die;
                $dlGame->validateSubCreateData($filterData);
                $subGame = $dlGame->create($filterData);
//                var_dump($subGame);
//                die;

                if($subGame && $data['parent_currency'] == 1){
                    $subGameData = $dlGame->findFirstById($subGame['id']);
                    $gameCurrency = new DLGameCurrency();
                    $gameCurrency->setFromParent($subGameData['idp'],$subGame['id']);
                }

                $this->db->commit();

                $this->flash->success('sub_game_create_success');
                return $this->response->redirect("/".$this->_module."/".$this->_controller."/detail/".$subGame['id'])->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        $view->providerGame = $providerGame;
        $view->categoryGame = $categoryGame;
        $view->game = $game;

        \Phalcon\Tag::setTitle("Add New Sub-Game - ".$this->_website->title);
    }

    public function editAction()
    {
        $view = $this->view;

        $currentId = $this->dispatcher->getParam("id");

        $dlGame = new DLGame();
        $subGame = $dlGame->findFirstById($currentId);
        $game = $dlGame->findFirstById($subGame['idp']);

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();
//                $data['main_code'] = $currentId;
                $data['type'] = $this->_type;
                $data['id'] = $subGame['id'];

                $filterData = $dlGame->filterData($data);
                $dlGame->validateSubSetData($filterData);
                $dlGame->set($filterData);

                $this->db->commit();

                $this->flash->success('main_game_update_success');
                return $this->response->redirect("/".$this->_module."/".$this->_controller."/detail/".$subGame['id'])->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }
        $view->subGame = $subGame;
        $view->game = $game;

        \Phalcon\Tag::setTitle("Update Sub-Game - ".$this->_website->title);
    }

    public function detailAction()
    {
        $view = $this->view;

        $currentId = $this->dispatcher->getParam("id");

        $status = GlobalVariable::$threeLayerStatusTypes;

        $DLCurrency = new DLCurrency();
        $currency = $DLCurrency->findAllByStatus(1);

        $dlGame = new DLGame();
        $game = $dlGame->findFirstById($currentId);
        $gameParent = $dlGame->findFirstById($game['idp']);

        $dlProviderGame = new DLProviderGame();
        $providerGame = $dlProviderGame->findFirstById($game['idpv']);

        $DLGameCurrency = new DLGameCurrency();
        $gameCurrency = $DLGameCurrency->findByGame($game['id']);
        $gameCurrencyData = count($gameCurrency);

        if(!$game){
            $this->flash->error("undefined_game_code");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        $view->providerGame = $providerGame;
        $view->game = $game;
        $view->gameParent = $gameParent;
        $view->status = $status;
        $view->gameCurrencyData = $gameCurrencyData;
        $view->gameCurrency = $gameCurrency;

        \Phalcon\Tag::setTitle("Update Sub-Game - ".$this->_website->title);
    }

    public function statusAction()
    {
        $previousPage = new GlobalVariable();
        $data = $this->dispatcher->getParam("id");

        $data = explode("|",$data);
        $id = $data[0];
        $status = $data[1];

        $dlGame = new dlGame();
        $game = $dlGame->findFirstById($id);

        if(!isset($data) || !$game){
            $this->flash->error("undefined_game");
            $this->response->redirect($this->_module."/".$this->_controller."/")->send();
        }

        try {
            $this->db->begin();

            $dlGame->setStatus($id,$status);

            $gameStatus = 1;
            if($status == 0 || $status == 2 || $game['pvst'] == 0){
                $gameStatus = 0;
            }

            $dlUserGame = new DLUserGame();
            $userGames = $dlUserGame->findByGame($id);

            foreach ($userGames as $userGame){
                $postData = array(
                    'id' => $userGame['id'],
                    'gmst' => $gameStatus
                );
                $dlUserGame->set($postData);
            }

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }

        \Phalcon\Tag::setTitle("Update Sub-Game Status - ".$this->_website->title);
    }
}
