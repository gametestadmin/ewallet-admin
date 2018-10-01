<?php
namespace System\Datalayer;

use System\Model\User;

class DLUser{

    public function createSubaccount($data){
        $user = new User();
        $user->setUsername($data['username']);
        $user->setPassword($data['password']);
        $user->setNickname($data['username']);
        $user->setParent($data['parent']);
        $user->setTimezone($data['timezone']);
        $user->setType(10);
        $user->setCode($data['username']);
        $user->setResetPassword(1);
        $user->setResetNickname(1);

        if(!$user->save()){
            throw new \Exception($user->getMessages());
        }
        return $user ;
    }

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
        if(!$user->save()){
            throw new \Exception($user->getMessages());
        }
        return $user->save();
    }

    public function setResetPassword($user , $password){
        $user->setPassword($password);
        $user->setResetPassword(1);
        if(!$user->save()){
            throw new \Exception($user->getMessages());
        }
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
        if(!$user->save()){
            throw new \Exception($user->getMessages());
        }
        return $user->save();
    }




}