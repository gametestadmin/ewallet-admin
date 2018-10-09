<?php

namespace System\Widgets;

use System\Datalayer\DLGameCurrency;

class GameCurrencyWidget extends BaseWidget
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function getContent()
    {
        $limit = $this->_limit;
        $pages = $this->_pages;

        $DLGameCurrency = new DLGameCurrency();
        $gameCurrency = $DLGameCurrency->getAll($this->params["id"]);

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $gameCurrency,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $page = $paginator->getPaginate();

        $pagination = ceil($gameCurrency->count()/$limit);
        return $this->setView('game/currency', [
            'page' => $page->items,
            'pagination' => $pagination,
            'pages' => $pages,
            'limit' => $limit,
        ]);
    }
}