<?php
namespace System\Datalayer;

use System\Library\Security\User as SecurityUser ;
use System\Model\User;

class DLUser
{
    public function getCompany()
    {
        $company = User::findByType(9);

        return $company;
    }

    public function createSubaccount($data)
    {
        $user = new User();
        $user->setUsername($data['username']);
        $user->setPassword($data['password']);
        $user->setNickname($data['username']);
        $user->setParent($data['parent']);
        $user->setTimezone($data['timezone']);
        $user->setType(10);
        $user->setCode($data['username']);
        $user->setResetPassword(1);
        $user->setResetNickname(1);

        if (!$user->save()) {
            throw new \Exception($user->getMessages());
        }
        return $user;
    }

    public function getByUsername($user)
    {
        $user = User::findFirstByUsername($user);
        return $user;
    }

    public function getByNickname($user)
    {
        $user = User::findFirstByNickname($user);
        return $user;
    }

    public function getById($user)
    {
        $user = User::findFirstById($user);
        return $user;
    }

    public function getChildById($user)
    {
        $user = User::find(
            array(
                "conditions" => "parent = :user:",
                "bind" => array(
                    "user" => $user,
                )
            )
        );
        return $user;
    }

    public function getSubaccountById($user)
    {
        $user = User::find(
            array(
                "conditions" => "type = 10 and parent = :user:",
                "bind" => array(
                    "user" => $user,
                )
            )
        );
        return $user;
    }

    public function getByParent($parent)
    {
        $user = User::find(
            array(
                "conditions" => "parent = :parent: AND type <> 10",
                "bind" => array(
                    "parent" => $parent
                )
            )
        );

        return $user;
    }

    public function setUserPassword($user, $password)
    {
        $user->setPassword($password);
        $user->setResetPassword(0);
        if (!$user->save()) {
            throw new \Exception($user->getMessages());
        }
        return $user->save();
    }

    public function setResetPassword($user, $password)
    {
        $user->setPassword($password);
        $user->setResetPassword(1);
        if (!$user->save()) {
            throw new \Exception($user->getMessages());
        }
        return $user->save();

    }

    public function setNickname($user, $newNickname)
    {
        $user->setNickname($newNickname);
        $user->setResetNickname(0);
        if (!$user->save()) {
            throw new \Exception($user->getMessages());
        }
        return $user->save();
    }

    //TODO: CHANGE TO setUserStatus
    public function setStatus($user, $status)
    {
        $user->setStatus($status);
        if (!$user->save()) {
            throw new \Exception($user->getMessages());
        }
        return $user->save();
    }

    public function checkNickname($newNickname)
    {
        $nickname = User::findFirstByNickname($newNickname);
        $username = User::findFirstByUsername($newNickname);
        $check = false;
        if ($nickname || $username) {
            $check = true;
        }
        return $check;
    }


