<?php

namespace System\Widgets;

use System\Datalayer\DLCurrency;
use System\Datalayer\DLGameCurrency;

class GameCurrencyWidget extends BaseWidget
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function getContent()
    {
        $limit = $this->_limit;
        $pages = $this->_pages;

        $gameId = $this->params["gameId"];

        $dlGameCurrency = new DLGameCurrency();
        $gameCurrency = $dlGameCurrency->findByGame($gameId);

//        $dlCurrency = new DLCurrency();
//        $currency = $dlCurrency->findFirstById();

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $gameCurrency,
//                "limit"=> $limit,
//                "page" => $pages
//            )
//        );
//        $page = $paginator->getPaginate();

//        $pagination = ceil($gameCurrency->count()/$limit);
        return $this->setView('game/currency', [
//            'page' => $page->items,
//            'pagination' => $pagination,
//            'pages' => $pages,
//            'limit' => $limit,
            'game_currency' => $gameCurrency
        ]);
    }
}