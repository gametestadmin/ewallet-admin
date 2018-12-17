<?php

namespace System\Datalayer;

use System\Library\Security\User as SecurityUser ;
use System\Model\User;

class DLUser extends \System\Datalayers\Main
{
    public function getFirstByNickname($user)
    {
        $postData = array(
            'nickname' => $user ,
            'status' => 1 ,
        );
        $url = '/user/find';
        $result = $this->curlAppsJson( $url , $postData);

        if(isset($result->user) && !empty($result->user) && isset($result->user->{0})){
            return $result->user->{0};
        }

        return false;
    }

    public function setUserPassword($user, $password)
    {
        $postData = array(
            'ps' => $password ,
        );
        $url = '/user/'.$user.'/update';
        $result = $this->curlAppsJson( $url , $postData);

        return $result;
    }


    public function getSubaccountById($user)
    {
        $postData = array(
            'type' => 10 ,
            'parent' => $user ,
        );
        $url = '/user/find';
        $result = $this->curlAppsJson( $url , $postData );

        return $result;
    }


    public function getById($user)
    {
        $postData = array(
            'id' => $user ,
            'status' => 1 ,
        );
        $url = '/user/find';
        $result = $this->curlAppsJson( $url , $postData);

        if(isset($result->user) && !empty($result->user) && isset($result->user->{0})){
            return $result->user->{0};
        }

        return false;
    }

    // DSS
    public function findByParent($parent)
    {
        $postData = array(
            "parent" => $parent,
            "type !=" => 10
        );

        $url = '/user/find';
        $user = $this->curlAppsJson($url,$postData);

        return $user['user'];
    }

    public function findFirstById($id)
    {
        $userData = false;

        $postData = array(
            "id" => $id
        );
        $url = '/user/'.$id;
        $users = $this->curlAppsJson($url,$postData);

        foreach ($users['user'] as $user){
            $userData = $user;
        }

        return $userData;
    }

    public function findFirstByUsername($username)
    {
        $userData = false;

        $postData = array(
            "username" => $username
        );

        $url = '/user/find';
        $users = $this->curlAppsJson($url,$postData);

        foreach ($users['user'] as $user){
            $userData = $user;
        }

        return $userData;
    }

    public function findFirstByNickname($nickname)
    {
        $userData = false;

        $postData = array(
            "nickname" => $nickname
        );

        $url = '/user/find';
        $users = $this->curlAppsJson($url,$postData);

        foreach ($users['user'] as $user){
            $userData = $user;
        }

        return $userData;
    }

    public function filterInputAgentData($data){
        $filterData = array();
        $securityLibrary = new SecurityUser();

        if(isset($data["id"])) $filterData['id'] = \intval($data['id']);
        if(isset($data["timezone"])) $filterData['tz'] = \intval($data['timezone']);
        if(isset($data["code"])) $data['code'] = \implode($data['code']);

        if(isset($data['agent'])){
            $type = \intval($data['agent']->tp) - 1;
            $filterData['tp'] = $type;
            $filterData['idp'] = \intval($data['agent']->id);
        }
        if(isset($data["agent_code"])){
            $data['code'] = \filter_var(\strip_tags(\addslashes($data['agent_code'])), FILTER_SANITIZE_STRING);
        }

        if(isset($data["code"])) {
            $filterData['cd'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
            $filterData['un'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
            $filterData['nn'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
        }
        if(isset($data["password"])) $filterData['ps'] = \filter_var(\strip_tags(\addslashes($data['password'])), FILTER_SANITIZE_STRING);
        if(isset($data["username"])) $filterData['un'] = \filter_var(\strip_tags(\addslashes($data['username'])), FILTER_SANITIZE_STRING);
        if(isset($data["nickname"])) $filterData['nn'] = \filter_var(\strip_tags(\addslashes($data['nickname'])), FILTER_SANITIZE_STRING);

        if(isset($filterData['ps'])) \base64_encode($securityLibrary->enc_str($filterData['ps']));

        if(isset($data['reset_nickname'])) $filterData['rn'] = \intval($data['reset_nickname']);
        if(isset($data['reset_password'])) $filterData['rp'] = \intval($data['reset_password']);
        if(isset($data['status'])) $filterData['st'] = \intval($data['status']);
        if(isset($data['parent_status'])) $filterData['pst'] = \intval($data['parent_status']);

        if(isset($data["currency"])) $filterData['idcu'] = \intval($data['currency']);
        if(isset($data["ip"])) $filterData['ip'] = \filter_var(\strip_tags(\addslashes($data['ip'])), FILTER_SANITIZE_STRING);

        return $filterData;
    }

    public function validateEditAgentData($data){
        if($data['id'] == ""){
            throw new \Exception('undefined_agent');
        } elseif($data['tz'] == ""){
            throw new \Exception('timezone_empty');
        }

        return true;
    }

    public function set($postData){
        $url = '/user/'.$postData['id'].'/update';
        $this->curlAppsJson($url,$postData);

        return true;
    }

    public function create($postData){
        $url = '/user/insert';
        $user = $this->curlAppsJson($url, $postData);

        return $user;
    }

    public function setAgentStatus($id, $status){
        $this->setUserStatus($id, $status);

        return true;
    }

    protected function setUserStatus($id, $status){
        $postData = array(
            "id" => $id,
            "st" => $status
        );
        $this->set($postData);

        $user = $this->findFirstById($id);
        $this->setChildParentStatus($id, $postData['st'], $user['pst']);

        return true;
    }

    protected function setChildParentStatus($parentId, $parentStatus, $grandParentStatus){
        $childParentStatus = 1;
        if($grandParentStatus == 0 || $parentStatus == 0){
            $childParentStatus = 0;
        }else if($grandParentStatus == 2 || $parentStatus == 2){
            $childParentStatus = 2;
        }

        //get childs
        $childs = $this->findByParent($parentId);

        foreach ($childs as $child){
            $postData = array(
                "id" => $child['id'],
                "pst" => $childParentStatus
            );
            $this->set($postData);

            //change all childs parent status
            $this->setChildParentStatus($child['id'], $child['ust'], $childParentStatus);
        }
        return true;

    }
    // END DSS


}
