<?php

namespace System\Widgets;

use System\Datalayer\DLCurrency;

class GameCurrencyFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        $view = $this->view;

        $DLCurrency = new DLCurrency();
        $currency = $DLCurrency->getAllByStatus(1);

        return $this->setView('currency/game/add', [
            'currency' => $currency
        ]);
    }
}