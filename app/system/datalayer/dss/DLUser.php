<?php
namespace System\Datalayer;


class DLUser{


    public function getByUsername($user){
        $user = User::findFirstByUsername($user);



        return $user;
    }

    public function getById($user){
        $user = User::findFirstById($user);

        return $user;
    }





}