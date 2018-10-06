<?php
namespace System\Datalayer;

use System\Model\UserAclAccess;
use System\Model\UserAclResource;

class DLUserAclAccess{

    public function getById($user){
        $acl = UserAclAccess::query()
            ->where("user = :user:")
            ->bind(array("user" => $user ))
            ->orderBy("sidebar_order")
            ->execute();

        return $acl;
    }

    public function getByIdMinSubaccount($user){
        $acl = UserAclAccess::query()
            ->where("user = :user: and module != 'subaccount' ")
            ->bind(array("user" => $user ))
            ->orderBy("sidebar_order")
            ->execute();

        return $acl;
    }

    public function getByArrayId($data){
        $module = UserAclAccess::query()
            ->inWhere('id', $data)
            ->orderBy("sidebar_order")
            ->execute();

        return $module ;
    }

    //create new aclAccess by providing the acl(object) from aclResource , default 0
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

    //create new aclAccess by providing the acl(object) from aclResource , default 1
    public function setTrueAclByParent($acl , $user ){
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
            $newacl->setStatus(1);
            if(!$newacl->save()){
                throw new \Exception($newacl->getMessages());
            }
        }
        return true ;
    }

    //update all status into 1 by providing the acl(object)
    public function setAClTrueByList($acl){
        foreach ($acl as $aclrow){
            $newacl = $aclrow->setStatus(1);
            if(!$newacl->save()){
                throw new \Exception($newacl->getMessages());
            }
        }

        return true ;
    }

    //update all status into 0 by providing the acl(object)
    public function setACLFalseByUser($acl){
        foreach ($acl as $aclrow){
            $newacl = $aclrow->setStatus(0);
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