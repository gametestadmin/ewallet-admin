<?php

namespace System\Widgets;

use System\Datalayer\DLCurrency;
use System\Datalayer\DLUserCurrency;

class UserCurrencyFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        $dlCurrency = new DLCurrency();
        $dlUserCurrency = new DLUserCurrency();

        $parentId = $this->params['loginId'];
        $agentId = $this->params['agentId'];

        $parentCurrencies = $dlUserCurrency->findAllByAgent($parentId,1);
        $agentCurrencies = $dlUserCurrency->findAllByAgent($agentId,1);

//        var_dump($parentId);
//        var_dump($parentCurrencies);
//        var_dump($agentId);
//        var_dump($agentCurrencies);
//        die;

        $currencyList = array();

        foreach ($parentCurrencies as $parentCurrency){
            $currency = $dlCurrency->findFirstById($parentCurrency['cu']['id']);
            $currencyList[$parentCurrency['cu']['id']] = $currency;
        }

        foreach ($agentCurrencies as $agentCurrency){
            if(isset($currencyList[$agentCurrency['cu']['id']]))
                unset($currencyList[$agentCurrency['cu']['id']]);
        }

        return $this->setView('currency/user/add', [
            'currency' => $currencyList,
        ]);
    }
}