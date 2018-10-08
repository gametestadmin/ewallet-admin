<?php
namespace System\Datalayer;

use System\Model\Currency;
use System\Model\User;
use System\Model\UserCurrency;

class DLUserCurrency {
    public function getAll($user){
        $userCurrency = UserCurrency::findByUser($user);

        return $userCurrency;
    }

    public function getAllByUser($user){
        $userCurrency = UserCurrency::findByUser($user);

        return $userCurrency;
    }

    public function getAllByUserAndParent($user,$agent){
        $agentCurrency = UserCurrency::find(
            array(
                "conditions" => "user = :agent:",
                "bind" => array(
                    "agent" => $agent
                )
            )
        );
//        $userCurrency = array();
//        foreach ($agentCurrency as $key => $value){
            $userCurrency = UserCurrency::find(
                array(
                    "conditions" => "user = :user:",
                    "bind" => array(
                        "user" => $user,
                    )
                )
            );
//        }
//        echo "<pre>";
//        foreach ($userCurrency as $key => $value){
//            var_dump($userCurrency);
//        }
//        die;
//        $agentCurrency = (object)(array)$agentCurrency;
//        $userCurrency = (object)(array)$userCurrency;
//        $currency = array_diff($agentCurrency,$userCurrency);

        return $userCurrency;
    }

    public function getById($id){
        $userCurrency = UserCurrency::findFirstById($id);

        return $userCurrency;
    }

    public function getByIdAndDefault($user){
        $userCurrency = UserCurrency::findFirst(
            array(
                "conditions" => "user = :user: AND default = 1",
                "bind" => array(
                    "user" => $user
                )
            )
        );

        return $userCurrency;
    }

    public function checkUser($user){
        $user = User::findFirstById($user);

        return $user;
    }

    public function checkCurrency($currency){
        $currency = Currency::findFirstById($currency);

        return $currency;
    }

    public function checkCurrentUserCurrency($user,$currency){
        $userCurrency = UserCurrency::findFirst(
            array(
                "conditions" => "user = :user_id: AND currency = :currency_id:",
                "bind" => array(
                    "user_id" => $user,
                    "currency_id" => $currency,
                )
            )
        );

        return $userCurrency;
    }

    public function filterInput($data){
        if(isset($data["currency"])) $data['currency'] = \intval($data['currency']);
        if(isset($data["user"])) $data['user'] = \intval($data['user']);

        return $data;
    }

    public function validateAdd($data){
        if(!$this->checkUser($data['user'])){
            throw new \Exception('undefined_user');
        }elseif(!$this->checkCurrency($data['currency'])){
            throw new \Exception('undefined_currency');
        }elseif($this->checkCurrentUserCurrency($data['user'],$data['currency'])){
            throw new \Exception('currency_exist');
        }
        return true;
    }

    public function create($user,$currency){
        $newUserCurrency = new UserCurrency();

        if(isset($user))$newUserCurrency->setUser($user);
        if(isset($currency))$newUserCurrency->setCurrency($currency);
        if(count($this->getAllByUser($user)) == 0){
            $newUserCurrency->setDefault(1);
        }else {
            $newUserCurrency->setDefault(0);
        }

        if(!$newUserCurrency->save()){
            throw new \Exception('error_add_user_currency');
        }

        return true;
    }

    public function set($data){
        $userId = $data["agent_id"];
        $userCurrencyId = $data["currency_id"];

        $currentUserCurrency = $this->getByIdAndDefault($userId);

        $currentUserCurrency->setDefault(0);

        if($currentUserCurrency->save()){
            $userCurrency = $this->getById($userCurrencyId);

            $userCurrency->setDefault(1);

            if(!$userCurrency->save()){
                throw new \Exception('error_set_currency');
            }
        }else{
            throw new \Exception('error_set_currency');
        }
        return $userCurrency;
    }


    public function setFromParent($parentId,$gameId){
        $parentGameCurrency = $this->getAllByUser($parentId);

        if(count($parentGameCurrency) == 0){
            echo 3;
            die;
        }else{
            foreach ($parentGameCurrency as $key => $value){
                $childGameCurrency = new UserCurrency();
                $childGameCurrency->setGame($gameId);
                $childGameCurrency->setCurrency($value->getCurrencyId());
                $childGameCurrency->setDefault($value->getDefault());

                if($childGameCurrency->save()){
                    throw new \Exception($childGameCurrency->getMessages());
                }
            }
        }
    }

}