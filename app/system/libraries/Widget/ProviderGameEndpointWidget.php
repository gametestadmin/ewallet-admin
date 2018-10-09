<?php

namespace System\Widgets;

use System\Datalayer\DLProviderGameEndpoint;

class ProviderGameEndpointWidget extends BaseWidget
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

        $DLProviderGameEndpoint = new DLProviderGameEndpoint();
        $providerGameEndpoint = $DLProviderGameEndpoint->getAll($this->params["id"]);

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $providerGameEndpoint,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $records = $paginator->getPaginate();

        $totalPage = ceil($providerGameEndpoint->count()/$limit);

        return $this->setView('game/endpoint', [
            'page' => $records->items,
            'game_endpoints' => $records->items,
            'total_page' => $totalPage,
            'pages' => $pages,
            'limit' => $limit,
        ]);
    }
}