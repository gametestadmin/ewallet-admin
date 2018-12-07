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
        if ($this->request->has("pages")){
            $pages = $this->request->get("pages");

        }elseif($this->session->has("pages")){
            $pages = $this->session->get("pages");
        }

        $DLGameWhitelistIp = new DLGameWhitelistIp();
        $gameWhitelistIp = $DLGameWhitelistIp->getByGame($this->params["id"]);

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $gameWhitelistIp,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $records = $paginator->getPaginate();

        $totalPage = ceil($gameWhitelistIp->count()/$limit);

        return $this->setView('game/ip', [
            'page' => $records->items,
            'game_ip' => $records->items,
            'total_page' => $totalPage,
            'pages' => $pages,
            'limit' => $limit,
        ]);
    }
}