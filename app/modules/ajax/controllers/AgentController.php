<?php
namespace Backoffice\Ajax\Controllers;

use System\Model\User;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLUserCurrency;
use System\Datalayer\DLUserGame;

class AgentController extends \Backoffice\Controllers\BaseController
{
    public function checkAction()
    {
        $this->view->disable();

        $response = new \Phalcon\Http\Response();
        $response->setContentType("application/json");
        $message = "";

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            if(isset($data['code'])){
                $code = \implode($data['code']);
                $user = User::findFirst(
                    array(
                        "conditions" => "username = :code: OR nickname = :code:",
                        "bind" => array(
                            "code" => $code
                        )
                    )
                );
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
    }

    public function gameAction()
    {
        $this->view->disable();

        $response = new \Phalcon\Http\Response();
        $response->setContentType("application/json");
        $message = "";

//        if ($this->request->getPost()) {
//            $data = $this->request->getPost();
//            var_dump($data);
//            die;
//        }
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

//        echo "<pre>";
        foreach($games as $game){
            if($game->getGameParent() != $categoryId)continue;

//            $response->setStatusCode(404);
//            $response->setContent($message);
//            return $response;
            var_dump($game->getName());
        }
//        var_dump($games);
        die;
    }
}
