<?php
namespace System\Datalayer;

use System\Model\GameCurrency;
use System\Model\ProviderGameEndpoint;
use System\Model\ProviderGameEndpointAuth;

class DLProviderGameEndpointAuth {
    public function getAll($game){
        $providerGameEndpointAuth = ProviderGameEndpointAuth::findByGame($game);

        return $providerGameEndpointAuth;
    }

    public function getById($id){
        $providerGameEndpointAuth = ProviderGameEndpointAuth::findFirstById($id);

        return $providerGameEndpointAuth;
    }

    public function filterInput($data){
        if(isset($data["app_id"])) $data['app_id'] = \filter_var(\strip_tags(\addslashes($data['app_id'])), FILTER_SANITIZE_STRING);
        if(isset($data["app_secret"])) $data['app_secret'] = \filter_var(\strip_tags(\addslashes($data['app_secret'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function validateAdd($data){
        if(empty($data['app_id'])){
            throw new \Exception('app_id_empty');
        }elseif(empty($data['app_secret'])){
            throw new \Exception('app_secret_empty');
        }
        return true;
    }

    public function validateEdit($data){
        if($this->getById($data['auth_id']) == false){
            throw new \Exception('undefined_auth_id');
        }elseif(empty($data['app_id'])){
            throw new \Exception('app_id_empty');
        }elseif(empty($data['app_secret'])){
            throw new \Exception('app_secret_empty');
        }
        return true;
    }

    public function create($data){
        $providerGameEndpointAuth = new ProviderGameEndpointAuth();
        $game = new DLGame();
        $gameData = $game->getById($data['game']);

        if(isset($data["app_id"]))$providerGameEndpointAuth->setAppId($data['app_id']);
        if(isset($data["app_secret"]))$providerGameEndpointAuth->setAppSecret($data['app_secret']);
        $providerGameEndpointAuth->setProviderGame($gameData->getProvider());
        $providerGameEndpointAuth->setGame($gameData->getId());

        if(!$providerGameEndpointAuth->save()){
            throw new \Exception('error_add_provider_game_auth');
        }

        return true;
    }

    public function set($data){
        $authId = $data["auth_id"];

        $providerGameEndpointAuth = $this->getById($authId);

        $providerGameEndpointAuth->setAppId($data['app_id']);
        $providerGameEndpointAuth->setAppSecret($data['app_secret']);

        if(!$providerGameEndpointAuth->save()){
            throw new \Exception('error_set_currency');
        }

        return $providerGameEndpointAuth->getId();
    }

}