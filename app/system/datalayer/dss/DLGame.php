<?php
namespace System\Datalayer;

use System\Datalayers\Main;

class DLGame extends Main{
    // DSS
    public function findGameType($start,$limit,$type){
        if($type == 1){
            $gameType = 'category';
        }elseif($type == 2){
            $gameType = 'game';
        }else{
            $gameType = 'subgame';
        }

        $postData = array(
            'st' => $start,
            'lm' => $limit
        );

        $url = '/game/'.$gameType;
        $games = $this->curlAppsJson($url, $postData);

        return $games['game'];
    }

    public function findFirstById($id){
        $game = false;

        $postData = array(
            'id' => $id,
        );

        $url = '/game/'.$postData['id'];
        $gameRecords = $this->curlAppsJson($url,$postData);
        foreach($gameRecords['game'] as $gameRecord){
            $game = $gameRecord;
        }

        return $game;
    }

    public function findByProvider($id){
        $postData = array(
            'provider' => $id,
        );

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        return $game['game'];
    }

    public function findByGameParentAndStatus($id){
        $postData = array(
            'game_parent' => $id,
//            'parent_status' => 1,
            'status' => 1,
            'provider_status' => 1
        );

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        return $game['game'];
    }

    public function findByGameParent($id){
        $postData = array(
            'game_parent' => $id,
        );

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        return $game['game'];
    }

    protected function findByNameAndType($name,$type){
        $postData = array(
            'name' => $name,
            'type' => $type
        );

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        if(isset($game['game'][0]) == 1){
            return true;
        }else{
            return false;
        }
    }

    protected function findByIdAndName($id,$name){
        $postData = array(
            'id !=' => $id,
            'name' => $name
        );

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        if(isset($game['game'][0]) == 1){
            return true;
        }else{
            return false;
        }
    }

    public function findByTypeAndStatus($type,$status)
    {
        $postData = array(
            'type' => $type,
            'status' => $status,
        );

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        return $game['game'];
    }

    public function findByCode($type,$code)
    {
        $postData = array(
            'type' => $type,
            'code' => $code,
        );

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        return $game['game'][0];
    }

    public function filterData($data){
        $filterData = array();

        if(isset($data["id"]))$filterData['id'] = \intval($data['id']);
        if(isset($data["provider"]))$filterData['idpv'] = \intval($data['provider']);
        if(isset($data["category_code"]))$filterData['cd'] = \filter_var(\strip_tags(\addslashes($data['category_code'])), FILTER_SANITIZE_STRING);
        if(isset($data["category"]))$filterData['ct'] = \filter_var(\strip_tags(\addslashes($data['category'])), FILTER_SANITIZE_STRING);
        if(isset($data["game_code"]))$filterData['g'] = \filter_var(\strip_tags(\addslashes($data['game_code'])), FILTER_SANITIZE_STRING);
        if(isset($data["parent"]))$filterData['idp'] = intval($data['parent']);
        if(isset($data["type"]))$filterData['tp'] = \intval($data['type']);
        if(isset($data["code"])){
            $data['code'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
            $filterData['cd'] = $filterData['ct']."-".$data['code'];
        }
        if(isset($data["sub_code"])){
            $data['sub_code'] = \filter_var(\strip_tags(\addslashes($data['sub_code'])), FILTER_SANITIZE_STRING);
            $filterData['cd'] = $filterData['g']."-".$data['sub_code'];
        }

        $filterData['nm'] = \filter_var(\strip_tags(\addslashes($data['name'])), FILTER_SANITIZE_STRING);
        $filterData['st'] = (isset($data["status"])?\intval($data['status']):1);
        $filterData['pst'] = (isset($data["parent_status"])?\intval($data['parent_status']):1);
        $filterData['pvst'] = (isset($data["provider_status"])?\intval($data['provider_status']):1);

        return $filterData;
    }

    public function validateCategoryCreateData($data){
        if($this->findByNameAndType($data['nm'],$data['tp'])){
            throw new \Exception('category_name_exist');
        }else if(empty($data['nm'])){
            throw new \Exception('category_name_empty');
        }

        return true;
    }

    public function validateCategorySetData($data){
        if($this->findByIdAndName($data['id'],$data['nm'])){
            throw new \Exception('category_name_exist');
        }elseif(empty($data['nm'])){
            throw new \Exception('category_name_empty');
        }
        return true;
    }

    public function validateGameCreateData($data){
        if(empty($data['idpv'])){
            throw new \Exception('provider_name_empty');
        }elseif(empty($data['ct'])){
            throw new \Exception('category_name_empty');
        }elseif($this->findByNameAndType($data['nm'],$data['ty'])){
            throw new \Exception('game_name_exist');
        }elseif(empty($data['nm'])){
            throw new \Exception('game_name_empty');
        }

        return true;
    }

    public function validateGameSetData($data){
        if($this->findByIdAndName($data['id'],$data['nm'])){
            throw new \Exception('game_name_exist');
        }elseif(empty($data['nm'])){
            throw new \Exception('game_name_empty');
        }

        return true;
    }

    public function validateSubCreateData($data){
        if(empty($data['idpv'])){
            throw new \Exception('provider_name_empty');
        }elseif(empty($data['ct'])){
            throw new \Exception('category_name_empty');
        }elseif(empty($data['g'])){
            throw new \Exception('main_game_empty');
        }elseif(empty($data['nm'])){
            throw new \Exception('sub_game_empty');
        }elseif(empty($data['cd'])){
            throw new \Exception('sub_code_game_empty');
        }elseif($this->findByNameAndType($data['nm'],$data['tp'])){
            throw new \Exception('main_name_exist');
        }

        return true;
    }

    public function validateSubSetData($data){
        if($this->findByIdAndName($data['id'],$data['nm'])){
            throw new \Exception('name_exist');
        }elseif(empty($data['nm'])){
            throw new \Exception('name_empty');
        }
        return true;
    }

    public function create($postData){
        $url = '/game/insert';
        $game = $this->curlAppsJson($url, $postData);

        return $game;
    }

    public function set($postData){
        $url = '/game/' . $postData['id'] . '/update';
        $game = $this->curlAppsJson($url, $postData);

        return $game;
    }

    public function setStatus($id, $status){
        $this->setGameStatus($id, $status);

        return true;
    }

    protected function setGameStatus($id, $status){
        $postData = array(
            "id" => $id,
            "st" => \intval($status)
        );

        $this->set($postData);
        $game = $this->findFirstById($postData['id']);

        $this->setChildParentStatus($id, $postData['st'], $game['pst']);

        return true;
    }

    protected function setChildParentStatus($parentId, $parentStatus, $grandParentStatus){
        $childParentStatus = 1;
        if ($grandParentStatus == 0 || $parentStatus == 0) {
            $childParentStatus = 0;
        } else if ($grandParentStatus == 2 || $parentStatus == 2) {
            $childParentStatus = 2;
        }

        //get childs
        $childs = $this->findByGameParent($parentId);
        foreach ($childs as $child){
            $postData = array(
                'id' => $child['id'],
                'pst' => $childParentStatus
            );
            $this->set($postData);

            //change all childs parent status
            $this->setChildParentStatus($child['id'], $child['st'], $postData['pst']);
        }
        return true;
    }
    // END DSS
}