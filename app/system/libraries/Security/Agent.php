<?php
namespace System\Library\Security;

use System\Datalayer\DLUser;

class Agent
{
    public function checkAgentAction($parentUsername, $agentUsername, $checkType = 1){
        $dlUser = new DLUser();
        $parent = $dlUser->getByUsername($parentUsername);

        if($parent->getType() == 9) {
            $realType = 3;
        }else {
            $child = $dlUser->getByUsername($agentUsername);

            $directUsername = \substr($agentUsername, 0, \strlen($parentUsername));

            $realType = false;
            if ($parent->getId() == $child->getParent()) {
                // direct / real parent
                $realType = 1;
            } else if ($parentUsername == $directUsername) {
                // descendant
                $realType = 2;
            }
        }

        if($realType <= $checkType){
            return true;
        }

        return false;
    }
}