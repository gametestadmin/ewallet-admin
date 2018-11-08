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

        if(!empty($games)) {
            foreach ($games as $game) {
                $subGame = $dlUserGame->getAgentSubGame($this->params["agentId"], $game->getId());
                if($subGame){
                    $agentSubGames[] = $subGame;
                }
            }
        }

        return $this->setView('user/subgame/list', [
            'agent_subgames' => $agentSubGames,
        ]);
    }
}