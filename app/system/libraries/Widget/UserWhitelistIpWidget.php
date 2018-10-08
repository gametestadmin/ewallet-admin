<?php

namespace System\Widgets;

use System\Datalayer\DLUserWhitelistIp;

class UserWhitelistIpWidget extends BaseWidget
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

        $DLUserWhitelistIp = new DLUserWhitelistIp();
        $userWhitelistIp = $DLUserWhitelistIp->getByUser($this->params["id"]);

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $userWhitelistIp,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $records = $paginator->getPaginate();

        $totalPage = ceil($userWhitelistIp->count()/$limit);

        return $this->setView('user/ip', [
            'user_ip' => $records->items,
            'total_page' => $totalPage,
            'pages' => $pages,
            'limit' => $limit,
            'loginId' => $this->params["loginId"],
            'agentParent' => $this->params["agentParent"]
        ]);
    }
}