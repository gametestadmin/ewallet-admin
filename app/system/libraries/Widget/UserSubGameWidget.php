<?php

namespace System\Widgets;

use System\Datalayer\DLGame;
use System\Datalayer\DLUserGame;

class UserSubGameWidget extends BaseWidget
{
    public function getContent()
    {
        $agentSubGames = array();

        $dlGame = new DLGame();
        $dlUserGame = new DLUserGame();
        $games = $dlGame->getByGameParent($this->params['game']);
        foreach ($games as $game){
            $agentSubGames[] = $dlUserGame->getAgentSubGame($this->params["agentId"],$game->getId());
        }

        return $this->setView('user/subgame/list', [
            'agent_subgames' => $agentSubGames,
        ]);
    }
}