<?php
namespace System\Library\User;

use \System\Datalayer\DLUserAclResource ;
use \System\Datalayer\DLUserAclAccess ;
use System\Datalayer\DLUserWhitelistIp;

class General
{
    public function getACL ($user , $subaccount = false){
        $acl = new DLUserAclAccess();
        $aclList = $acl->getById($user , $subaccount);
        return $aclList;
    }

    public function getSubaccountACLParent($user, $subaccount = false){
        $acl = new DLUserAclAccess();
        $aclList = $acl->getByIdParentSubaccount($user, $subaccount);
        return $aclList;
    }


    public function getCompanyACLbyArrayId($array){
        $acl = new DLUserAclResource();
        $aclList = $acl->getByArrayId($array);

        return $aclList;
    }

    public function getAccessACLbyArrayId($array){
        $acl = new DLUserAclAccess();
        $aclList = $acl->getByArrayId($array);

        return $aclList;
    }

    public function setSubaccountDefault($acl , $id){
        foreach ($acl as $aclrow){
            $status = 0;
            if($aclrow->getModule() == 'user' ) $status = 1;
            if($aclrow->getModule() != 'subaccount'){
                $acl = new DLUserAclAccess();
                $acl->setAclAccessWithStatus($id , $aclrow , $status);
            }
        }
    }

    public function editSubaccountACL($aclList , $parent , $child){
        $acl = new DLUserAclAccess();
        $aclParent = $acl->getByArrayIdParent($aclList , $parent);


        if(count($aclList) != count($aclParent)){
            throw new \Exception('subaccount_cannot_inherit_acl_from_parent');
        } else {
            foreach ($aclParent as $key => $value){
                $resultchild = $acl->checkChild($value->getId() , $child) ;
                if($resultchild){
                    //update into children ACL
                    $acl->setAClTrueByList($resultchild);

                } else {
                    //insert into children ACL
                    $acl->setTrueAclByParent($resultchild , $child);
                }

            }
        }

        return true ;
    }

    // MYSQL FORMAT
//    public function filterACLlist($aclObject){
//        $aclList = array();
//        foreach ($aclObject as $key){
//            var_dump($key);
//            if(!is_null($key->module) && !is_null($key->controller) && !is_null($key->action))
//            $aclList[$key->module][$key->controller][$key->action] = $key->status ;
//        }
//        return $aclList;
//    }

    // DSS FORMAT
    public function filterACLlist($aclObject){
        $aclList = array();
        foreach ($aclObject as $key){
            if(!is_null($key->mod) && !is_null($key->con) && !is_null($key->act))
                $aclList[$key->mod][$key->con][$key->act] = $key->st ;
        }
        return $aclList;
    }

    // MYSQL FORMAT
//    public function filterACLlistSubaccount($aclObject){
//        $aclList = array();
//        foreach ($aclObject as $key){
//            if(!isset($aclList[$key->getModule()])) {
//                $aclList[$key->getModule()] = array();
//                $aclList[$key->getModule()]["child"] = array();
//            }
//            //get module level list
//            if(is_null($key->getController()) && is_null($key->getAction())) {
//                $aclList[$key->getModule()]["name"] = $key->getSidebarName();
//                $aclList[$key->getModule()]["id"] = $key->getId();
//            }
//            //get controller level list
//            if(!is_null($key->getController()) && $key->getAction() == null ) {
//                if(!isset($aclList[$key->getModule()]["child"][$key->getController()])) {
//                    $controllerAcl = array();
//                    $controllerAcl["child"] = array();
//                }else{
//                    $controllerAcl = $aclList[$key->getModule()]["child"][$key->getController()];
//                }
//
//                if($key->getAction() == null ) {
//                    $controllerAcl["name"] = $key->getSidebarName();
//                    $controllerAcl["id"] = $key->getId();
//                }
//
//                $aclList[$key->getModule()]["child"][$key->getController()] = $controllerAcl;
//            }
//            //get child of the controller
//            if(!is_null($key->getController()) && !is_null($key->getAction()) ) {
//                if(!isset($aclList[$key->getModule()]["child"][$key->getController()])) {
//                    $controllerAcl = array();
//                    $controllerAcl["child"] = array();
//                }else{
//                    $controllerAcl = $aclList[$key->getModule()]["child"][$key->getController()];
//                }
//
//                $actionAcl = array();
//                $actionAcl["name"] = $key->getSidebarName();
//                $actionAcl["id"] = $key->getId();
//                $controllerAcl["child"][$key->getAction()] = $actionAcl;
//
//                $aclList[$key->getModule()]["child"][$key->getController()] = $controllerAcl;
//            }
//        }
//        return $aclList;
//    }

