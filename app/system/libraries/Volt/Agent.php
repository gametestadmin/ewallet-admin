<?php
namespace Volt\Libraries;

use System\Library\General\GlobalVariable;

class Agent
{
    public static function agentType($type)
    {
        $agentType = GlobalVariable::$agentType;
        foreach ($agentType as $key => $value) {
            if($type == $value) {
                return $key;
            }
        }
    }

    public static function agentStatus($status)
    {
        $agentStatus = GlobalVariable::$threeLayerStatus;
        foreach ($agentStatus as $key => $value) {
            if($status == $value) {
                return $key;
            }
        }
    }
}
