<?php

namespace System\Widgets;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLUser;
use System\Datalayer\DLUserCurrency;
use System\Datalayer\DLUserGame;

class UserGameFormAddWidget extends BaseWidget
{
    public function getContent()
    {
//        echo "<pre>";
//        $parent = $this->params["loginId"];
//        $agent = $this->params["agentId"];
//
//        $dlUser = new DLUser();
//        $parentData = $dlUser->getById($parent);
//
//        $dlUserGame = new DLUserGame();
//        $dlUserCurrency = new DLUserCurrency();
//
//        $dlGame = new DLGame();
//        $dlGameCurrency = new DLGameCurrency();
//
//        $games = array();
//
//        $agentCurrencies = array();
//        $agentCurrencyData = $dlUserCurrency->getUserCurrencies($agent);
//        foreach ($agentCurrencyData as $agentCurrency) {
//            $agentCurrencies[] = $agentCurrency->getCurrency();
//        }
//
//        $parentGames = $dlUserGame->getParentGame($parent,2);
//
//        if($parentData->getType() <> 9) {
//            foreach ($parentGames as $parentGame) {
//                $gameCurrencies = array();
//                $gameCurrencyData = $dlGameCurrency->getByGameAndStatus($parentGame->getGame());
//
//                foreach ($gameCurrencyData as $gameCurrency){
//                    $gameCurrencies[] = $gameCurrency->getCurrency();
//                }
//                if(count(array_intersect($agentCurrencies, $gameCurrencies)) > 0){
//                    $game = $dlGame->getById($parentGame->getGame());
//                    $games[$parentGame->getGame()] = $game;
////                    $games[] = $dlGame->getById($parentGame->getGame());
//                }
//            }
//        }else{
//            $companyGames = $dlGame->getAll(2);
//            foreach ($companyGames as $companyGame){
//                $gameCurrencies = array();
//                $gameCurrencyData = $dlGameCurrency->getByGameAndStatus($companyGame->getId());
//
//                foreach ($gameCurrencyData as $gameCurrency){
//                    $gameCurrencies[] = $gameCurrency->getCurrency();
//                }
//
//                if(count(array_intersect($agentCurrencies, $gameCurrencies)) > 0){
//                    $game = $dlGame->getById($companyGame->getId());
//                    $games[$companyGame->getId()] = $game;
//                }
//            }
//        }
//
//        $agentGames = $dlUserGame->getAgentGame($agent,2,0);
//        foreach ($agentGames as $agentGame){
//            if(isset($games[$agentGame->getGame()])) {
//                unset($games[$agentGame->getGame()]);
//            }
//        }
//
//        $categories = array();
//
//        foreach($games as $game){
//            $categories[$game->getGameParent()] = $dlGame->getById($game->getGameParent());
//        }
//
//        return $this->setView('user/game/add', [
//            'games' => $games,
//            'categories' => $categories,
//        ]);
    }
}