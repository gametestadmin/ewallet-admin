<?php

namespace System\Widgets;

class GameWhitelistIpFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        return $this->setView('ip/add', []);
    }
}