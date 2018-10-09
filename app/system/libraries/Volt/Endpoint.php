<?php
namespace Volt\Libraries;

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
}
