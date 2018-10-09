<?php
namespace System\Datalayer;

use System\Model\UserAclResource;


class DLUserAclResource{

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