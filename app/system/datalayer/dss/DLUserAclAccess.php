<?php
namespace System\Datalayer;

use System\Datalayers\Main;
use System\Model\UserAclAccess;

class DLUserAclAccess extends \System\Datalayers\Main{
    // DSS
    public function setAclAccess($id, $records){
        foreach ($records as $record){
            $postData = array(
                "idus" => $id,
                "mod" => $record['mod'],
                "con" => $record['con'],
                "act" => $record['act'],
                "sb" => $record['sb'],
                "sbn" => $record['sbn'],
                "sbc" => $record['sbc'],
                "sbo" => $record['sbo'],
                "st" => $record['st'],
            );
            $url = '/useraclacc/insert';
            $this->curlAppsJson($url,$postData);
        }
        return true;
    }
    // END DSS

    public function getById($user , $subaccount = false ){
        if($subaccount){
            $postData['conditions'][] = $this->curlConditions("=" , "user_id" , $user );
            $postData['conditions'][] = $this->curlConditions("=" , "status" , 1 );
            $postData['conditions'][] = $this->curlConditions("!=" , "module" , "user" );
            $postData['orders'][] = $this->curlOrders("asc" , "sidebar_order" );
        } else {
            $postData['conditions'][] = $this->curlConditions("=" , "user_id" , $user );
            $postData['conditions'][] = $this->curlConditions("=" , "status" , 1 );
            $postData['orders'][] = $this->curlOrders("asc" , "sidebar_order" );
        }
        $url = '/useraclacc/search' ;
        $result = $this->curlAppsJson( $url , $postData);

        return $result['data'] ;
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getByIdParentSubaccount($user, $subaccount = false){
        if($subaccount){
            $acl = UserAclAccess::query()
                ->where("user = :user: and module != 'subaccount'  and module != 'user' and status = 1 ")
                ->bind(array( "user" => $user ))
                ->orderBy("sidebar_order")
                ->execute();
        }else{
            $acl = UserAclAccess::query()
                ->where("user = :user: and status = 1 ")
                ->bind(array( "user" => $user ))
                ->orderBy("sidebar_order")
                ->execute();
        }

        return $acl;
    }

    public function checkParent($id , $user){
        $acl = UserAclAccess::query()
            ->where("user = :user: and id= :id: and status = 1 ")
            ->bind(array(
                "user" => $user,
                "id" => $id
                ))
            ->execute();

        return $acl ;
    }

    public function checkChild($id , $user){
        $acl = UserAclAccess::query()
            ->where("user = :user: and parent=:id: ")
            ->bind(array(
                "user" => $user,
                "id" => $id
            ))
            ->execute();

        return $acl ;
    }

    public function getByIdMinSubaccount($user){
        $acl = UserAclAccess::query()
            ->where("user = :user: and module != 'subaccount'  and module != 'user' and status = 1 ")
            ->bind(array( "user" => $user ))
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

    public function getByArrayIdParent($data , $user){
        $module = UserAclAccess::query()
            ->where("user = :user: and status = 1 ")
            ->bind(array( "user" => $user ))
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

            if($aclrow->getModule() == "user"){
                $newacl->setStatus(1);
            }else{
                $newacl->setStatus(0);
            }
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

    //update all status into 0 by providing the acl(object) for the subaccount
    public function setACLSubaccountFalse($acl){
        foreach ($acl as $aclrow){
            if($aclrow->getModule() != 'user' )
            $newacl = $aclrow->setStatus(0);
            if(!$newacl->save()){
                throw new \Exception($newacl->getMessages());
            }
        }

        return true ;
    }

//    public function setAclAccess($id, $data){
//        $aclAccess = new UserAclAccess();
//
//        $aclAccess->setUser($id);
//        $aclAccess->setModule($data->getModule());
//        $aclAccess->setController($data->getController());
//        $aclAccess->setAction($data->getAction());
//        $aclAccess->setSidebar($data->getSidebar());
//        $aclAccess->setSidebarName($data->getSidebarName());
//        $aclAccess->setSidebarIcon($data->getSidebarIcon());
//        $aclAccess->setSidebarOrder($data->getSidebarOrder());
//        $aclAccess->setStatus(1);
//
//        if(!$aclAccess->save()){
//            throw new \Exception($aclAccess->getMessages());
//        }
//        return $aclAccess;
//    }

    public function setAclAccessWithStatus($id, $data , $status){
        $aclAccess = new UserAclAccess();
        $aclAccess->setUser($id);
        $aclAccess->setParent($data->getId());
        $aclAccess->setModule($data->getModule());
        $aclAccess->setController($data->getController());
        $aclAccess->setAction($data->getAction());
        $aclAccess->setSidebar($data->getSidebar());
        $aclAccess->setSidebarName($data->getSidebarName());
        $aclAccess->setSidebarIcon($data->getSidebarIcon());
        $aclAccess->setSidebarOrder($data->getSidebarOrder());
        $aclAccess->setStatus($status);

        if(!$aclAccess->save()){
            throw new \Exception($aclAccess->getMessages());
        }
        return $aclAccess;
    }

}
