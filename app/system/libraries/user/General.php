<?php
namespace System\Library\User;

use \System\Datalayer\DLUserAclResource ;
use \System\Datalayer\DLUserAclAccess ;



class General
{

    public function check()
    {
        return "this is inside user library" ;
    }

    public function changePassword()
    {


        return null ;
    }

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
//            $acl['module'] = $key->module ;
//            $acl['acl'] = $key->module."/".$key->controller."/".$key->action ;
//            $acl['status'] = $key->status;
//            $aclList[] = $acl;
        }

//        echo "something here<pre>";
//        var_dump($aclList);
//        die;

        return $aclList;
    }

    public function getSidebar($aclObject){
        $aclList = array();
        foreach ($aclObject as $key){
            if($key->sidebar == 1){
                $aclList[$key->module][$key->controller][$key->action] = $key->sidebar ;
            }
        }

        return $aclList;
    }

}
