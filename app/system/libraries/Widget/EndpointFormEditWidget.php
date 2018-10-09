<?php

namespace System\Widgets;

use System\Datalayer\DLProviderGameEndpointAuth;
use System\Library\General\GlobalVariable;

class EndpointFormEditWidget extends BaseWidget
{
    public function getContent()
    {
        $DLProviderGameEndpointAuth = new DLProviderGameEndpointAuth();
        $providerGameEndpointAuth = $DLProviderGameEndpointAuth->getAll($this->params["id"]);

        $providerGameEndpointType = GlobalVariable::$providerGameEndpointType;
        $httpList = GlobalVariable::$httpList;

        return $this->setView('endpoint/edit', [
            'providerGameEndpoint' => $providerGameEndpointAuth,
            'providerGameEndpointType' => $providerGameEndpointType,
            'httpList' => $httpList,
        ]);
    }
}