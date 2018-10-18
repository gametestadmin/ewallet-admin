<?php
namespace System\Library\Security;

use System\Datalayer\DLUser;

class Agent
{
    public function checkAgentAction($parentUsername,$agentUsername,$type = 1){
//        $realType = false;

        $dlUser = new DLUser();
        $parent = $dlUser->getByUsername($parentUsername);
        $child = $dlUser->getByUsername($agentUsername);

        $directUsername = \substr($agentUsername, 0, \strlen($parentUsername));

        if($parent->getType() == 9 || $parentUsername == $directUsername){
            $realType = 1;
        } elseif($parent->getType() == 9 || $parent->getId() == $child->getParent()){
            $realType = 2;
        } else{
            $realType = 3;
        }

//        echo "<pre>";
//        var_dump('direct username '.$directUsername);
//        var_dump('parent username '.$parentUsername);
//        var_dump('agent username '.$agentUsername);
//        var_dump('realtype '.$realType);
//        var_dump('type '.$type);
//        var_dump('parent id '.$parent->getId().' | child parent '.$child->getParent());
//        var_dump('parent type '.$parent->getType());
//        if($type <= $realType){
//            var_dump(true);
//        }
//        die;

        if($type >= $realType){
            return true;
        }

        return false;
    }
}