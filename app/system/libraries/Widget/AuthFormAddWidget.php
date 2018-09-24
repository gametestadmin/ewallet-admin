<?php

namespace System\Widgets;

class AuthFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        return $this->setView('auth/add', []);
    }
}