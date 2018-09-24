<?php

namespace System\Widgets;

use System\Datalayer\DLProviderGameEndpointAuth;

class ProviderGameEndpointAuthWidget extends BaseWidget
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

        $DLProviderGameEndpointAuth = new DLProviderGameEndpointAuth();
        $providerGameEndpointAuth = $DLProviderGameEndpointAuth->getAll($this->params["id"]);

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $providerGameEndpointAuth,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $records = $paginator->getPaginate();

        $totalPage = ceil($providerGameEndpointAuth->count()/$limit);

        return $this->setView('game/auth', [
            'page' => $records->items,
            'game_endpoints' => $records->items,
            'total_page' => $totalPage,
            'pages' => $pages,
            'limit' => $limit,
        ]);
    }
}