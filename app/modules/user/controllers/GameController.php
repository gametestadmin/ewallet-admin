<?php
namespace Backoffice\User\Controllers;

use \System\Datalayer\DLUser;
use System\Datalayer\DLUserGame;
use System\Library\General\GlobalVariable;
use System\Library\Security\Agent;

class GameController extends \Backoffice\Controllers\ProtectedController
{
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

        $user = $this->_user;

        $dlUserGame = new DLUserGame();
//        $myGames = $dlUserGame->getAgentGame($user->id,2,0);
        $myGames = $dlUserGame->findUserGame($user->id,2);

        $status = GlobalVariable::$threeLayerStatusTypes;

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $myGames,
//                "limit"=> $limit,
//                "page" => $pages
//            )
//        );
//        $page = $paginator->getPaginate();
//
//        $pagination = ceil($myGames->count()/$limit);
//
//        $view->page = $page->items;
//        $view->pagination = $pagination;
//        $view->pages = $pages;
//        $view->limit = $limit;

        $view->my_games = $myGames;
        $view->status = $status;
        \Phalcon\Tag::setTitle("My Game - ".$this->_website->title);
    }

    public function detailAction()
    {
        $view = $this->view;

        $agentGameId = $this->dispatcher->getParam("id");

        $dlUserGame = new DLUserGame();
        $agentGame = $dlUserGame->getById($agentGameId);
        $status = GlobalVariable::$threeLayerStatusTypes;

        $DLUser = new DLUser();

        $parent = $this->_user;
        $agent = $DLUser->getById($agentGame->getUser());

        $agentSecurity = new Agent();
        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());

        $view->agentGame = $agentGame;
        $view->realParent = $security;
        $view->status = $status;
    }

    public function statusAction()
    {
        $getParam = $this->dispatcher->getParam("id");

        $previousPage = new GlobalVariable();

        $param = explode("|", $getParam);
        $userGameId = $param[0];
        $status = \intval($param[1]);
        $agent = $this->_user;

        if (!isset($userGameId)) {
            $this->flash->error("undefined_user_game_id");
            $this->response->redirect($previousPage->previousPage())->send();
        }

        try {
            $this->db->begin();

            $dlUserGame = new DLUserGame();
//            $userGame = $dlUserGame->getByAgentIdAndGameId($agent->getId(),$gameId);
            $userGame = $dlUserGame->findFirstById($userGameId);

//            $data['status'] = $status;
//            $data['user_game_id'] = $userGame->getId();
//            $data['agent_id'] = $agent->getId();

            $dlUserGame->setAgentGameStatus($userGame->idus,$userGame->id,$status);

//            $dlUserGame->setAgentGameStatus($data['agent_id'],$data['user_game_id'],$data['status']);

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
