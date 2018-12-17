<?php
namespace System\Library\Security;

use System\Datalayer\DLUser;

class Agent
{
    public function checkAgentAction($parentUsername, $agentUsername, $checkType = 1){
        $dlUser = new DLUser();
//        $parent = $dlUser->getByUsername($parentUsername);
//        $child = $dlUser->getByUsername($agentUsername);

        $parent = $dlUser->findFirstByUsername($parentUsername);
        $child = $dlUser->findFirstByUsername($agentUsername);

        if($parent['tp'] == 9) {
            if($parent['id'] == $child['idp']){
                // company and real parent
                $realType = 3;
            }else{
                // company and descendant
                $realType = 4;
            }
        }else {
            $directUsername = \substr($agentUsername, 0, \strlen($parentUsername));

            $realType = false;
            if ($parent['id'] == $child['idp']) {
                // direct / real parent
                $realType = 1;
            } else if ($parentUsername == $directUsername) {
                // descendant
                $realType = 2;
            }
        }

        if($realType <= $checkType){
            return $realType;
        }

        return $realType;

//        $parent = $dlUser->getByUsername($parentUsername);
//        $child = $dlUser->getByUsername($agentUsername);
//        if($parent->getType() == 9) {
//            if($parent->getId() == $child->getParent()){
//                // company and real parent
//                $realType = 3;
//            }else{
//                // company and descendant
//                $realType = 4;
//            }
//        }else {
//            $directUsername = \substr($agentUsername, 0, \strlen($parentUsername));
//
//            $realType = false;
//            if ($parent->getId() == $child->getParent()) {
//                // direct / real parent
//                $realType = 1;
//            } else if ($parentUsername == $directUsername) {
//                // descendant
//                $realType = 2;
//            }
//        }
//
//        if($realType <= $checkType){
//            return $realType;
//        }
//
//        return $realType;
    }
}