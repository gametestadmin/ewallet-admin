<?php
namespace System\Datalayer;

use System\Model\ProviderGame;

class DLProviderGame{

    public function getById($id){
        $providerGame = ProviderGame::findFirstById($id);

        return $providerGame;
    }

    public function checkByName($name){
        $providerGame = ProviderGame::findFirstByName($name);
        if(!$providerGame){
            return false;
        }

        return true;
    }

    public function checkByIdName($id,$name){
        $providerGame = ProviderGame::findFirst(
            array(
                "conditions" => "id != :id: AND name = :name:",
                "bind" => array(
                    "id" => $id,
                    "name" => $name,
                )
            )
        );
        if(!$providerGame){
            return false;
        }

        return true;
    }

    public function filterInput($data){

        $data['timezone'] = \filter_var(\strip_tags(\addslashes($data['provider_timezone'])), FILTER_SANITIZE_STRING);
        $data['name'] = \filter_var(\strip_tags(\addslashes($data['provider_name'])), FILTER_SANITIZE_STRING);
        $data['status'] = \intval($data['status']);
        if(!isset($data['id'])) {
            $app_id = strtotime("now") . $data['name'];
            $app_secret = $data['name'] . strtotime("now");
            $data['app_id'] = \base64_encode(\md5($app_id));
            $data['app_secret'] = \base64_encode(\md5($app_secret));

            $data['app_id'] = \filter_var(\strip_tags(\addslashes($data['app_id'])), FILTER_SANITIZE_STRING);
            $data['app_secret'] = \filter_var(\strip_tags(\addslashes($data['app_secret'])), FILTER_SANITIZE_STRING);
        }

        return $data;
    }

    public function validateAdd($data){
        $data = $this->filterInput($data);

        if($this->checkByName($data['name'])){
            throw new \Exception('provider_name_exist');
        }elseif(empty($data['timezone'])){
            throw new \Exception('provider_timezone_empty');
        }elseif(empty($data['name'])){
            throw new \Exception('provider_name_empty');
        }elseif($data['status']<0 || $data['status']>1){
            throw new \Exception('undefined_provider_status');
        }

        return true;
    }

    public function validateEdit($data){
        $data = $this->filterInput($data);

        if($this->checkByIdName($data['id'],$data['name'])){
            throw new \Exception('provider_name_exist');
        }elseif(empty($data['timezone'])){
            throw new \Exception('provider_timezone_empty');
        }elseif(empty($data['name'])){
            throw new \Exception('provider_name_empty');
        }elseif($data['status']<0 || $data['status']>1){
            throw new \Exception('undefined_provider_status');
        }

        return true;
    }

    public function create($data){
        $this->validateAdd($data);
        $data = $this->filterInput($data);
        $providerGame = new ProviderGame();

        if(isset($data["timezone"]))$providerGame->setTimezone($data['timezone']);
        if(isset($data["name"]))$providerGame->setName($data['name']);
        if(isset($data["app_id"]))$providerGame->setAppId($data['app_id']);
        if(isset($data["app_secret"]))$providerGame->setAppSecret($data['app_secret']);
        if(isset($data["status"]))$providerGame->setStatus($data['status']);

        if(!$providerGame->save()){
            throw new \Exception($providerGame->getMessages());
        }
        return true;
    }

    public function set($data){
        $this->validateEdit($data);
        $data = $this->filterInput($data);
        $providerGame = $this->getById($data['id']);

        if(isset($data["timezone"]))$providerGame->setTimezone($data['timezone']);
        if(isset($data["name"]))$providerGame->setName($data['name']);
        if(isset($data["status"]))$providerGame->setStatus($data['status']);

        if(!$providerGame->save()){
            throw new \Exception($providerGame->getMessages());
        }
        return true;
    }
}