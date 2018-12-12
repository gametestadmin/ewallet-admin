<?php
namespace System\Datalayer;

class DLProviderGame extends \System\Datalayers\Main{
    // DSS
    public function findByName($name){
        $providerGame = false;

        $postData = array(
            'name' => $name,
        );

        $url = '/pg/find';
        $providers = $this->curlAppsJson($url,$postData);

        foreach ($providers['gp'] as $provider){
            $providerGame = $provider;
        }

        return $providerGame;
    }

    public function findFirstByIdAndName($id,$name){
        $providerGame = false;
        $postData = array(
            'id !=' => $id,
            'name =' => $name,
        );

        $url = '/pg/find';
        $providers = $this->curlAppsJson($url,$postData);

        foreach ($providers['gp'] as $provider){
            $providerGame = $provider;
        }

        return $providerGame;
    }

    public function findFirstById($id){
        $providerGame = false;

        $postData = array(
            'id' => $id,
        );

        $url = '/pg/'.$postData['id'];
        $providerGameRecords = $this->curlAppsJson($url,$postData);
        foreach($providerGameRecords['gp'] as $providerGameRecord){
            $providerGame = $providerGameRecord;
        }

        return $providerGame;
    }

    public function findByStatus($status){
        $postData = array(
            'status' => $status,
        );

        $url = '/pg/find';
        $providerGame = $this->curlAppsJson($url,$postData);

        return $providerGame['gp'];
    }

    public function filterData($data){
        $filterData = array();

        if(isset($data["provider_timezone"])) $filterData['tz'] = \filter_var(\strip_tags(\addslashes($data['provider_timezone'])), FILTER_SANITIZE_STRING);
        if(isset($data["provider_name"])) $filterData['nm'] = \filter_var(\strip_tags(\addslashes($data['provider_name'])), FILTER_SANITIZE_STRING);
        $filterData['st'] = (isset($data["status"])?\intval($data['status']):1);
        if(isset($data["id"])) $filterData['id'] = \intval($data['id']);
        if(!isset($data['id'])) {
            $app_id = \base64_encode(\md5(strtotime("now") . $filterData['nm']));
            $app_secret = \base64_encode(\md5($filterData['nm'] . strtotime("now")));

            $filterData['aid'] = \filter_var(\strip_tags(\addslashes($app_id)), FILTER_SANITIZE_STRING);
            $filterData['asc'] = \filter_var(\strip_tags(\addslashes($app_secret)), FILTER_SANITIZE_STRING);
        }

        return $filterData;
    }

    public function validateCreateData($data){
        if($this->findByName($data['nm'])){
            throw new \Exception('provider_name_exist');
        }else if($data['tz']==""){
            throw new \Exception('provider_timezone_empty');
        }elseif(empty($data['nm'])){
            throw new \Exception('provider_name_empty');
        }

        return true;
    }

    public function validateSetData($data){
        if($this->findFirstByIdAndName($data['id'],$data['nm'])){
            throw new \Exception('provider_name_exist');
        }else if($data['tz'] == ""){
            throw new \Exception('provider_timezone_empty');
        }elseif(empty($data['nm'])){
            throw new \Exception('provider_name_empty');
        }elseif($data['st']<0 || $data['st']>1){
            throw new \Exception('undefined_provider_status');
        }

        return true;
    }

    public function listProviderGame($start,$limit){
        $postData = array(
            'st' => $start,
            'lm' => $limit
        );

        $url = '/pg';
        $providerGame = $this->curlAppsJson($url,$postData);

        return $providerGame['gp'];
    }

    public function detail($id){
        $providerGame = $this->findFirstById($id);

        return $providerGame;
    }

    public function create($postData){
        $url = '/pg/insert';
        $createProviderGame = $this->curlAppsJson($url,$postData);

        return $createProviderGame['gp'];
    }

    public function set($postData){
        $url = '/pg/'.$postData['id'].'/update';
        $this->curlAppsJson($url,$postData);

        return true;
    }

    // END DSS
}