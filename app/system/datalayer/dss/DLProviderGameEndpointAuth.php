<?php
namespace System\Datalayer;

use System\Datalayers\Main;

class DLProviderGameEndpointAuth extends Main{
    // DSS
    public function findByGame($game){
        $postData = array(
            'game' => $game
        );
        $url = '/pgea/find';
        $providerGameEndpointAuth = $this->curlAppsJson($url,$postData);

        return $providerGameEndpointAuth['pgea'];
    }

    public function findFirstById($id){
        $providerGameEndpointAuthData = false;
        $postData = array(
            'id' => $id
        );
        $url = '/pgea/'.$postData['id'];
        $providerGameEndpointAuths = $this->curlAppsJson($url, $postData);

        foreach ($providerGameEndpointAuths['pgea'] as $providerGameEndpointAuth){
            $providerGameEndpointAuthData = $providerGameEndpointAuth;
        }

        return $providerGameEndpointAuthData;
    }

    public function filterData($data){
        $filterData = array();

        if(isset($data["auth_id"])) $filterData['id'] = \intval($data['auth_id']);
        if(isset($data["app_id"])) $filterData['aid'] = \filter_var(\strip_tags(\addslashes($data['app_id'])), FILTER_SANITIZE_STRING);
        if(isset($data["app_secret"])) $filterData['asc'] = \filter_var(\strip_tags(\addslashes($data['app_secret'])), FILTER_SANITIZE_STRING);
        if(isset($data['game'])) $filterData['idgm'] = \intval($data['game']);
        if(isset($data['provider_game'])) $filterData['idpg'] = \intval($data['provider_game']);

        return $filterData;
    }

    public function validateCreate($data){
        if(empty($data['aid'])){
            throw new \Exception('app_id_empty');
        }elseif(empty($data['asc'])){
            throw new \Exception('app_secret_empty');
        }
        return true;
    }

    public function validateSet($data){
        if(!$this->findFirstById($data['id'])){
            throw new \Exception('undefined_auth_id');
        }elseif(empty($data['aid'])){
            throw new \Exception('app_id_empty');
        }elseif(empty($data['asc'])){
            throw new \Exception('app_secret_empty');
        }
        return true;
    }

    public function create($postData){
        $url = '/pgea/insert';
        $providerGameEndpointAuth = $this->curlAppsJson($url, $postData);

//        return $providerGameEndpointAuth;
        return true;
    }

    public function set($postData){
        $url = '/pgea/' . $postData['id'] . '/update';
        $providerGameEndpointAuth = $this->curlAppsJson($url, $postData);

//        return $providerGameEndpointAuth;
        return true;
    }
    // END DSS
}