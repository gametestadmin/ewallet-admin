<?php

namespace System\Widgets;

use System\Datalayer\DLGame;
use System\Datalayer\DLUserGame;

class UserGameWidget extends BaseWidget
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function getContent()
    {
        $limit = $this->_limit;
        $pages = $this->_pages;
        if ($this->request->has("pages")){
            $pages = $this->request->get("pages");
        }elseif($this->session->has("pages")){
            $pages = $this->session->get("pages");
        }

        $dlUserGame = new DLUserGame();
        $userGames = $dlUserGame->getAgentGame($this->params["agentId"],2,0);

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $userGames,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $records = $paginator->getPaginate();

        $totalPage = ceil($userGames->count()/$limit);

        return $this->setView('user/game/list', [
            'user_games' => $records->items,
            'total_page' => $totalPage,
            'pages' => $pages,
            'limit' => $limit,
        ]);
    }
}