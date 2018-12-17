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

        $gameCurrencies = $dlGameCurrency->findByGame($gameId);
        $currencies = $dlCurrency->findAllByStatus(1);

        $currencyList = array();

        if($gameType == 2){
            foreach ($currencies as $currency){
                $currencyData = $dlCurrency->findFirstById($currency['id']);
                $currencyList[$currency['id']] = $currencyData;
            }
        } elseif($gameType == 3){
            $parentCurrencies = $dlGameCurrency->findByGame($gameParent);

            foreach ($parentCurrencies as $parentCurrency){
                $currencyData = $dlCurrency->findFirstById($parentCurrency['cu']['id']);
                $currencyList[$parentCurrency['cu']['id']] = $currencyData;
            }
        }

        if($gameCurrencies) {
            foreach ($gameCurrencies as $gameCurrency) {
                if (isset($currencyList[$gameCurrency['cu']['id']]))
                    unset($currencyList[$gameCurrency['cu']['id']]);
            }
        }

        return $this->setView('currency/game/add', [
            'currency' => $currencyList
        ]);
    }
}