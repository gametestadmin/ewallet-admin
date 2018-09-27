<?php
namespace System\Datalayer;

use System\Model\User;

class DLUser{


    public function getByUsername($user){
        $user = User::findFirstByUsername($user);
        return $user;
    }

    public function getByNickname($user){
        $user = User::findFirstByNickname($user);
        return $user;
    }

    public function getById($user){
        $user = User::findFirstById($user);

        return $user;
    }

    public function getChildById($user){
        $user = User::find(
            array(
                "conditions" => "parent = :user:",
                "bind" => array(
                    "user" => $user,
                )
            )
        );

        return $user;
    }

    public function setUserPassword($user , $password){
        $user->setPassword($password);
        $user->setResetPassword(0);

        return $user->save();
    }

    public function setResetPassword($user , $password){
        $user->setPassword($password);
        $user->setResetPassword(1);

        return $user->save();

    }

    public function checkNickname($newNickname){
        $nickname = User::findFirstByNickname($newNickname);
        $username = User::findFirstByUsername($newNickname);

        $check = false ;
        if($nickname || $username) {
            $check = true ;
        }

        return $check ;
    }

    public function setNickname($user , $newNickname){
        $user->setNickname($newNickname);
        $user->setResetNickname(0);

        return $user->save();
    }




}