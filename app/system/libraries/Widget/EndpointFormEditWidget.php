<?php

namespace System\Widgets;

use System\Datalayer\DLProviderGameEndpointAuth;
use System\Library\General\GlobalVariable;

class EndpointFormEditWidget extends BaseWidget
{
    public function getContent()
    {
        $gameId = $this->params["gameId"];

        $dlProviderGameEndpointAuth = new DLProviderGameEndpointAuth();
        $providerGameEndpointAuth = $dlProviderGameEndpointAuth->findByGame($gameId);

        $httpList = GlobalVariable::$httpList;
//        $providerGameEndpointTypes = GlobalVariable::$transferProviderGameEndpointTypes;

        $transferProviderGameEndpointTypes = GlobalVariable::$transferProviderGameEndpointTypes;
        $seamlessProviderGameEndpointTypes = GlobalVariable::$seamlessProviderGameEndpointTypes;

        $providerGameEndpointTypes = $transferProviderGameEndpointTypes+$seamlessProviderGameEndpointTypes;

        return $this->setView('endpoint/edit', [
            'providerGameEndpoint' => $providerGameEndpointAuth,
            'providerGameEndpointTypes' => $providerGameEndpointTypes,
            'transferProviderGameEndpointTypes' => $transferProviderGameEndpointTypes,
            'seamlessProviderGameEndpointTypes' => $seamlessProviderGameEndpointTypes,
            'httpList' => $httpList,
        ]);
    }
}