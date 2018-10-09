<?php

namespace System\Widgets;

class MenuWidget extends BaseWidget
{
    public function getContent()
    {
        $view = $this->view;

        return $this->setView('menu/menu', []);
    }
}