    // DSS FORMAT
    public function filterACLlistSubaccount($aclObject){
        $aclList = array();
        foreach ($aclObject as $key){
            if(!isset($aclList[$key->getModule()])) {
                $aclList[$key->getModule()] = array();
                $aclList[$key->getModule()]["child"] = array();
            }
            //get module level list
            if(is_null($key->getController()) && is_null($key->getAction())) {
                $aclList[$key->getModule()]["name"] = $key->getSidebarName();
                $aclList[$key->getModule()]["id"] = $key->getId();
            }
            //get controller level list
            if(!is_null($key->getController()) && $key->getAction() == null ) {
                if(!isset($aclList[$key->getModule()]["child"][$key->getController()])) {
                    $controllerAcl = array();
                    $controllerAcl["child"] = array();
                }else{
                    $controllerAcl = $aclList[$key->getModule()]["child"][$key->getController()];
                }

                if($key->getAction() == null ) {
                    $controllerAcl["name"] = $key->getSidebarName();
                    $controllerAcl["id"] = $key->getId();
                }

                $aclList[$key->getModule()]["child"][$key->getController()] = $controllerAcl;
            }
            //get child of the controller
            if(!is_null($key->getController()) && !is_null($key->getAction()) ) {
                if(!isset($aclList[$key->getModule()]["child"][$key->getController()])) {
                    $controllerAcl = array();
                    $controllerAcl["child"] = array();
                }else{
                    $controllerAcl = $aclList[$key->getModule()]["child"][$key->getController()];
                }

                $actionAcl = array();
                $actionAcl["name"] = $key->getSidebarName();
                $actionAcl["id"] = $key->getId();
                $controllerAcl["child"][$key->getAction()] = $actionAcl;

                $aclList[$key->getModule()]["child"][$key->getController()] = $controllerAcl;
            }
        }
        return $aclList;
    }

    // MYSQL FORMAT
//    public function filterACLlistwithId($aclObject){
//        $aclList = array();
//        foreach ($aclObject as $key){
//            $aclList[$key->module][$key->controller][$key->action]['id'] = $key->id ;
//            $aclList[$key->module][$key->controller][$key->action]['parent'] = $key->parent ;
//            $aclList[$key->module][$key->controller][$key->action]['status'] = $key->status ;
//        }
//        return $aclList;
//    }

    // DSS FORMAT
    public function filterACLlistwithId($aclObject){
        $aclList = array();
        foreach ($aclObject as $key){
            $aclList[$key->mod][$key->con][$key->act]['id'] = $key->id ;
            $aclList[$key->mod][$key->con][$key->act]['parent'] = $key->parent ;
            $aclList[$key->mod][$key->con][$key->act]['status'] = $key->status ;
        }
        return $aclList;
    }


    public function filterACLsubaccountParentId($aclObject){

        $aclList = array();
        foreach ($aclObject as $key){
            $aclList[$key->parent] = $key->status ;
        }

        return $aclList;
    }

