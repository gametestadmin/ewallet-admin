<?php
namespace System\Datalayer;

use System\Model\UserAclAccess;

class DLUserAclAccess{

    public function getById($user){
        $acl = UserAclAccess::findByUser($user);

        return $acl;
    }





}