<?php

namespace System\Widgets;

use System\Datalayer\DLGameWhitelistIp;

class GameWhitelistIpWidget extends BaseWidget
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function getContent()
    {
        $limit = $this->_limit;
        $pages = $this->_pages;
        $gameId = $this->params["gameId"];

        if ($this->request->has("pages")){
            $pages = $this->request->get("pages");

        }elseif($this->session->has("pages")){
            $pages = $this->session->get("pages");
        }

        $dlGameWhitelistIp = new DLGameWhitelistIp();
//        $gameWhitelistIp = $dlGameWhitelistIp->getByGame($this->params["id"]);
        $gameWhitelistIp = $dlGameWhitelistIp->findByGame($gameId);

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $gameWhitelistIp,
//                "limit"=> $limit,
//                "page" => $pages
//            )
//        );
//        $records = $paginator->getPaginate();
//
//        $totalPage = ceil($gameWhitelistIp->count()/$limit);

        return $this->setView('game/ip', [
//            'page' => $records->items,
//            'game_ip' => $records->items,
//            'total_page' => $totalPage,
//            'pages' => $pages,
//            'limit' => $limit,
            'game_whitelist_ip' => $gameWhitelistIp
        ]);
    }
}