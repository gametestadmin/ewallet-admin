<?php

namespace System\Widgets;


class GameWhitelistIpFormEditWidget extends BaseWidget
{
    public function getContent()
    {
        return $this->setView('ip/edit', [
            'gameId' => $this->params["id"],
        ]);
    }
}