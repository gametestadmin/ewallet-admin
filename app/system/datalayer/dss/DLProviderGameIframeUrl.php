<?php
namespace System\Datalayer;

use System\Datalayers\Main;
use System\Model\GameCurrency;
use System\Model\ProviderGameEndpoint;

class DLProviderGameIframeUrl extends Main{
    // DSS
    public function findByGame($game){
        $iframeUrl = false;

        $postData = array(
            'game' => $game,
        );

        $url = '/pgi/find';
        $providerGameIframeUrlRecords = $this->curlAppsJson($url,$postData);

        foreach ($providerGameIframeUrlRecords['pgi'] as $providerGameIframeUrlRecord){
            $iframeUrl = $providerGameIframeUrlRecord;
        }

        return $iframeUrl;
    }

    public function filterData($data){
        $filterData = array();

        if(isset($data["provider_game"])) $filterData['idpg'] = \intval($data['provider_game']);
        if(isset($data["game_id"])) $filterData['idgm'] = \intval($data['game_id']);
        if(isset($data["url"])) $filterData['if'] = \filter_var(\strip_tags(\addslashes($data['url'])), FILTER_SANITIZE_STRING);

        $filterData['st'] = (isset($data['status'])?intval($data['status']):1);

        return $filterData;
    }

    public function validateSet($data){
        if(empty($data['if'])){
            throw new \Exception('url_empty');
        }

        return true;
    }

    public function set($postData){
        $iframeUrl = $this->findByGame($postData['idgm']);

        if(isset($iframeUrl['id'])){
            $url = '/pgi/'.$iframeUrl['id'].'/update';
            $this->curlAppsJson($url,$postData);
        }else{
            $url = '/pgi/insert';
            $this->curlAppsJson($url,$postData);
        }

        return true;
    }

    // END DSS
}