<?php

namespace System\Widgets;

use System\Datalayer\DLUserCurrency;

class UserCurrencyWidget extends BaseWidget
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function getContent()
    {
        $limit = $this->_limit;
        $pages = $this->_pages;

        $userId = $this->params["id"];

        $DLUserCurrency = new DLUserCurrency();
//        $userCurrency = $DLUserCurrency->getAllByUser($userId);
        $userCurrency = $DLUserCurrency->findAllByAgent($userId,1);

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $userCurrency,
//                "limit"=> $limit,
//                "page" => $pages
//            )
//        );
//        $records = $paginator->getPaginate();
//
//        $total_page = ceil($userCurrency->count()/$limit);

        return $this->setView('user/currency', [
//            'user_currency' => $records->items,
//            'total_page' => $total_page,
            'pages' => $pages,
            'limit' => $limit,
            'loginId' => $this->params["loginId"],
            'agentParent' => $this->params["agentParent"],
            'user_currency' => $userCurrency,
        ]);
    }
}