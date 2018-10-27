<?php

namespace System\Widgets;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLUser;
use System\Datalayer\DLUserCurrency;
use System\Datalayer\DLUserGame;
use System\Model\Game;

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

        $games = array();

        $agentCurrencies = array();
        $agentCurrencyData = $dlUserCurrency->getAll($agent);
        foreach ($agentCurrencyData as $agentCurrency) {
            $agentCurrencies[] = $agentCurrency->getCurrency();
        }

        if($parentData->getType() <> 9) {
            $parentGames = $dlGame->getByGameParent($gameId);
            foreach ($parentGames as $parentGame) {
                $gameCurrencies = array();
                $gameCurrencyData = $dlGameCurrency->getByGameAndStatus($parentGame->getId());

                foreach ($gameCurrencyData as $gameCurrency){
                    $gameCurrencies[] = $gameCurrency->getCurrency();
                }

                if(count(array_intersect($agentCurrencies, $gameCurrencies)) > 0){
                    $games[] = $dlGame->getById($parentGame->getId());
                }
            }
        }else{
            $companyGames = $dlGame->getByGameParent($gameId);
            foreach ($companyGames as $companyGame){
                $gameCurrencies = array();
                $gameCurrencyData = $dlGameCurrency->getByGameAndStatus($companyGame->getId());

                foreach ($gameCurrencyData as $gameCurrency){
                    $gameCurrencies[] = $gameCurrency->getCurrency();
                }

                if(count(array_intersect($agentCurrencies, $gameCurrencies)) > 0){
                    $games[] = $dlGame->getById($companyGame->getId());
                }
            }
        }

        return $this->setView('user/subgame/add', [
            'games' => $games,
        ]);
    }
}