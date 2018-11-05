<?php
namespace Backoffice\User\Controllers;

use \System\Datalayer\DLUser;
use System\Datalayer\DLUserGame;
use System\Library\General\GlobalVariable;

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
        $myGames = $dlUserGame->getAgentGame($user->getId(),2);

        $status = GlobalVariable::$twoLayerStatus;

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $myGames,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $page = $paginator->getPaginate();

        $pagination = ceil($myGames->count()/$limit);

        $view->page = $page->items;
        $view->pagination = $pagination;
        $view->pages = $pages;
        $view->limit = $limit;

        $view->status = $status;
        \Phalcon\Tag::setTitle("My Game - ".$this->_website->title);
    }
}
