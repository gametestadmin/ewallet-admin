<?php

namespace System\Widgets;

class AuthFormEditWidget extends BaseWidget
{
    public function getContent()
    {
        return $this->setView('auth/edit', []);
    }
}