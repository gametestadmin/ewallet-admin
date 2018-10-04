<?php
namespace System\Datalayer;

use System\Model\UserAclAccess;

class DLUserAclAccess{

    public function getById($user){
        $acl = UserAclAccess::findByUser($user);
        return $acl;
    }

    public function setDefaultAclByParent($acl , $parent){
        foreach ($acl as $aclrow ){
            $acl = new UserAclAccess();
            $acl->setUser($parent);
            $acl->setModule($aclrow->getModule());
            $acl->setController($aclrow->getController());
            $acl->setAction($aclrow->getAction());
            $acl->setSidebar($aclrow->getSidebar());
            $acl->setSidebarName($aclrow->getSidebarName());
            $acl->setSidebarIcon($aclrow->getSidebarIcon());
            $acl->setStatus(0);
            if(!$acl->save()){
                throw new \Exception($acl->getMessages());
            }
        }
        return true ;
    }

}