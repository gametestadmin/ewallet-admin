<?php
namespace System\Datalayer;

use System\Library\Security\User as SecurityUser ;
use System\Model\User;

class DLUser
{

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


    public function getByParent($parent)
    {
        $user = User::findByParent($parent);

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

    public function setNickname($user, $newNickname)
    {
        $user->setNickname($newNickname);
        $user->setResetNickname(0);
        if (!$user->save()) {
            throw new \Exception($user->getMessages());
        }
        return $user->save();
    }


    public function filterAddAgent($data)
    {

        if (isset($data["timezone"])) $data['timezone'] = \filter_var(\strip_tags(\addslashes($data['timezone'])), FILTER_SANITIZE_STRING);
        if (isset($data["code"])) $data['code'] = \implode($data['code']);
        if (isset($data["code"])) $data['code'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
        if (isset($data["agent_code"])) $data['agent_code'] = \filter_var(\strip_tags(\addslashes($data['agent_code'])), FILTER_SANITIZE_STRING);
        if (isset($data["password"])) $data['password'] = \filter_var(\strip_tags(\addslashes($data['password'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function validateAddAgent($data)
    {
        $code = (isset($data['agent_code'])) ? $data['agent_code'] . $data['code'] : $data['code'];
        $agent = User::findFirst(
            array(
                "conditions" => "username = :code: OR nickname = :code:",
                "bind" => array(
                    "code" => $code,
                )
            )
        );

        if ($agent) {
            throw new \Exception('username_exist');
        } elseif ($data['code'] == "") {
            throw new \Exception('username_empty');
        } elseif ($data['timezone'] == "") {
            throw new \Exception('timezone_empty');
        } elseif ($data['password'] == "") {
            throw new \Exception('password_empty');
        }

        return true;
    }

    public function setAddAgent($data)
    {
        $code = $data['code'];
        if (isset($data['agent_code'])) {
            $code = $data['agent_code'] . $data['code'];
        }
        $type = ($data['agent']->getType() > 0) ? $type = $data['agent']->getType() - 1 : 0;

        $newAgent = new User();
        $securityLibrary = new SecurityUser();
        $password = $securityLibrary->enc_str($data['password']);

        if (isset($data["timezone"])) $newAgent->setTimezone($data['timezone']);
        if (isset($data["code"])) {
            $newAgent->setUsername($code);
            $newAgent->setNickname($code);
        }
        if (isset($data["password"])) $newAgent->setPassword($password);
        $newAgent->setType($type);
        $newAgent->setParent($data['agent']->getId());
        $newAgent->setCode($code);
        $newAgent->setResetNickname(1);
        // TODO :: temporary 0
//        $newAgent->setResetPassword(0);
        $newAgent->setResetPassword(1);
        $newAgent->setParentStatus($data['agent']->getStatus());

        if (!$newAgent->save()) {
            throw new \Exception('agent_create_error');
        }

        return $newAgent;
    }
}