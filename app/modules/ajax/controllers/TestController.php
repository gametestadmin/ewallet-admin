<?php
namespace Backoffice\Ajax\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLUserCurrency;
use System\Datalayer\DLUserGame;

class TestController extends \Backoffice\Controllers\BaseController
{
    public function indexAction()
    {
        $parent = 54;
        $agent = 57;

        $dlUserGame = new DLUserGame();
        $dlUserCurrency = new DLUserCurrency();

        $dlGame = new DLGame();
        $dlGameCurrency = new DLGameCurrency();

        $games = array();

//        echo "<pre>";
        $agentCurrencies = array();
        $agentCurrencyData = $dlUserCurrency->getAll($agent);
        foreach ($agentCurrencyData as $agentCurrency) {
//            var_dump($agentCurrency->getCurrency());
            $agentCurrencies[] = $agentCurrency->getCurrency();
        }

        $parentGames = $dlUserGame->getParentGame($parent);

        if(count($parentGames) > 0) {
            foreach ($parentGames as $parentGame) {
                $gameCurrencies = array();
                $gameCurrencyData = $dlGameCurrency->getByGameAndStatus($parentGame->getGame());
//                var_dump($parentGame->getGame());
                foreach ($gameCurrencyData as $gameCurrency){
//                    var_dump($gameCurrency->getCurrency());
                    $gameCurrencies[] = $gameCurrency->getCurrency();
                }

                if(count(array_intersect($agentCurrencies, $gameCurrencies)) > 0){
                    $games[] = $dlGame->getById($parentGame->getGame());
                }
            }
//            die;
        }else{
            $games = $dlGame->getAll(2);
        }

        $categories = array();

        echo "<pre>";
        echo "game<br>";
        foreach($games as $game){
            $categories[$game->getGameParent()] = $dlGame->getById($game->getGameParent());
            var_dump($game->getName());
        }

        echo "category<br>";
        foreach($categories as $category){
            var_dump($category->getName());
        }
        die;
    }

    public function selectAction()
    {
        $categoryId = 149;

        $parent = 54;
        $agent = 57;

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

        $parentGames = $dlUserGame->getParentGame($parent);

        if(count($parentGames) > 0) {
            foreach ($parentGames as $parentGame) {
                $gameCurrencies = array();
                $gameCurrencyData = $dlGameCurrency->getByGameAndStatus($parentGame->getGame());

                foreach ($gameCurrencyData as $gameCurrency){
                    $gameCurrencies[] = $gameCurrency->getCurrency();
                }

                if(count(array_intersect($agentCurrencies, $gameCurrencies)) > 0){
                    $games[] = $dlGame->getById($parentGame->getGame());
                }
            }
        }else{
            $games = $dlGame->getAll(2);
        }

        echo "<pre>";
        foreach($games as $game){
            if($game->getGameParent() != $categoryId)continue;
            var_dump($game->getName());
        }
//        var_dump($games);
        die;
    }
}
