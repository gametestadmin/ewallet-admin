<?php

namespace System\Widgets;

use System\Datalayer\DLUserAuth;
use System\Datalayer\DLUserWhitelistIp;

class UserAuthWidget extends BaseWidget
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

        $DLUserAuth = new DLUserAuth();
        $userAuth = $DLUserAuth->getByUser($this->params["userId"]);

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $userAuth,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $records = $paginator->getPaginate();

        $totalPage = ceil($userAuth->count()/$limit);

        return $this->setView('user/auth', [
            'user_auth' => $records->items,
            'total_page' => $totalPage,
            'pages' => $pages,
            'limit' => $limit,
        ]);
    }
}