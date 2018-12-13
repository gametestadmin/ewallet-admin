<?php
namespace System\Datalayer;

use System\Datalayers\Main;
use System\Model\UserGame;

class DLUserGame extends Main
{
    // DSS
    public function findUserGame($agent,$type){
        $postData = array(
            "user_id" => $agent,
            "game_type" => $type,
        );
        $url = '/usergame/find';
        $userGames = $this->curlAppsJson($url,$postData);

        return $userGames['ug'];
    }

    public function findByUser($agent){
        $postData = array(
            "user_id" => $agent,
        );
        $url = '/usergame/find';
        $userGames = $this->curlAppsJson($url,$postData);

        return $userGames['ug'];
    }

    public function findByGame($game){
        $postData = array(
            "game" => $game,
        );
        $url = '/usergame/find';
        $userGames = $this->curlAppsJson($url,$postData);

        return $userGames['ug'];
    }

    public function findFirstById($id)
    {
        $userGame = array();
        $postData = array(
            "id" => $id
        );
        $url = '/usergame/find';
        $userGameRecords = $this->curlAppsJson($url,$postData);

        foreach ($userGameRecords['ug'] as $userGameRecord){
            $userGame = $userGameRecord;
        }

        return $userGame;
    }

    public function findFirstByUserAndGame($userId,$gameId)
    {
        $userGame = array();

        $postData = array(
            "user_id" => $userId,
            "game" => $gameId
        );
        $url = '/usergame/find';
        $userGameRecords = $this->curlAppsJson($url,$postData);

        foreach ($userGameRecords['ug'] as $userGameRecord){
            $userGame = $userGameRecord;
        }

        return $userGame;
    }

    public function set($postData){

        $url = '/usergame/'.$postData['id'].'/update';
        $a = $this->curlAppsJson($url,$postData);

        return true;
    }

    public function setAgentGameStatus($userId, $userGameId, $status){
        $postData = array(
            "id" => $userGameId,
            "st" => $status
        );

        $this->set($postData);

        $userGame = $this->findFirstById($userGameId);
        $this->setChildParentStatus($userId, $userGame->gm->id, $status, $userGame->pst);;

        return true;
    }

    protected function setChildParentStatus($parentId, $gameId, $parentStatus, $grandParentStatus){
        $dlUser = new DLUser();
        $downlines = $dlUser->findByParent($parentId);

        $dlGame = new DLGame();
        $subGames = $dlGame->findByGameParent($gameId);

        $childParentStatus = 1;
        if($grandParentStatus == 0 || $parentStatus == 0){
            $childParentStatus = 0;
        }else if($grandParentStatus == 2 || $parentStatus == 2){
            $childParentStatus = 2;
        }

        foreach ($subGames as $subGame) {
            $selfSubGame = $this->findFirstByUserAndGame($parentId,$subGame->id);

            if($selfSubGame) {
                $postData = array(
                    "id" => $selfSubGame->id,
                    "pst" => $childParentStatus
                );
                $this->set($postData);
            }
        }

        foreach ($downlines as $downline){
            $childGame = $this->findFirstByUserAndGame($downline->id,$gameId);

            if($childGame){
                $postData = array(
                    "id" => $childGame->id,
                    "pst" => $childParentStatus
                );
                $this->set($postData);

                $this->setChildParentStatus($downline->id, $gameId, $childGame->st, $childParentStatus);
            }
        }

        return true;
    }
    // END DSS
    public function getAgentGame($agent,$type,$status = 1){
        $agentGame = UserGame::find(
            array(
                "conditions" => "user = :user: AND game_type = :game_type: AND status >= :status:",
                "bind" => array(
                    "user" => $agent,
                    "game_type" => $type,
                    "status" => $status
                ),
                "order" => "id"
            )
        );

        return $agentGame;
    }

    public function getAgentSubGame($agent,$game){
        $agentGame = UserGame::findFirst(
            array(
                "conditions" => "user = :user: AND game = :game:",
                "bind" => array(
                    "user" => $agent,
                    "game" => $game
                )
            )
        );

        return $agentGame;
    }

