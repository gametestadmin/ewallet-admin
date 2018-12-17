<?php
namespace System\Datalayer;

use System\Datalayers\Main;
use System\Model\UserWhitelistIp;


class DLUserWhitelistIp extends Main{

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

    // DSS
    public function findByUser($user)
    {
        $postData = array(
            "user_id" => $user,
            "status" => 1
        );

        $url = '/userwlip/find';
        $userWhitelistIp = $this->curlAppsJson($url, $postData);

        return $userWhitelistIp['data'];
    }
    public function findFirstByUserAndIp($user,$ip){
        $postData = array(
            "user_id" => $user,
            "ip" => $ip,
        );

        $url = '/userwlip/find';
        $userWhitelistIpRecords = $this->curlAppsJson($url,$postData);

        $userWhitelistIp = false;
        foreach ($userWhitelistIpRecords['data'] as $userWhitelistIpRecord){
            $userWhitelistIp = $userWhitelistIpRecord;
        }
        return $userWhitelistIp;
    }

    public function filterData($data){
        $filterData = array();

        if(isset($data["user"])) $filterData['idus'] = \intval($data['user']);
        if(isset($data["ip"])) $filterData['ip'] = \filter_var(\strip_tags(\addslashes($data['ip'])), FILTER_SANITIZE_STRING);

        return $filterData;
    }

    public function validateCreate($data){
        if($this->findFirstByUserAndIp($data['idus'],$data['ip'])){
            throw new \Exception('ip_exist');
        }elseif(empty($data['ip'])){
            throw new \Exception('ip_empty');
        }

        return true;
    }

    public function createUserWhitelistIp($user,$ip){
        $postData = array(
            "idus" => $user,
            "ip" => $ip,
            "st" => 1
        );

        $url = '/userwlip/insert';
        $userWhitelistIp = $this->curlAppsJson($url,$postData);

        return $userWhitelistIp;
    }
    public function deleteUserWhitelistIp($id){
        $postData = array(
            "id" => $id,
        );

        $url = '/userwlip/'.$postData['id'].'/delete';
        $this->curlAppsJson($url,$postData);

        return true;
    }

    // END DSS
}
