<?php

namespace System\Widgets;

use System\Datalayer\DLProviderGameEndpoint;
use System\Datalayer\DLProviderGameEndpointAuth;
use System\Library\General\GlobalVariable;

class EndpointFormAddWidget extends BaseWidget
{
    public function getContent()
    {
        $dlProviderGameEndpointAuth = new DLProviderGameEndpointAuth();
        $providerGameEndpointAuth = $dlProviderGameEndpointAuth->getAll($this->params["id"]);

        $dlProviderGameEndpoint = new DLProviderGameEndpoint();
        $providerGameEndpoints = $dlProviderGameEndpoint->getAll($this->params['id']);

        $providerGameEndpointTypes = GlobalVariable::$providerGameEndpointTypes;

        $endpointList = array();

        foreach ($providerGameEndpointTypes as $providerGameEndpointType => $providerGameEndpointTypeValue){
            $endpoint = $providerGameEndpointTypes[$providerGameEndpointType];
            $endpointList[$providerGameEndpointType] = $endpoint;
        }

        foreach ($providerGameEndpoints as $providerGameEndpoint){
            if(isset($endpointList[$providerGameEndpoint->getType()]))
                unset($endpointList[$providerGameEndpoint->getType()]);
        }

        $httpList = GlobalVariable::$httpList;

        return $this->setView('endpoint/add', [
            'providerGameEndpoint' => $providerGameEndpointAuth,
            'providerGameEndpointTypes' => $endpointList,
            'httpList' => $httpList,
        ]);
    }
}