    public function getAgentGameByGameParent($agent,$type){
        $agentGame = UserGame::find(
            array(
                "conditions" => "user = :user: AND game_type = :game_type:",
                "bind" => array(
                    "user" => $agent,
                    "game_type" => $type
                )
            )
        );

        return $agentGame;
    }

    public function getParentGame($parent,$type){
//        $userId = $parent;
//        $gameType = $type;
//        $status = 1;
//
//        $postData = array(
//            'app_id' => $this->_config->api->id,
//            'app_secret' => $this->_config->api->secret,
//            'user_id' => $userId,
//            'game_type' => $gameType,
//            'status' => $status,
//            'ip' => GeneralSecurity::getIP(),
//        );
//
//        // Setup cURL
//        $ch = curl_init($this->_config->api->url.'user/game');
//        curl_setopt_array($ch, array(
//            CURLOPT_POST => TRUE,
//            CURLOPT_RETURNTRANSFER => TRUE,
////            CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
//            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
////            CURLOPT_POSTFIELDS => http_build_query($postData),
//            CURLOPT_POSTFIELDS => json_encode($postData),
//        ));
//
//        // Send the request
//        $parentGames = json_decode(curl_exec($ch));
//
//        return $parentGames;

        $parentGames = UserGame::find(
            array(
                "conditions" => "user = :user: AND game_type = :game_type: AND status = :status:",
                "bind" => array(
                    "user" => $parent,
                    "game_type" => $type,
                    "status" => 1
                )
            )
        );
//        $parentGames = UserGame::find(
//            array(
//                "conditions" => "user = :user: AND status = :status:",
//                "bind" => array(
//                    "user" => $parent,
//                    "status" => 1
//                )
//            )
//        );

        return $parentGames;
    }

    public function getParentGameAndGameType($parent,$type){
        $parentGames = UserGame::find(
            array(
                "conditions" => "user = :user: AND game_type = :game_type:",
                "bind" => array(
                    "user" => $parent,
                    "game_type" => $type
                )
            )
        );

        return $parentGames;
    }

    public function getById($agentGameId){
        $agentGame = UserGame::findFirst($agentGameId);

        return $agentGame;
    }

    public function getAgentGameAndGameId($agentId,$gameId,$gameType){
        $agentGame = UserGame::findFirst(
            array(
                "conditions" => "user = :user: AND game = :game: AND game_type = :game_type:",
                "bind" => array(
                    "user" => $agentId,
                    "game" => $gameId,
                    "game_type" => $gameType
                )
            )
        );

        return $agentGame;
    }

    public function getByAgentIdAndGameId($agentId,$gameId,$status = null){
        if($status == null){
            $agentGame = UserGame::findFirst(
                array(
                    "conditions" => "user = :user: AND game = :game:",
                    "bind" => array(
                        "user" => $agentId,
                        "game" => $gameId,
                    )
                )
            );
        }
        else{
            $agentGame = UserGame::findFirst(
                array(
                    "conditions" => "user = :user: AND game = :game: AND status = :status:",
                    "bind" => array(
                        "user" => $agentId,
                        "game" => $gameId,
                        "status" => $status,
                    )
                )
            );
        }

        return $agentGame;
    }

    public function checkAgentGame($agent,$game){
        $agentGame = UserGame::findFirst(
            array(
                "conditions" => "user = :agent: AND game = :game:",
                "bind" => array(
                    "agent" => $agent,
                    "game" => $game
                )
            )
        );

        return $agentGame;
    }

