<?php
namespace System\Datalayer;

use System\Datalayers\Main;
use System\Model\UserAclResource;


class DLUserAclResource extends Main{

    // DSS
    public function findAll($start,$limit){
        $postData = array(
            "st" => $start,
            "lm" => $limit
        );
        $url = '/useraclres';
        $userAclResource = $this->curlAppsJson($url,$postData);

        return $userAclResource['data'];
    }

    public function findFirstById($id){
        $userAclResource = array();
        $postData = array(
            'id' => $id
        );
        $url = '/useraclres/'.$postData['id'];

        $userAclResourceRecords = $this->curlAppsJson($url,$postData);
        foreach ($userAclResourceRecords['data'] as $userAclResourceRecord){
            $userAclResource[] = $userAclResourceRecord;
        }

        return $userAclResource;
    }
    // END DSS
    public function getByModule($module){
        $module = UserAclResource::findByCode($module);

        return $module ;
    }

    public function get(){
        $module = UserAclResource::query()
            ->where("status = 1 ")
            ->orderBy("sidebar_order")
            ->execute();

        return $module ;
    }

    public function getMinSubaccount(){
        $module = UserAclResource::query()
            ->where(" module != 'subaccount' and module != 'user' and status = 1")
            ->orderBy("sidebar_order")
            ->execute();

        return $module ;
    }

    public function getById($data){
        $userAclResource = UserAclResource::findFirstById($data);

        return $userAclResource;
    }

    public function getByArrayId($data){
        $module = UserAclResource::query()
            ->inWhere('id', $data)
            ->orderBy("sidebar_order")
            ->execute();

        return $module ;
    }
}