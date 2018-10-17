<?php
namespace System\Library\Security;

class Agent
{
    public function checkAgentAction($parentUsername,$parentType,$agentUsername,$type = 1){
        $realType = 0;

        if($parentType <> 9 && $parentUsername == $agentUsername){
            $realType = 1;
        }elseif($parentType <> 9 && $parentUsername <> $agentUsername){
            $realType = 2;
        }

        if($parentType <> 9 && $type <= $realType){
//            var_dump($parentUsername);
//            var_dump($parentType);
//            var_dump($agentUsername);
//            var_dump($realType);
//            var_dump($type);
//            var_dump($a);
//            die;
            return true;
        }

//        var_dump($parentUsername);
//        var_dump($parentType);
//        var_dump($agentUsername);
//        var_dump($realType);
//        var_dump($type);
//        var_dump($a);
//        die;


        return false;
    }
}