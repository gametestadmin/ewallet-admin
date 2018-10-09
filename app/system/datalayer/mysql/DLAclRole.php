<?php
namespace System\Datalayer;

use System\Model\AclRole;

class DLAclRole{

    public function getByType($type){
        $aclResource = AclRole::findByType($type);

        return $aclResource;
    }
}