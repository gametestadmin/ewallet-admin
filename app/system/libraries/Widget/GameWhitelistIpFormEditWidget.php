<?php

namespace System\Widgets;


class GameWhitelistIpFormEditWidget extends BaseWidget
{
    public function getContent()
    {
        return $this->setView('ip/game/edit', [
            'gameId' => $this->params["gameId"],
        ]);
    }
}