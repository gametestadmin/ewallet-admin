<?php

namespace System\Widgets;


class UserWhitelistIpFormEditWidget extends BaseWidget
{
    public function getContent()
    {
        return $this->setView('ip/user/edit', [
            'userId' => $this->params["id"],
        ]);
    }
}