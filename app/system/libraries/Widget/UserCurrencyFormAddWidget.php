<?php

namespace System\Widgets;

use System\Datalayer\DLCurrency;
use System\Datalayer\DLUserCurrency;

class UserCurrencyFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        $DLUserCurrency = new DLUserCurrency();

//        $currency = $DLUserCurrency->getAllByUserAndParent($this->params['loginId'],$this->params['agentId']);
        $currency = $DLUserCurrency->getAllByUser($this->params['loginId']);
//        $agentCurrency = $DLUserCurrency->getAllByUser($this->params['agentId']);

        return $this->setView('currency/user/add', [
            'currency' => $currency,
//            'parentCurrency' => $parentCurrency,
//            'agentCurrency' => $agentCurrency,
        ]);
    }
}