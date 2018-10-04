<?php
namespace System\Datalayer;

use System\Model\GameCurrency;
use System\Model\ProviderGameEndpoint;

class DLProviderGameEndpoint {
    public function getAll($game){
        $providerGameEndpoint = ProviderGameEndpoint::findByGame($game);

        return $providerGameEndpoint;
    }

    public function getById($id){
        $providerGameEndpoint = ProviderGameEndpoint::findFirstById($id);

        return $providerGameEndpoint;
    }

    public function uniqueCheck($data,$id = null){
        if(isset($id)){
            $providerGameEndpoint = ProviderGameEndpoint::findFirst(
                array(
                    "conditions" => "id != :id: AND game = :game: OR id != :id: AND type = :type: ",
                    "bind" => array(
                        "id" => $id,
                        "game" => $data['game'],
                        "type" => $data['type'],
                    ),
                )
            );
        }else {
            $providerGameEndpoint = ProviderGameEndpoint::findFirst(
                array(
                    "conditions" => "game = :game: AND type = :type: ",
                    "bind" => array(
                        "game" => $data['game'],
                        "type" => $data['type'],
                    ),
                )
            );
        }

        return $providerGameEndpoint;
    }

    public function filterInput($data){
        if(isset($data["game"])) $data['game'] = \intval($data['game']);
        if(isset($data["type"])) $data['type'] = \intval($data['type']);
//        if(isset($data["auth"])) $data['auth'] = \intval($data['auth']);
        $data['auth'] = (isset($data['auth'])?$data['auth']:null);
        if(isset($data["endpoint"])) $data['endpoint'] = \filter_var(\strip_tags(\addslashes($data['endpoint'])), FILTER_SANITIZE_STRING);
        if(isset($data["url"])) $data['url'] = \filter_var(\strip_tags(\addslashes($data['url'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function validateAdd($data){
        if($this->uniqueCheck($data)){
            throw new \Exception('endpoint_type_exist');
        }elseif(empty($data['type'])){
            throw new \Exception('type_empty');
        }elseif(empty($data['url'])){
            throw new \Exception('url_empty');
        }

        return true;
    }

    public function validateEdit($data){
        if($this->uniqueCheck($data,$data['endpoint_id'])){
            throw new \Exception('endpoint_type_exist');
        }elseif(empty($data['type'])){
            throw new \Exception('type_empty');
        }elseif(empty($data['url'])){
            throw new \Exception('url_empty');
        }

        return true;
    }

    public function create($data){
        $providerGameEndpoint = new ProviderGameEndpoint();
        $endpoint = $data['endpoint'].$data['url'];

        $game = new DLGame();
        $gameData = $game->getById($data['game']);

        $providerGameEndpoint->setProviderGame($gameData->getProvider());
        if(isset($data["game"]))$providerGameEndpoint->setGame($gameData->getId());
        if(isset($data["type"]))$providerGameEndpoint->setType($data['type']);
        $providerGameEndpoint->setGameType($gameData->getType());
        if(isset($data["endpoint"]))$providerGameEndpoint->setEndpoint($endpoint);
        if(isset($data["auth"]))$providerGameEndpoint->setProviderGameEndpointAuth($data['auth']);

        if(!$providerGameEndpoint->save()){
            throw new \Exception('error_add_game_endpoint');
        }

        return true;
    }

    public function set($data){
        $providerGameEndpoint = $this->getById($data['endpoint_id']);
        $endpoint = $data['endpoint'].$data['url'];

        if(isset($data["type"]))$providerGameEndpoint->setType($data['type']);
        if(isset($data["endpoint"]))$providerGameEndpoint->setEndpoint($endpoint);
        if(isset($data["auth"]))$providerGameEndpoint->setProviderGameEndpointAuth($data['auth']);

        if(!$providerGameEndpoint->save()){
            throw new \Exception('error_edit_game_endpoint');
        }
    }
}