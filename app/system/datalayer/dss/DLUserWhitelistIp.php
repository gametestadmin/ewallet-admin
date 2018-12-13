<?php
namespace System\Datalayer;

use System\Model\UserWhitelistIp;

class DLUserWhitelistIp extends \System\Datalayers\Main
{
    public function getByUser($user){
        $postData = array(
            'user_id' => $user,
            'status' => 1
        );
        $url = '/userwlip/find';
        $result = $this->curlAppsJson( $url , $postData);

        return $result->data ;
    }
    public function getByIp($ip){
        $postData = array(
            'ip' => $ip,
            'status' => 1
        );
        $url = '/userwlip/find';
        $result = $this->curlAppsJson( $url , $postData);

        return $result->data ;
    }

    public function create($user,$ip){
        $postData = array(
            'idus' => $user ,
            'ip' => $ip ,
            'st' => 1
        );
        $url = '/userwlip/insert';
        $result = $this->curlAppsJson( $url , $postData);

        if( $result->ec == 0) {
            return true;
        }
        return false ;
    }

    public function delete($id){
        $postData = array(
            'id' => $id
        );
        $url = '/userwlip/'.$id.'/delete';
        $result = $this->curlAppsJson( $url , $postData);

        if( $result->ec == 0) {
            return true;
        }
        return false ;
    }







//////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function getById($id){
        $userWhitelistIp = UserWhitelistIp::findFirstById($id);

        return $userWhitelistIp;
    }

    public function uniqueCheck($data){
        if(isset($data['ip_id'])){
            $userWhitelistIp = UserWhitelistIp::findFirst(
            array(
                "conditions" => "id != :id: AND user = :user: AND ip = :ip:",
                "bind" => array(
                    "id" => $data['ip_id'],
                    "user" => $data['user'],
                    "ip" => $data['ip'],
                ),
            )
        );
        }else {
            $userWhitelistIp = UserWhitelistIp::findFirst(
                array(
                    "conditions" => "user = :user: AND ip = :ip:",
                    "bind" => array(
                        "user" => $data['user'],
                        "ip" => $data['ip'],
                    ),
                )
            );
        }
        return $userWhitelistIp;
    }

    public function filterInput($data){
        if(isset($data["user"])) $data['user'] = \intval($data['user']);
        if(isset($data["ip"])) $data['ip'] = \filter_var(\strip_tags(\addslashes($data['ip'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function validateAdd($data){
        if($this->uniqueCheck($data)){
            throw new \Exception('ip_exist');
        }elseif(empty($data['ip'])){
            throw new \Exception('ip_empty');
        }

        return true;
    }

    public function validateEdit($data){
        if($this->uniqueCheck($data)){
            throw new \Exception('ip_exist');
        }elseif(empty($data['ip'])){
            throw new \Exception('ip_empty');
        }

        return true;
    }



    public function set($data){
        $userWhitelistIp = $this->getById($data['ip_id']);

        $user = new DLUser();
        $userData = $user->getById($data['user']);

        if(isset($data["game"]))$userWhitelistIp->setGame($userData->getId());
        if(isset($data["ip"]))$userWhitelistIp->setIp($data['ip']);

        if(!$userWhitelistIp->save()){
            throw new \Exception('error_edit_user_whitelist_ip');
        }

        return true;
    }
}