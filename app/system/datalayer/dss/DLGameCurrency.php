<?php
namespace System\Datalayer;

use System\Model\Currency;
use System\Model\Game;
use System\Model\GameCurrency;

class DLGameCurrency extends \System\Datalayers\Main{
    // DSS
    public function findByCurrency($currency){
        $postData = array(
            'currency' => $currency
        );

        $url = '/gc/find';
        $gameCurrency = $this->curlAppsJson($url,$postData);

        return $gameCurrency['gc'];
    }

    public function findByGame($game){
        $postData = array(
            'game' => $game,
            'currency_status' => 1
        );

//        $url = '/gc/game/'.$postData['game'];
        $url = '/gc/find/';
        $gameCurrency = $this->curlAppsJson($url,$postData);

        return $gameCurrency['gc'];
    }

    public function findFirstByGameAndDefault($game){
        $postData = array(
            'game' => $game,
        );

        $url = '/gc/game'.$postData['game'];
        $gameCurrency = $this->curlAppsJson($url,$postData);

        return $gameCurrency['gc'];
    }

    public function filterData($data){
        $filterData = array();

        if(isset($data["currency"])) $filterData['idcu'] = \intval($data['currency']);
        if(isset($data['game'])){
            $filterData['idgm'] = \intval($data['game']);

            $filterData['df'] = intval(0);
            $gameCurrencies = $this->findByGame($filterData['idgm']);
            if(!isset($gameCurrencies[0])){
                $filterData['df'] = intval(1);
            }
        }

        $filterData['st'] = (isset($data["status"])?\intval($data['status']):1);
        $filterData['cust'] = (isset($data["currency_status"])?\intval($data['currency_status']):1);

        return $filterData;
    }

    public function setCurrencyFromParent($parentId,$gameId){
        $parentGameCurrency = $this->findByGame($parentId);

        if(isset($parentGameCurrency['pgc'][0])){
            foreach ($parentGameCurrency as $key => $value){
                $postData[] = array(
                    'idgm' => $gameId,
                    'idcu' => $value['cu']['id'],
                    'df' => $value['df'],
                    'cust' => 1,
                    'st' => 1,
                );
                $this->create($postData[$key]);
            }
        }

        return true;
    }

//    public function validateCreate($data){
//        $dlGame = new DLGame();
//        $game = $dlGame->getById($data['game']);
//
//        if(!$this->checkGame($data['game'])){
//            throw new \Exception('undefined_game');
//        }
//        elseif(!$this->checkCurrency($data['currency'])){
//            throw new \Exception('undefined_currency');
//        }elseif($this->checkCurrentGameCurrency($data['game'],$data['currency'])){
//            throw new \Exception('currency_exist');
//        }
//        if($game->gettype() == 3) {
//            if (!$this->checkCurrencyFromParent($game->getGameParent(), $data['currency'])){
//                throw new \Exception('undefined_currency_from_parent');
//            }
//        }
//
//        return true;
//    }

    public function create($postData){
        $url = '/gc/insert';
        $gameCurrency = $this->curlAppsJson($url,$postData);

        return $gameCurrency;
    }

    public function setDefault($postData){
        $gameCurrencies = $this->findByGame($postData['game_id']);

        foreach ($gameCurrencies as $gameCurrency){
            if ($gameCurrency['df'] == 1){
                $data = array(
                    'df' => 0
                );
                $url = '/gc/'.$gameCurrency['id'].'/update/';
            }else{
                $data = array(
                    'df' => 1
                );
                $url = '/gc/'.$postData['id'].'/update/';
            }
            $this->curlAppsJson($url,$data);
        }

        return true;
    }

    public function set($postData){
        $url = '/gc/'.$postData['id'].'/update/';
        $gameCurrencies = $this->curlAppsJson($url,$postData);

        return true;
    }

    // END DSS

    public function getAll($game){
        $gameCurrency = GameCurrency::findByGame($game);

        return $gameCurrency;
    }

