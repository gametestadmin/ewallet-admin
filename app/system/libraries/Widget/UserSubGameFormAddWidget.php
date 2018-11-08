<?php

namespace System\Widgets;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLUser;
use System\Datalayer\DLUserCurrency;
use System\Datalayer\DLUserGame;

class UserSubGameFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        $parent = $this->params["loginId"];
        $agent = $this->params["agentId"];
        $gameId = $this->params['gameId'];

        $dlUser = new DLUser();
        $parentData = $dlUser->getById($parent);

        $dlUserGame = new DLUserGame();
        $dlUserCurrency = new DLUserCurrency();

        $dlGame = new DLGame();
        $dlGameCurrency = new DLGameCurrency();

        $subGames = array();

        $agentCurrencies = array();
        $agentCurrencyData = $dlUserCurrency->getAgentCurrencies($agent,1);

        foreach ($agentCurrencyData as $agentCurrency) {
            $agentCurrencies[] = $agentCurrency->getCurrency();
        }

        if($parentData->getType() <> 9) {
            $subGameLists = $dlGame->getByGameParent($gameId);
            foreach ($subGameLists as $subGameList) {
                $parentSubGame = $dlUserGame->getAgentGameAndGameId($parent,$subGameList->getId(),3);
                if($parentSubGame) {
                    $subGameCurrencies = array();
                    $subGameCurrencyData = $dlGameCurrency->getByGameAndStatus($parentSubGame->getGame());

                    foreach ($subGameCurrencyData as $subGameCurrency) {
                        $subGameCurrencies[] = $subGameCurrency->getCurrency();
                    }

                    if (count(array_intersect($agentCurrencies, $subGameCurrencies)) > 0) {
                        $subGame = $dlGame->getById($parentSubGame->getGame());
                        $subGames[$parentSubGame->getGame()] = $subGame;
                    }
                }
            }
        }else{
            $companySubGames = $dlGame->getByGameParent($gameId);
            foreach ($companySubGames as $companySubGame){
                $subGameCurrencies = array();
                $subGameCurrencyData = $dlGameCurrency->getByGameAndStatus($companySubGame->getId());

                foreach ($subGameCurrencyData as $subGameCurrency){
                    $subGameCurrencies[] = $subGameCurrency->getCurrency();
                }

                if(count(array_intersect($agentCurrencies, $subGameCurrencies)) > 0){
                    $subGame = $dlGame->getById($companySubGame->getId());
                    $subGames[$companySubGame->getId()] = $subGame;
                }
            }
        }

        $agentSubGames = $dlUserGame->getAgentGame($agent,3,0);
        foreach ($agentSubGames as $agentSubGame){
            if(isset($subGames[$agentSubGame->getGame()]))
                unset($subGames[$agentSubGame->getGame()]);
        }

        return $this->setView('user/subgame/add', [
            'subGames' => $subGames,
        ]);
    }
}