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

        $parentCurrencies = $dlUserCurrency->getByUser($parentId);
        $agentCurrencies = $dlUserCurrency->getByUser($agentId);

        $currencyList = array();

        foreach ($parentCurrencies as $parentCurrency){
            $currency = $dlCurrency->getById($parentCurrency->getCurrency());
            $currencyList[$parentCurrency->getCurrency()] = $currency;
        }

        foreach ($agentCurrencies as $agentCurrency){
            if(isset($currencyList[$agentCurrency->getCurrency()]))
                unset($currencyList[$agentCurrency->getCurrency()]);
        }

        return $this->setView('currency/user/add', [
            'currency' => $currencyList,
        ]);
    }
}