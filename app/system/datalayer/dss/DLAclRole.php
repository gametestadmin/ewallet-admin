<?php
namespace System\Datalayer;

use System\Datalayers\Main;
use System\Model\AclRole;

class DLAclRole extends Main{
    // DSS
    public function findByType($type){
        $postData = array(
            "type" => $type
        );
        $url = '/aclrole/find';
        $aclRole = $this->curlAppsJson($url,$postData);

        return $aclRole['data'];
    }
    // END DSS
    public function findAll($type){
        $postData = array(
            "type" => $type
        );
        $url = '/aclrole/find';
        $aclRole = $this->curlAppsJson($url,$postData);

        return $aclRole['data'];
    }

    public function create($postData){
//        var_dump($postData);
//        die;
        $url = '/aclrole/insert';
        $aclRole = $this->curlAppsJson($url,$postData);

        return $aclRole;
    }

    public function getByType($type){
        $aclResource = AclRole::findByType($type);

        return $aclResource;
    }
}