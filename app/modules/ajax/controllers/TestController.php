<?php
namespace Backoffice\Ajax\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLUser;
use System\Datalayer\DLUserCurrency;
use System\Datalayer\DLUserGame;

class TestController extends \Backoffice\Controllers\BaseController
{
    public function indexAction()
    {
        $data['code'] = ['A','A'];

        if(isset($data['code'])){
            $code = \implode($data['code']);

            $dlUser = new DLUser();
            $downlineUsername = $dlUser->findFirstByUsername($code);
            $downlineNickname = $dlUser->findFirstByNickname($code);

            var_dump($downlineUsername);
            var_dump($downlineNickname);
            if($downlineUsername == false && $downlineNickname == false){
                echo "tidak ada";
            }else{
                echo "ada";
            }
//            var_dump($code);
//            var_dump($downlineUsername);
//            var_dump($downlineNickname);
            die;
            if($user == false) {
                $message = 0;
                $response->setStatusCode(200);
                $response->setContent($message);
            }elseif($user == true){
                $message = 1;
                $response->setStatusCode(200);
                $response->setContent($message);
            }else{
                $response->setStatusCode(404);
                $response->setContent($message);
            }
        }
        return $response;
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
