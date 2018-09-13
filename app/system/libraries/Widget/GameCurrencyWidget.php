<?php

namespace System\Widgets;

class GameCurrencyWidget extends BaseWidget
{
    public function getContent()
    {
        $view = $this->view;

        return $this->setView('game/currency', []);
    }
}