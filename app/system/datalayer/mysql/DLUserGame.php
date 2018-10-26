<?php
namespace System\Datalayer;

use System\Model\UserGame;

class DLUserGame
{
    public function getAgentGame($agent,$type){
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

    public function getParentGame($parent){
        $parentGames = UserGame::findByUser($parent);

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
        $agentGame->setParentStatus(0);
        $agentGame->setStatus(0);
        $agentGame->setDisabled(0);

        $agentGame->save();

        return $agentGame;
    }
}