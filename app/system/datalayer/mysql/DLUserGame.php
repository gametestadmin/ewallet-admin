<?php
namespace System\Datalayer;

use System\Model\UserGame;

class DLUserGame
{
    public function getAgentGame($agent){
        $agentGame = UserGame::findByUser($agent);

        return $agentGame;
    }
}