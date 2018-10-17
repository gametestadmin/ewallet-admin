<?php

namespace System\Widgets;

use System\Datalayer\DLUserCurrency;

class UserCurrencyFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        $DLUserCurrency = new DLUserCurrency();

        $parentId = $this->params['loginId'];
        $agentId = $this->params['agentId'];

        $parentCurrencies = $DLUserCurrency->getByUser($parentId);
        $agentCurrencies = $DLUserCurrency->getByUser($agentId);

        $currencyList = array();

        foreach ($parentCurrencies as $parentCurrency){
            $currencyList[$parentCurrency->getCurrency()] = $parentCurrency->getCurrency();
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