<?php
namespace System\Library\User;

use \System\Datalayer\DLUserAclResource ;
use \System\Datalayer\DLUserAclAccess ;

class General
{
    public function getACL ($user){
        $acl = new DLUserAclAccess();
        $aclList = $acl->getById($user);
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

    public function filterACLlist($aclObject){
        $aclList = array();
        foreach ($aclObject as $key){
            if(!is_null($key->module) && !is_null($key->controller) && !is_null($key->action))
            $aclList[$key->module][$key->controller][$key->action] = $key->status ;
        }

        return $aclList;
    }

    public function filterACLlistwithId($aclObject){
        $aclList = array();
        foreach ($aclObject as $key){
            $aclList[$key->module][$key->controller][$key->action]['id'] = $key->id ;
            $aclList[$key->module][$key->controller][$key->action]['status'] = $key->status ;
        }

        return $aclList;
    }

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

                    //TODO :: use if action need to have icon
                    $actionAcl = array();
                    $actionAcl["name"] = $key->getSidebarName();
                    $actionAcl["icon"] = $key->getSidebarIcon();
                    $controllerAcl["child"][$key->getAction()] = $actionAcl;

                    //TODO :: use if action only need to have name
//                    $controllerAcl["child"][$key->getAction()] = $key->getSidebarName();;


                    $aclList[$key->getModule()]["child"][$key->getController()] = $controllerAcl;
                }
            }
        }

        return $aclList;
    }



}
