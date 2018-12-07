<?php
namespace Volt\Libraries;

use System\Datalayer\DLProviderGameEndpointAuth;
use System\Library\General\GlobalVariable;

class Endpoint
{
    public static function endPointType($data){
        $providerGameEndpointType = GlobalVariable::$providerGameEndpointType;
        foreach ($providerGameEndpointType as $key => $value){
            if($data == $value){
                return $key;
            }
        }
    }

    public static function endPointAuth($id){
        $dlProviderGameEndpointAuth = new DLProviderGameEndpointAuth;
        $providerGameEndpointAuth = $dlProviderGameEndpointAuth->getById($id);

        if($id == 0){
            return "-";
        }
        return $providerGameEndpointAuth->getAppId().":".$providerGameEndpointAuth->getAppSecret();
    }
}
