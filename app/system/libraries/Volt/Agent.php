<?php
namespace Volt\Libraries;

use System\Library\General\GlobalVariable;

class Agent
{
    public static function agentType($type)
    {
        $agentType = GlobalVariable::$agentType;
        foreach ($agentType as $key => $value) {
            if($type == $key) {
                return $value;
            }
        }
    }

    public static function agentStatus($status)
    {
        $agentStatus = GlobalVariable::$threeLayerStatusTypes;
        foreach ($agentStatus as $key => $value) {
            if($status == $key) {
                return $value;
            }
        }
    }
}
