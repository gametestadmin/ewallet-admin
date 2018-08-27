<?php
namespace System\Datalayer;

use System\Model\User;

class DLUser{


    public function getByUsername($user){
        $user = User::findFirstByUsername($user);
        return $user;
    }

    public function getById($user){
        $user = User::findFirstById($user);

        return $user;
    }

    public function setUserPassword($user , $password){
        $user->setPassword($password);

        return $user->save();
    }





}