    public function filterAddAgent($data)
    {

        if (isset($data["timezone"])) $data['timezone'] = \filter_var(\strip_tags(\addslashes($data['timezone'])), FILTER_SANITIZE_STRING);
        if (isset($data["code"])) $data['code'] = \implode($data['code']);
        if (isset($data["code"])) $data['code'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
        if (isset($data["agent_code"])) $data['agent_code'] = \filter_var(\strip_tags(\addslashes($data['agent_code'])), FILTER_SANITIZE_STRING);
        if (isset($data["password"])) $data['password'] = \filter_var(\strip_tags(\addslashes($data['password'])), FILTER_SANITIZE_STRING);
        if (isset($data["confirm_password"])) $data['confirm_password'] = \filter_var(\strip_tags(\addslashes($data['confirm_password'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function validateAddAgent($data){
        $code = (isset($data['agent_code']))? $data['agent_code'].$data['code'] : $data['code'];

        if($this->checkAgent($code)){
            throw new \Exception('username_exist');
        } elseif ($data['code'] == "") {
            throw new \Exception('username_empty');
        } elseif ($data['timezone'] == "") {
            throw new \Exception('timezone_empty');
        } elseif ($data['password'] == "") {
            throw new \Exception('password_empty');
        } elseif ($data['confirm_password'] != $data['password']) {
            throw new \Exception('invalid_confirm_password');
        }

        return true;
    }

    public function validateEditAgent($data){

        if($data['id'] == ""){
            throw new \Exception('undefined_agent');
        } elseif($data['timezone'] == ""){
            throw new \Exception('timezone_empty');
        }

        return true;
    }

    public function validateResetPassword($data){

        if($data['password'] == ""){
            throw new \Exception('password_empty');
        }elseif($data['confirm_password'] == ""){
            throw new \Exception('confirm_password_empty');
        }elseif($data['confirm_password'] != $data['password']){
            throw new \Exception('confirm_password_must_same_with_password');
        }
        return true;
    }

    public function resetNickname($agentId){
        $agent = $this->getById($agentId);
        $agent->setNickname($agent->getUsername());
        $agent->setResetNickname(1);

        if(!$agent->save()){
            throw new \Exception("error_reset_nickname");
        }
        return true;
    }

    public function createAgent($data){
        $code = $data['code'];
        if (isset($data['agent_code'])) {
            $code = $data['agent_code'] . $data['code'];
        }
        $type = ($data['agent']->getType() > 0) ? $type = $data['agent']->getType() - 1 : 0;

        $newAgent = new User();
        $securityLibrary = new SecurityUser();
        $password = $securityLibrary->enc_str($data['password']);

        if(isset($data["timezone"]))$newAgent->setTimezone($data['timezone']);
        if(isset($data["code"])) {
            $newAgent->setUsername(strtoupper($code));
            $newAgent->setNickname(strtoupper($code));
        }
        if (isset($data["password"])) $newAgent->setPassword($password);
        $newAgent->setType($type);
        $newAgent->setParent($data['agent']->getId());
        $newAgent->setCode($code);
        $newAgent->setResetNickname(1);
        $newAgent->setResetPassword(1);
        $newAgent->setParentStatus($data['agent']->getStatus());

        if (!$newAgent->save()) {
            throw new \Exception('agent_create_error');
        }

        return $newAgent;
    }

    public function setAgent($data){
        $agent = $this->getById($data['id']);

        if(isset($data["timezone"]))$agent->setTimezone($data['timezone']);

        if(!$agent->save()){
            throw new \Exception('agent_edit_error');
        }

        return $agent;
    }

    public function setAgentStatus($id, $status){
        $this->setUserStatus($id, $status);

        return true;
    }

    protected function setUserStatus($id, $status){
//        $user = User::findFirstById($id);
        $user = $this->getById($id);
        $user->setStatus($status);
        $user->save();


        // get agent game

        $this->setChildParentStatus($id, $status, $user->getParentStatus());

        return true;
    }

//    protected function setChildParentStatus($id, $status){
    protected function setChildParentStatus($parentId, $parentStatus, $grandParentStatus){
        $childParentStatus = 1;
        if($grandParentStatus == 0 || $parentStatus == 0){
            $childParentStatus = 0;
        }else if($grandParentStatus == 2 || $parentStatus == 2){
            $childParentStatus = 2;
        }

        //get childs
//        $childs = User::findByParent($parentId);
        $childs = $this->getByParent($parentId);

        foreach ($childs as $child){
            $child->setParentStatus($childParentStatus);
            $child->save();

            //change all childs parent status
            $this->setChildParentStatus($child->getId(), $child->getStatus(), $childParentStatus);
        }

        // get subaccount


        // get agent game


        /*
         * TODO: CLEAN THIS
         */
        /*
        $user = User::findFirstById($id);

        if($user) {
            $userParent = User::findByParent($user->getId());

            foreach ($userParent as $key => $value) {
//                $childStatus = $status;
//                echo "<pre>";
//                var_dump("parentId = ".$user->getId());
//                var_dump("parentId ".$user->getId()." status = ".$value->getStatus());
//                var_dump("parentId ".$user->getId()." parent status = ".$value->getParentStatus());
//                var_dump("childId = ".$value->getId());
//                var_dump("childId ".$value->getId()." status = ".$value->getStatus());
//                var_dump("childId ".$value->getId()." parent status = ".$value->getParentStatus());

                if($user->getStatus() == $status){
                    $childStatus = $status;
                }
                elseif($status == 1){
//                    var_dump(1);
                    if($value->getParentStatus() == 2 && $value->getStatus() == 1 || $value->getParentStatus() == 1 && $value->getStatus() == 2){
                        $childStatus = 2;
                    }elseif($user->getParentStatus() == 0 && $user->getStatus() == 1 || $user->getParentStatus() == 1 && $user->getStatus() == 0){
                        $childStatus = 0;
                    }else{
                        $childStatus = 1;
                    }
//                    $childStatus = 1;
                }elseif($status == 2){
//                    var_dump(2);
                    if($value->getParentStatus() == 2 && $value->getStatus() == 1 || $value->getParentStatus() == 1 && $value->getStatus() == 2){
                        $childStatus = 2;
                    }elseif($user->getParentStatus() == 2 && $user->getStatus() == 1 || $user->getParentStatus() == 1 && $user->getStatus() == 2){
                        $childStatus = 2;
                    }else{
                        $childStatus = 0;
                    }
                }else{
//                    var_dump(0);
                    $childStatus = 0;
                }
//                die;
//                if($status == 1){
//                    if($value->getParentStatus() == 2 || $value->getParentStatus() == 0) {
//                        if($user->getStatus() != 0){
//                            if($user->getStatus() == 1){
//                                if($value->getParentStatus() == 0){
//                                    $childStatus = 0;
//                                }else{
//                                    $childStatus = 1;
//                                }
//                            }elseif($user->getStatus() == 2){
//                                if($value->getParentStatus() == 0) {
//                                    $childStatus = 0;
//                                }else{
//                                    $childStatus = 2;
//                                }
//                            }
//                        }else{
//                            $childStatus = 0;
//                        }
//                    }
//                }elseif($status == 2){
//                    if($value->getParentStatus() == 2 || $value->getParentStatus() == 1){
//                        if($user->getStatus() != 0){
//                            if($user->getStatus() == 1) {
//                                $childStatus = 2;
//                            }
//                        }
//                        else{
//                            $childStatus = 0;
//                        }
//                    }
//                }else{
//                    $childStatus = 0;
//                }

                $value->setParentStatus($childStatus);
                $value->save();

//                self::setChildStatus($value->getId(), $childStatus);
                $this->setChildStatus($value->getId(), $childStatus);
            }
        }
        */

        return true;
    }

    public function checkAgent($data, $id = null){
        if(isset($id)){
            $agent = User::findFirst(
                array(
                    "conditions" => "id != :id: AND username = :code: OR nickname = :code:",
                    "bind" => array(
                        "id" => $id,
                        "code" => $data,
                    )
                )
            );
        }else {
            $agent = User::findFirst(
                array(
                    "conditions" => "username = :code: OR nickname = :code:",
                    "bind" => array(
                        "code" => $data,
                    )
                )
            );
        }
        return $agent;
    }

    public function filterInputAgent($data){

        if(isset($data["timezone"])) $data['timezone'] = \filter_var(\strip_tags(\addslashes($data['timezone'])), FILTER_SANITIZE_STRING);
        if(isset($data["code"])) $data['code'] = \implode($data['code']);
        if(isset($data["code"])) $data['code'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
        if(isset($data["agent_code"])) $data['agent_code'] = \filter_var(\strip_tags(\addslashes($data['agent_code'])), FILTER_SANITIZE_STRING);
        if(isset($data["password"])) $data['password'] = \filter_var(\strip_tags(\addslashes($data['password'])), FILTER_SANITIZE_STRING);
        if(isset($data["nickname"])) $data['nickname'] = \filter_var(\strip_tags(\addslashes($data['nickname'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function filterResetPassword($data)
    {
        if (isset($data["password"])) $data['password'] = \filter_var(\strip_tags(\addslashes($data['password'])), FILTER_SANITIZE_STRING);
        if (isset($data["confirm_password"])) $data['confirm_password'] = \filter_var(\strip_tags(\addslashes($data['confirm_password'])), FILTER_SANITIZE_STRING);

        return $data;
    }

}