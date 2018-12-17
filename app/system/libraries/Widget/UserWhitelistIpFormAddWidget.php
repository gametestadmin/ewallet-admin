<?php

namespace System\Widgets;

class UserWhitelistIpFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        return $this->setView('ip/user/add', []);
    }
}