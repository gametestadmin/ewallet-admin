<?php
namespace System\Datalayer;

use System\Model\Game;
use System\Model\ProviderGame;

class DLProviderGame extends \System\Datalayers\Main{
    // DSS
    public function findByName($id = null,$name){
        if($id <> null){
            $postData = array(
                'id' => $id,
                'nm' => $name,
            );
        }else {
            $postData = array(
                'nm' => $name,
            );
        }

        $url = '/provider';
        $providerName = $this->curlAppsJson($url,$postData);

        return $providerName;
    }

    public function filterData($data){
        if(isset($data["provider_timezone"])) $data['tz'] = \filter_var(\strip_tags(\addslashes($data['provider_timezone'])), FILTER_SANITIZE_STRING);
        if(isset($data["provider_name"])) $data['nm'] = \filter_var(\strip_tags(\addslashes($data['provider_name'])), FILTER_SANITIZE_STRING);
        if(isset($data["status"])) $data['st'] = \intval($data['status']);
        if(isset($data["id"])) $data['id'] = \intval($data['id']);
        if(!isset($data['id'])) {
            $app_id = \base64_encode(\md5(strtotime("now") . $data['nm']));
            $app_secret = \base64_encode(\md5($data['nm'] . strtotime("now")));

            $data['aid'] = \filter_var(\strip_tags(\addslashes($app_id)), FILTER_SANITIZE_STRING);
            $data['asc'] = \filter_var(\strip_tags(\addslashes($app_secret)), FILTER_SANITIZE_STRING);
        }

        return $data;
    }

    public function validateAddData($data){
        if($this->findByName($data['name'])){
            throw new \Exception('provider_name_exist');
        }elseif($data['timezone']==""){
            throw new \Exception('provider_timezone_empty');
        }elseif(empty($data['name'])){
            throw new \Exception('provider_name_empty');
        }

        return true;
    }

    public function validateEditData($data){
        if($this->findByName($data['id'],$data['name'])){
            throw new \Exception('provider_name_exist');
        }elseif($data['timezone'] == ""){
            throw new \Exception('provider_timezone_empty');
        }elseif(empty($data['name'])){
            throw new \Exception('provider_name_empty');
        }elseif($data['status']<0 || $data['status']>1){
            throw new \Exception('undefined_provider_status');
        }

        return true;
    }

    public function listProviderGame($start,$limit){
        $postData = array(
            'st' => $start,
            'lm' => $limit
        );

        $url = '/provider';
        $providerGame = $this->curlAppsJson($url,$postData);

        echo "<pre>";
        var_dump($providerGame);
        die;

        return $providerGame;
    }

    public function detail($id){
        $postData = array(
            "id" => $id
        );
        $url = '/provider-game/'.$postData['id'];
        $setProviderGame = $this->curlAppsJson($url,$postData);

        return $setProviderGame['data']['provider_games'][0]['id'];
    }

    public function create($postData){
        $url = '/provider-game/insert';
        $createProviderGame = $this->curlAppsJson($url,$postData);

        return $createProviderGame['data']['provider_games'][0]['id'];
    }

    public function set($postData){
        $url = '/provider-game/update';
        $setProviderGame = $this->curlAppsJson($url,$postData);

        return $setProviderGame['data']['provider_games'][0]['id'];
    }

    // END DSS

    public function getAll($status = null){
        $providerGame = ProviderGame::find();
        if(isset($status)) {
            $providerGame = ProviderGame::findByStatus($status);
        }

        return $providerGame;
    }

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

        if(isset($data["provider_timezone"])) $data['timezone'] = \filter_var(\strip_tags(\addslashes($data['provider_timezone'])), FILTER_SANITIZE_STRING);
        if(isset($data["provider_name"])) $data['name'] = \filter_var(\strip_tags(\addslashes($data['provider_name'])), FILTER_SANITIZE_STRING);
        if(isset($data["status"])) $data['status'] = \intval($data['status']);
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
        if($this->checkByName($data['name'])){
            throw new \Exception('provider_name_exist');
        }elseif($data['timezone']==""){
            throw new \Exception('provider_timezone_empty');
        }elseif(empty($data['name'])){
            throw new \Exception('provider_name_empty');
        }

        return true;
    }

    public function validateEdit($data){
        if($this->checkByIdName($data['id'],$data['name'])){
            throw new \Exception('provider_name_exist');
        }elseif($data['timezone'] == ""){
            throw new \Exception('provider_timezone_empty');
        }elseif(empty($data['name'])){
            throw new \Exception('provider_name_empty');
        }elseif($data['status']<0 || $data['status']>1){
            throw new \Exception('undefined_provider_status');
        }

        return true;
    }

    public function creates($data){
        $data = $this->filterInput($data);
        $this->validateAdd($data);
        $providerGame = new ProviderGame();

        if(isset($data["timezone"]))$providerGame->setTimezone($data['timezone']);
        if(isset($data["name"]))$providerGame->setName($data['name']);
        if(isset($data["app_id"]))$providerGame->setAppId($data['app_id']);
        if(isset($data["app_secret"]))$providerGame->setAppSecret($data['app_secret']);

        if(!$providerGame->save()){
            throw new \Exception($providerGame->getMessages());
        }
        return $providerGame->getId();
    }

    public function sets($data){
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