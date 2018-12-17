<?php
namespace System\Datalayer;

use System\Datalayers\Main;
use System\Model\GameWhitelistIp;

class DLGameWhitelistIp extends Main{
    // DSS
    public function findByGame($game){
        $postData = array(
            'game' => $game,
            'status' => 1
        );

        $url = '/gwi/find';
        $gameWhitelistIp = $this->curlAppsJson($url,$postData);

        return $gameWhitelistIp['gwi'];
    }

    public function findFirstByGameAndIp($data){
        $gameWhitelistIpData = false;

        $postData = array(
            'game' => $data['idgm'],
            'ip' => $data['ip']
        );

        $url = '/gwi/find';
        $gameWhitelistIpRecords = $this->curlAppsJson($url,$postData);

        foreach ($gameWhitelistIpRecords['gwi'] as $gameWhitelistIpRecord){
            $gameWhitelistIpData = $gameWhitelistIpRecord;
        }

        return $gameWhitelistIpData;
    }

    public function filterData($data){
        $filterData = array();

        if(isset($data["game"])) $filterData['idgm'] = \intval($data['game']);
        if(isset($data["ip"])) $filterData['ip'] = \filter_var(\strip_tags(\addslashes($data['ip'])), FILTER_SANITIZE_STRING);
        $filterData['st'] = (isset($data["status"])?\intval($data['status']):1);

        return $filterData;
    }

    public function validateCreate($data){
        if($this->findFirstByGameAndIp($data)){
            throw new \Exception('ip_exist');
        }elseif(empty($data['ip'])){
            throw new \Exception('ip_empty');
        }

        return true;
    }

    public function create($postData){
        $url = '/gwi/insert';
        $gameWhitelistIp = $this->curlAppsJson($url,$postData);

        return true;
    }

    public function delete($id){
        $url = '/gwi/'.$id.'/delete';
        $gameWhitelistIp = $this->curlAppsJson($url,$postData);

        return true;
    }

    // END DSS
    public function getByGame($game){
        $gameWhitelistIp = GameWhitelistIp::findByGame($game);

        return $gameWhitelistIp;
    }

    public function getById($id){
        $gameWhitelistIp = GameWhitelistIp::findFirstById($id);

        return $gameWhitelistIp;
    }

    public function uniqueCheck($data,$id = null){
//        echo "<pre>";
//        var_dump($id);
//        var_dump($data);
//        die;
        if(isset($id)){
            $gameWhitelistIp = GameWhitelistIp::findFirst(
                array(
                    "conditions" => "id != :id: AND game = :game: AND ip = :ip:",
                    "bind" => array(
                        "id" => $id,
                        "game" => $data['game'],
                        "ip" => $data['ip'],
                    ),
                )
            );
        }else {
            $gameWhitelistIp = GameWhitelistIp::findFirst(
                array(
                    "conditions" => "game = :game: AND ip = :ip:",
                    "bind" => array(
                        "game" => $data['game'],
                        "ip" => $data['ip'],
                    ),
                )
            );
        }
        return $gameWhitelistIp;
    }

    public function filterInput($data){
        if(isset($data["game"])) $data['game'] = \intval($data['game']);
        if(isset($data["ip"])) $data['ip'] = \filter_var(\strip_tags(\addslashes($data['ip'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function validateAdd($data){
        if($this->uniqueCheck($data)){
            throw new \Exception('ip_exist');
        }elseif(empty($data['ip'])){
            throw new \Exception('ip_empty');
        }

        return true;
    }

    public function validateEdit($data){
        if($this->uniqueCheck($data,$data['ip_id'])){
            throw new \Exception('ip_exist');
        }elseif(empty($data['ip'])){
            throw new \Exception('ip_empty');
        }

        return true;
    }

    public function creates($data){
        $gameWhitelistIp = new GameWhitelistIp();

        $game = new DLGame();
        $gameData = $game->getById($data['game']);

        if(isset($data["game"]))$gameWhitelistIp->setGame($gameData->getId());
        if(isset($data["ip"]))$gameWhitelistIp->setIp($data['ip']);

        if(!$gameWhitelistIp->save()){
            throw new \Exception('error_add_game_whitelist_ip');
        }

        return true;
    }

    public function sets($data){
        $gameWhitelistIp = $this->getById($data['ip_id']);

        $game = new DLGame();
        $gameData = $game->getById($data['game']);

        if(isset($data["game"]))$gameWhitelistIp->setGame($gameData->getId());
        if(isset($data["ip"]))$gameWhitelistIp->setIp($data['ip']);

        if(!$gameWhitelistIp->save()){
            throw new \Exception('error_add_game_whitelist_ip');
        }

        return true;
    }

    public function deletes($ip){
        $gameWhitelistIp = $this->getById($ip);

        if(!$gameWhitelistIp->delete()){
            throw new \Exception('error_delete_game_whitelist_ip');
        }

        return true;
    }

}