    // MYSQL FORMAT
    /*
    public function getSidebar($aclObject){
        $aclList = array();
        foreach ($aclObject as $key){
            if($key->sidebar == 1 && $key->status == 1){
                if(!isset($aclList[$key->getModule()])) {
                    $aclList[$key->getModule()] = array();
                    $aclList[$key->getModule()]["child"] = array();
                }
                //get module level list
                if(is_null($key->getController()) && is_null($key->getAction())) {
                    $aclList[$key->getModule()]["name"] = $key->getSidebarName();
                    if (!is_null($key->getSidebarIcon()) && !empty($key->getSidebarIcon())) $aclList[$key->getModule()]["icon"] = $key->getSidebarIcon();
                }
                //get controller level list
                if(!is_null($key->getController()) && $key->getAction() == null ) {
                    if(!isset($aclList[$key->getModule()]["child"][$key->getController()])) {
                        $controllerAcl = array();
                        $controllerAcl["child"] = array();
                    }else{
                        $controllerAcl = $aclList[$key->getModule()]["child"][$key->getController()];
                    }

                    if($key->getAction() == null ) {
                        $controllerAcl["name"] = $key->getSidebarName();
                        if (!is_null($key->getSidebarIcon()) && !empty($key->getSidebarIcon())) $controllerAcl["icon"] = $key->getSidebarIcon();
                    }

                    $aclList[$key->getModule()]["child"][$key->getController()] = $controllerAcl;
                }
                //get child of the controller
                if(!is_null($key->getController()) && !is_null($key->getAction()) ) {
                    if(!isset($aclList[$key->getModule()]["child"][$key->getController()])) {
                        $controllerAcl = array();
                        $controllerAcl["child"] = array();
                    }else{
                        $controllerAcl = $aclList[$key->getModule()]["child"][$key->getController()];
                    }

                    //TODO :: use if action only need to have name
//                    $controllerAcl["child"][$key->getAction()] = $key->getSidebarName();
                    //TODO :: use if action need to have icon
                    $actionAcl = array();
                    $actionAcl["name"] = $key->getSidebarName();
                    $actionAcl["icon"] = $key->getSidebarIcon();
                    $controllerAcl["child"][$key->getAction()] = $actionAcl;

                    $aclList[$key->getModule()]["child"][$key->getController()] = $controllerAcl;
                }
            }
        }
        return $aclList;
    }
    */


    // DSS FORMAT
    public function getSidebar($aclObject){
        $aclList = array();
        foreach ($aclObject as $key){
            if($key->sb == 1 && $key->st == 1){
                if(!isset($aclList[$key->mod])) {
                    $aclList[$key->mod] = array();
                    $aclList[$key->mod]["child"] = array();
                }
                //get module level list
                if(is_null($key->con) && is_null($key->act)) {
                    $aclList[$key->mod]["name"] = $key->sbn;
                    if (!is_null($key->sbc) && !empty($key->sbc)) $aclList[$key->mod]["icon"] = $key->sbc;
                }
                //get controller level list
                if(!is_null($key->con) && $key->act == null ) {
                    if(!isset($aclList[$key->mod]["child"][$key->con])) {
                        $controllerAcl = array();
                        $controllerAcl["child"] = array();
                    }else{
                        $controllerAcl = $aclList[$key->mod]["child"][$key->con];
                    }

                    if($key->act == null ) {
                        $controllerAcl["name"] = $key->sbn;
                        if (!is_null($key->sbc) && !empty($key->sbc)) $controllerAcl["icon"] = $key->sbc;
                    }

                    $aclList[$key->mod]["child"][$key->con] = $controllerAcl;
                }
                //get child of the controller
                if(!is_null($key->con) && !is_null($key->act) ) {
                    if(!isset($aclList[$key->mod]["child"][$key->con])) {
                        $controllerAcl = array();
                        $controllerAcl["child"] = array();
                    }else{
                        $controllerAcl = $aclList[$key->mod]["child"][$key->con];
                    }

                    //TODO :: use if action only need to have name
//                    $controllerAcl["child"][$key->act] = $key->sbn;
                    //TODO :: use if action need to have icon
                    $actionAcl = array();
                    $actionAcl["name"] = $key->sbn;
                    $actionAcl["icon"] = $key->sbc;
                    $controllerAcl["child"][$key->act] = $actionAcl;

                    $aclList[$key->mod]["child"][$key->con] = $controllerAcl;
                }
            }
        }
        return $aclList;
    }

    public function checkIP($id , $ip){
        $ipallowed = true ;
        $DLWhitelistIp = new DLUserWhitelistIp() ;
        $whitelistIP = $DLWhitelistIp->getByUser($id) ;
        foreach ( $whitelistIP as $key => $value ){
            if($value->ip == '*'){
                $ipallowed = true ;
                break ;
            } else {
                $wlIp = explode(".", $value->ip);
                $userIp = explode(".", $ip);

                foreach ($userIp as $key => $value ) {
                    if( $wlIp[$key] == '*' || $wlIp[$key] == $userIp[$key] ){
                        $ipallowed = true ;
                    } else {
                        $ipallowed = false ;
                        break ;
                    }
                }
                if($ipallowed == true ) break ;

            }
        }

        return $ipallowed ;
    }



}
