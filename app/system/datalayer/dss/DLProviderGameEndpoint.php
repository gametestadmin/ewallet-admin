<?php
namespace System\Datalayer;

use System\Datalayers\Main;
use System\Model\ProviderGameEndpoint;

class DLProviderGameEndpoint extends Main{
    // DSS
    public function findByGame($game){
        // from getAll
        $postData = array(
            'game' => $game
        );

        $url = '/pge/find';
        $providerGameEndpoint = $this->curlAppsJson($url,$postData);

        return $providerGameEndpoint['pge'];
    }

    public function filterData($data){
        $filterData = array();

        if(isset($data["endpoint_id"])) $filterData['id'] = \intval($data['endpoint_id']);
        if(isset($data["game"])) $filterData['idgm'] = \intval($data['game']);
        if(isset($data["provider_game"])) $filterData['idpg'] = \intval($data['provider_game']);
        if(isset($data["game_type"])) $filterData['gmtp'] = \intval($data['game_type']);
        if(isset($data["url"])) $data['url'] = \filter_var(\strip_tags(\addslashes($data['url'])), FILTER_SANITIZE_STRING);
        if(isset($data["endpoint"])) $data['endpoint'] = \filter_var(\strip_tags(\addslashes($data['endpoint'])), FILTER_SANITIZE_STRING);

        $filterData['idpgea'] = (isset($data['auth'])?intval($data['auth']):0);
        $filterData['ep'] = $data['endpoint'].$data['url'];

        if($data['endpoint_type_value'] == 1){
            if(isset($data["transfer_type"])) $filterData['tp'] = \intval($data['transfer_type']);
        }else{
            if(isset($data["seamless_type"])) $filterData['tp'] = \intval($data['seamless_type']);
        }

        return $filterData;
    }

    public function validateCreate($data){
//        if($this->uniqueCheck($data)){
//            throw new \Exception('endpoint_type_exist');
//        }else
        if(empty($data['tp'])){
            throw new \Exception('type_empty');
        }else if(empty($data['ep'])){
            throw new \Exception('url_empty');
        }

        return true;
    }
    public function validateSet($data){
//        if($this->uniqueCheck($data,$data['endpoint_id'])){
//            throw new \Exception('endpoint_type_exist');
//        }else
        if(empty($data['tp'])){
            throw new \Exception('type_empty');
        }elseif(empty($data['ep'])){
            throw new \Exception('url_empty');
        }

        return true;
    }
    public function create($postData){
        $url = '/pge/insert';
        $this->curlAppsJson($url,$postData);

        return true;
    }

    public function set($postData){
        $url = '/pge/'.$postData['id'].'/update';
        $this->curlAppsJson($url,$postData);

        return true;
    }

    // END DSS

    public function uniqueCheck($data,$id = null){
        if(isset($id)){
            $providerGameEndpoint = ProviderGameEndpoint::findFirst(
                array(
                    "conditions" => "id <> :id: AND game = :game: AND type = :type: ",
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
}