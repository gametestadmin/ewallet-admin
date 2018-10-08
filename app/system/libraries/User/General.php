<?php
namespace System\Library\User;

use \System\Datalayer\DLUserAclResource ;
use \System\Datalayer\DLUserAclAccess ;

class General
{

    public function getACL($user)
    {
        $acl = new DLUserAclAccess();
        $aclList = $acl->getById($user);

        return $aclList;
    }

    public function getCompanyACL()
    {
        $acl = new DLUserAclResource();
        $aclList = $acl->get();

        return $aclList;
    }

    public function filterACLlist($aclObject){
        $aclList = array();
        foreach ($aclObject as $key){
            $aclList[$key->module][$key->controller][$key->action] = $key->status ;
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
//                    $actionAcl = array();
//                    $actionAcl["name"] = $key->getSidebarName();
//                    $controllerAcl["child"][$key->getAction()] = $actionAcl;

                    $controllerAcl["child"][$key->getAction()] = $key->getSidebarName();;
                    $aclList[$key->getModule()]["child"][$key->getController()] = $controllerAcl;
                }
            }
        }

        return $aclList;
    }

}
