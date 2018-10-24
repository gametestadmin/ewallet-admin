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
        $dlGame = new DLGame();
        $games = $dlGame->getAll(2);
        $userGames = $dlUserGame->getAgentGame($this->params["agentId"]);

//        echo "<pre>";
//        var_dump($this->params);
//        if(count($userGames) > 0) {
//            foreach ($userGames as $userGame) {
//                var_dump($userGame->getGame());
//            }
//        }else{
//            foreach ($games as $game){
//                var_dump($game->getName());
//            }
//        }
//        die;

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
            'user_game' => $records->items,
            'total_page' => $totalPage,
            'pages' => $pages,
            'limit' => $limit,
        ]);
    }
}