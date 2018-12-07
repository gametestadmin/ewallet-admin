<?php
namespace System\Datalayer;


use System\Model\UserAuth;

class DLUserAuth{
    public function getByUser($user){
        $userAuth = UserAuth::findByUser($user);

        return $userAuth;
    }

    public function createAgentAuth($user){
        $newUserAuth = new UserAuth();

        $app_id = md5("app_id".strtotime("now").$user->getId().$user->getUsername());
        $app_secret =  md5("app_secret".$user->getId().$user->getUsername().strtotime("now"));
        $date = "3000-01-01 00:00:00";

        $newUserAuth->setUser($user->getId());
        $newUserAuth->setAppId($app_id);
        $newUserAuth->setAppSecret($app_secret);
        $newUserAuth->setValidUntil($date);
        $newUserAuth->setStatus(1);
        $newUserAuth->save();

        return $newUserAuth;
    }
}