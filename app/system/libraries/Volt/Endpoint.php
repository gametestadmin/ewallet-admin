<?php
namespace Volt\Libraries;

use System\Datalayer\DLProviderGameEndpointAuth;
use System\Library\General\GlobalVariable;

class Endpoint
{
    public static function endPointType($data){
        if(substr($data,0,1) == 1){
            $providerGameEndpoints = GlobalVariable::$transferProviderGameEndpointTypes;
        }else{
            $providerGameEndpoints = GlobalVariable::$seamlessProviderGameEndpointTypes;
        }

        foreach ($providerGameEndpoints as $providerGameEndpoint => $providerGameEndpointValue){
            if($data == $providerGameEndpoint){
                return $providerGameEndpointValue;
            }
        }
    }

    public static function endPointAuth($id){
        $dlProviderGameEndpointAuth = new DLProviderGameEndpointAuth;
        $providerGameEndpointAuth = $dlProviderGameEndpointAuth->findFirstById($id);

        if($id == 0){
            return "-";
        }
        return $providerGameEndpointAuth['aid'].":".$providerGameEndpointAuth['asc'];
    }
}
