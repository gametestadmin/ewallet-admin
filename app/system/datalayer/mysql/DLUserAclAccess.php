<?php
namespace System\Datalayer;

use System\Model\UserAclAccess;
use System\Model\UserAclResource;

class DLUserAclAccess{

    public function getById($user){
//        $acl = UserAclAccess::findByUser($user);
        $acl = UserAclAccess::query()
            ->where("user = :user:")
            ->bind(array("user" => $user ))
            ->orderBy("sidebar_order")
            ->execute();

        return $acl;
    }

    public function setDefaultAclByParent($acl , $user ){
        foreach ($acl as $aclrow){
            $newacl = new UserAclAccess();
            $newacl->setUser($user);
            $newacl->setModule($aclrow->getModule());
            $newacl->setController($aclrow->getController());
            $newacl->setAction($aclrow->getAction());
            $newacl->setSidebar($aclrow->getSidebar());
            $newacl->setSidebarName($aclrow->getSidebarName());
            $newacl->setSidebarOrder($aclrow->getSidebarOrder());
            $newacl->setSidebarIcon($aclrow->getSidebarIcon());
            $newacl->setStatus(0);
            if(!$newacl->save()){
                throw new \Exception($newacl->getMessages());
            }
        }

        return true ;
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