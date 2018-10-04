<?php
namespace System\Datalayer;

use System\Model\UserAclResource;


class DLUserAclResource{

    public function getByModule($module){
        $module = UserAclResource::findByCode($module);

        return $module;
    }








}