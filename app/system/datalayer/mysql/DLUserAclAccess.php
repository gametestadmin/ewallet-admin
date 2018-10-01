<?php
namespace System\Datalayer;

use System\Model\UserAclAccess;
use System\Model\UserAclResource;

class DLUserAclAccess{

    public function getById($user){
        $acl = UserAclAccess::findByUser($user);

        return $acl;
    }

    public function setAclAccess($id, $data){
        $aclAccess = new UserAclAccess();

        $aclAccess->setUser($id);
        $aclAccess->setModule($data->getModule());
        $aclAccess->setController($data->getController());
        $aclAccess->setAction($data->getAction());
        $aclAccess->setSidebar($data->getSidebar());
        $aclAccess->setSidebarName($data->getSidebarName());
        $aclAccess->setSidebarIcon($data->getSidebarIcon());
        $aclAccess->setStatus(1);

        if(!$aclAccess->save()){
            throw new \Exception($aclAccess->getMessages());
        }
    }
}