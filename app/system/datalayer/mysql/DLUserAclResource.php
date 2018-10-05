<?php
namespace System\Datalayer;

use System\Model\UserAclResource;


class DLUserAclResource{

    public function getByModule($module){
        $module = UserAclResource::findByCode($module);

        return $module ;
    }

    public function get(){
//        $module = UserAclResource::find();
        $module = UserAclResource::query()
            ->orderBy("sidebar_order")
            ->execute();

        return $module ;
    }







}