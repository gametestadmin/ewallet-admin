<?php
namespace System\Datalayer;

use System\Model\GameWhitelistIp;

class DLGameWhitelistIp{
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

    public function create($data){
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

    public function set($data){
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

    public function delete($ip){
        $gameWhitelistIp = $this->getById($ip);

        if(!$gameWhitelistIp->delete()){
            throw new \Exception('error_delete_game_whitelist_ip');
        }

        return true;
    }

}