    public function filterInputAgentGame($data){
        if(isset($data["game"]))$data['game'] = \intval($data['game']);
        if(isset($data["agent"]))$data['agent'] = \intval($data['agent']);
        if(isset($data["game_type"]))$data['game_type'] = \intval($data['game_type']);

        $userModel = new DLUser();
        $agent = $userModel->getById($data['agent']);
        $parent = $userModel->getById($agent->getParent());
        $data["parent"] = $parent->getId();

//        if($parent->getType() == 9){
            $data["parent_status"] = 1;
//        }else{
//            $gameModel = new DLUserGame();
//            $parentGame = $gameModel->checkAgentGame($parent->getId(), $data['game']);
//
//            if($parentGame->getParentStatus() == 9 || $parentGame->getStatus() == 9) {
//                $data["parent_status"] = 9;
//            }else if($parentGame->getParentStatus() == 0 || $parentGame->getStatus() == 0) {
//                $data["parent_status"] = 0;
//            }else if($parentGame->getParentStatus() == 1 && $parentGame->getStatus() == 1){
//                $data["parent_status"] = 1;
//            }
//        }

        return $data;
    }

    public function validateCreateAgentGame($data){
        if($this->checkAgentGame($data['agent'],$data['game'])){
            throw new \Exception('game_exist');
        } elseif(!$data['agent']){
            throw new \Exception('undefined_agent');
        }elseif (!$data['game']){
            throw new \Exception('undefined_game');
        }elseif (!$data['game_type']){
            throw new \Exception('undefined_game_type');
        }

        return true;
    }

    public function createAgentGame($data){
        $agentGame =  new UserGame();

        if(isset($data["agent"]))$agentGame->setUser($data['agent']);
        if(isset($data["game"]))$agentGame->setGame($data['game']);
        if(isset($data["game_type"]))$agentGame->setGameType($data['game_type']);
        $agentGame->setUserGameHistoricalPositionTaking(null);
        $agentGame->setParentStatus($data["parent_status"]);
        $agentGame->setStatus(0);
        $agentGame->setDisabled(0);

        $agentGame->save();

        return $agentGame;
    }

//    public function setAgentGameStatus($agentId, $agentGameId, $status){
//        $agentGame = $this->getById($agentGameId);
//        $agentGame->setStatus($status);
//        $agentGame->save();
//        // get agent game
//
//        $this->setChildParentStatus($agentId, $agentGame->getGame(), $status, $agentGame->getParentStatus());
//
//        return true;
//    }
//
//    protected function setChildParentStatus($parentId, $gameId, $parentStatus, $grandParentStatus){
//
//        $dlUser = new DLUser();
//        $agents = $dlUser->getByParent($parentId);
//
//        $dlGame = new DLGame();
//        $subGames = $dlGame->getByGameParent($gameId);
//
//        $subGamesId = array();
//
//        if($subGames) {
//            foreach ($subGames as $subGame) {
//                $selfSubGame = $this->getByAgentIdAndGameId($parentId, $subGame->getId());
//                if($selfSubGame){
//                    // set self parent_status to subgame filter by game parent id
//                    $selfSubGame->setParentStatus($parentStatus);
//                    $selfSubGame->save();
//                }
//                $subGamesId[] = $subGame->getId();
//            }
//        }
//        $childParentStatus = 1;
//        if($grandParentStatus == 0 || $parentStatus == 0){
//            $childParentStatus = 0;
//        }else if($grandParentStatus == 2 || $parentStatus == 2){
//            $childParentStatus = 2;
//        }
//
//        foreach ($agents as $agent){
//            $agentGame = $this->getByAgentIdAndGameId($agent->getId(),$gameId);
//            if($agentGame) {
//                if($subGames) {
//                    foreach ($subGamesId as $id) {
//                        $agentSubGame = $this->getByAgentIdAndGameId($agent->getId(), $id);
//                        if($agentSubGame) {
//                            // set parent_status game type 3 filter by game parent id
//                            $agentSubGame->setParentStatus($childParentStatus);
//                            $agentSubGame->save();
//                        }
//                    }
//                }
//                // set parent_status game type 2 filter by agent parent id
//                $agentGame->setParentStatus($childParentStatus);
//                $agentGame->save();
//
//                $this->setChildParentStatus($agentGame->getId(), $gameId, $agentGame->getStatus(), $childParentStatus);
//            }
//        }
//        return true;
//    }
}