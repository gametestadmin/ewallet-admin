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
        $gameId = $this->params["gameId"];

        if ($this->request->has("pages")){
            $pages = $this->request->get("pages");

        }elseif($this->session->has("pages")){
            $pages = $this->session->get("pages");
        }

        $transferProviderGameEndpoint = array();
        $seamlessProviderGameEndpoint = array();

        $dlProviderGameEndpoint = new DLProviderGameEndpoint();
        $providerGameEndpoints = $dlProviderGameEndpoint->findByGame($gameId);

        foreach ($providerGameEndpoints as $providerGameEndpoint){
            if(substr($providerGameEndpoint['tp'], 0,1) == 1){
                $transferProviderGameEndpoint[] = $providerGameEndpoint;
            }else{
                $seamlessProviderGameEndpoint[] = $providerGameEndpoint;
//                var_dump($providerGameEndpoint);
            }
        }
//        var_dump($transferProviderGameEndpoint);
//        var_dump($seamlessProviderGameEndpoint);
//        die;

//        $seamlessProviderGameEndpoint = $dlProviderGameEndpoint->findByGame($gameId);


//        echo "<pre>";
//        var_dump($providerGameEndpoint);
//        die;

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $providerGameEndpoint,
//                "limit"=> $limit,
//                "page" => $pages
//            )
//        );
//        $records = $paginator->getPaginate();
//
//        $totalPage = ceil($providerGameEndpoint->count()/$limit);

        return $this->setView('game/endpoint', [
//            'page' => $records->items,
//            'game_endpoints' => $records->items,
//            'total_page' => $totalPage,
//            'pages' => $pages,
//            'limit' => $limit,
            'provider_game_endpoint' => $providerGameEndpoints,
            'transfer_provider_game_endpoint' => $transferProviderGameEndpoint,
            'seamless_provider_game_endpoint' => $seamlessProviderGameEndpoint
        ]);
    }
}