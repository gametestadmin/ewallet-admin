<?php

namespace System\Widgets;

use System\Datalayer\DLProviderGameEndpoint;
use System\Datalayer\DLProviderGameEndpointAuth;
use System\Library\General\GlobalVariable;

class EndpointFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        $gameId = $this->params["gameId"];

        $dlProviderGameEndpointAuth = new DLProviderGameEndpointAuth();
        $providerGameEndpointAuth = $dlProviderGameEndpointAuth->findByGame($gameId);

        $dlProviderGameEndpoint = new DLProviderGameEndpoint();
        $providerGameEndpoints = $dlProviderGameEndpoint->findByGame($gameId);

        $httpList = GlobalVariable::$httpList;

        // Transfer
        $transferProviderGameEndpointTypes = GlobalVariable::$transferProviderGameEndpointTypes;
        $transferEndpointList = array();

        foreach ($transferProviderGameEndpointTypes as $transferProviderGameEndpointType => $transferProviderGameEndpointTypeValue){
            $transferEndpoint = $transferProviderGameEndpointTypes[$transferProviderGameEndpointType];
            $transferEndpointList[$transferProviderGameEndpointType] = $transferEndpoint;
        }

        foreach ($providerGameEndpoints as $providerGameEndpoint){
            if(isset($transferEndpointList[$providerGameEndpoint['tp']]))
                unset($transferEndpointList[$providerGameEndpoint['tp']]);
        }

        // Seamless
        $seamlessProviderGameEndpointTypes = GlobalVariable::$seamlessProviderGameEndpointTypes;
        $seamlessEndpointList = array();

        foreach ($seamlessProviderGameEndpointTypes as $seamlessProviderGameEndpointType => $seamlessProviderGameEndpointTypeValue){
            $seamlessEndpoint = $seamlessProviderGameEndpointTypes[$seamlessProviderGameEndpointType];
            $seamlessEndpointList[$seamlessProviderGameEndpointType] = $seamlessEndpoint;
        }

        foreach ($providerGameEndpoints as $providerGameEndpoint){
            if(isset($seamlessEndpointList[$providerGameEndpoint['tp']]))
                unset($seamlessEndpointList[$providerGameEndpoint['tp']]);
        }

        return $this->setView('endpoint/add', [
            'providerGameEndpoint' => $providerGameEndpointAuth,
            'transferProviderGameEndpointTypes' => $transferEndpointList,
            'seamlessProviderGameEndpointTypes' => $seamlessEndpointList,
            'httpList' => $httpList,
        ]);
    }
}