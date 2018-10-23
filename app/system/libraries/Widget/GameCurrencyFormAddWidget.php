<?php

namespace System\Widgets;

use System\Datalayer\DLCurrency;
use System\Datalayer\DLGameCurrency;

class GameCurrencyFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        $dlCurrency = new DLCurrency();
        $dlGameCurrency = new DLGameCurrency();

        $gameId = $this->params['gameId'];
        $gameParent = $this->params['gameParent'];
        $gameType = $this->params['gameType'];

        $gameCurrencies = $dlGameCurrency->getByGame($gameId);
        $currencies = $dlCurrency->getAllByStatus(1);

        $currencyList = array();

        if($gameType == 2){
            foreach ($currencies as $currency){
                $currencyData = $dlCurrency->getById($currency->getId());
                $currencyList[$currency->getId()] = $currencyData;
            }
        } elseif($gameType == 3){
            $parentCurrencies = $dlGameCurrency->getByGame($gameParent);

            foreach ($parentCurrencies as $parentCurrency){
                $currencyData = $dlCurrency->getById($parentCurrency->getCurrency());
                $currencyList[$parentCurrency->getCurrency()] = $currencyData;
            }
        }

        foreach ($gameCurrencies as $gameCurrency){
            if(isset($currencyList[$gameCurrency->getCurrency()]))
                unset($currencyList[$gameCurrency->getCurrency()]);
        }

        return $this->setView('currency/game/add', [
            'currency' => $currencyList
        ]);
    }
}