    public function getByGameAndStatus($game){
        $gameCurrency = GameCurrency::find(
            array(
                "conditions" => "game = :game: AND status = 1",
                "bind" => array(
                    "game" => $game
                )
            )
        );

        return $gameCurrency;
    }

    public function getByGame($game){
        $gameCurrency = GameCurrency::findByGame($game);

        return $gameCurrency;
    }

    public function getById($id){
        $gameCurrency = GameCurrency::findFirstById($id);

        return $gameCurrency;
    }

    public function getByIdAndDefault($game){
        $gameCurrency = GameCurrency::findFirst(
            array(
                "conditions" => "game = :game: AND default = 1",
                "bind" => array(
                    "game" => $game
                )
            )
        );

        return $gameCurrency;
    }

    public function checkGame($game){
        $game = Game::findFirstById($game);

        return $game;
    }

    public function checkCurrency($currency){
        $currency = Currency::findFirstById($currency);

        return $currency;
    }

    public function checkCurrencyFromParent($parent,$currency){
        $parentCurrency = GameCurrency::findFirst(
            array(
                "conditions" => "game = :parent: AND currency = :currency:",
                "bind" => array(
                    "parent" => $parent,
                    "currency" => $currency,
                )
            )
        );

        return $parentCurrency;
    }

    public function checkCurrentGameCurrency($game,$currency){
        $gameCurrency = GameCurrency::findFirst(
            array(
                "conditions" => "game = :game_id: AND currency = :currency_id:",
                "bind" => array(
                    "game_id" => $game,
                    "currency_id" => $currency,
                )
            )
        );

        return $gameCurrency;
    }

    public function filterInput($data){
        if(isset($data["currency"])) $data['currency'] = \intval($data['currency']);
        if(isset($data["game"])) $data['game'] = \intval($data['game']);

        return $data;
    }

    public function validateAdd($data){
        $dlGame = new DLGame();
        $game = $dlGame->getById($data['game']);

        if(!$this->checkGame($data['game'])){
            throw new \Exception('undefined_game');
        }
        elseif(!$this->checkCurrency($data['currency'])){
            throw new \Exception('undefined_currency');
        }elseif($this->checkCurrentGameCurrency($data['game'],$data['currency'])){
            throw new \Exception('currency_exist');
        }
        if($game->gettype() == 3) {
            if (!$this->checkCurrencyFromParent($game->getGameParent(), $data['currency'])){
                throw new \Exception('undefined_currency_from_parent');
            }
        }

        return true;
    }

    public function creates($data){
        $newGameCurrency = new GameCurrency();

        if(isset($data["game"]))$newGameCurrency->setGame($data['game']);
        if(isset($data["currency"]))$newGameCurrency->setCurrency($data['currency']);
        if(count($this->getAll($data['game'])) == 0){
            $newGameCurrency->setDefault(1);
        }else {
            $newGameCurrency->setDefault(0);
        }

        if(!$newGameCurrency->save()){
            throw new \Exception('error_add_game_currency');
        }

        return true;
    }

    public function sets($data){
        $gameId = $data["game_id"];
        $gameCurrencyId = $data["currency_id"];

        $currentGameCurrency = $this->getByIdAndDefault($gameId);

        $currentGameCurrency->setDefault(0);

        if($currentGameCurrency->save()){
            $gameCurrency = $this->getById($gameCurrencyId);

            $gameCurrency->setDefault(1);

            if(!$gameCurrency->save()){
                throw new \Exception('error_set_currency');
            }
        }else{
            throw new \Exception('error_set_currency');
        }
        return $gameCurrency;
    }


    public function setFromParent($parentId,$gameId){
        $parentGameCurrency = $this->getAll($parentId);

        if(count($parentGameCurrency) == 0){
            return true;
        }else{
            foreach ($parentGameCurrency as $key => $value){
                $childGameCurrency = new GameCurrency();
                $childGameCurrency->setGame($gameId);
                $childGameCurrency->setCurrency($value->getCurrency());
                $childGameCurrency->setDefault($value->getDefault());

                if(!$childGameCurrency->save()){
                    throw new \Exception($childGameCurrency->getMessages());
                }
            }
        }
    }
}