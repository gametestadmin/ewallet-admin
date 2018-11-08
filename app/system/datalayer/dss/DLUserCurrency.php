<?php
namespace System\Datalayer;

use System\Model\Currency;
use System\Model\User;
use System\Model\UserCurrency;

class DLUserCurrency extends \System\Datalayers\Main {
    // DSS

    public function findAgentCurrency($agent,$currency){
        // get user currency by user(us) and currency(cr) return all user currency data
        $postData = array(
            'user' => $agent,
            'currency' => $currency
        );

        $url = '/usercurr/find';
        $userCurrency = $this->curlAppsJson($url,$postData);

        return $userCurrency;
    }

    public function findAllByAgent($agent,$status){
        // find user currency by user and status return all user currency data
        $postData = array(
            'user' => $agent,
            'status' => $status
        );

        $url = '/usercurr/find';
        $userCurrency = $this->curlAppsJson($url,$postData);

        return $userCurrency;
    }

    public function listUserCurrency($start,$limit){
        $postData = array(
            'st' => $start,
            'lm' => $limit
        );

        $url = '/usercurr';
        $userCurrencies = $this->curlAppsJson($url,$postData);

//        echo "<pre>";
////        var_dump($userCurrencies['uscu']);
//        foreach ($userCurrencies['uscu'] as $userCurrency){
//            var_dump($userCurrency);
//            var_dump($userCurrency['df']);
//        }
//        die;
        return $userCurrencies['uscu'];
    }

    public function create($agent,$currency){
        $userCurrency = $this->findAgentCurrency($agent,$currency);

        // check result ada atau tidak
        if($userCurrency){
            $postData = array(
                'us' => $agent,
                'cr' => $currency,
                'st' => 1
            );

            $url = '/usercurr/update';
            $createUserCurrency = $this->curlAppsJson($url,$postData);
        }else {
            $userCurrency = $this->findAllByAgent($agent,1);

            $default = 0;
            if(empty($userCurrency)){
                $default = 1;
            }
            // insert user currency by user(us), currency(cr), status(st), and default(df)
            $postData = array(
                'us' => $agent,
                'cr' => $currency,
                'st' => 1,
                'df' => $default
            );
            $url = '/usercurr/insert';
            $createUserCurrency = $this->curlAppsJson($url,$postData);
        }

        if(!$createUserCurrency){
            throw new \Exception('error_add_user_currency');
        }

        return $userCurrency['user_currencies'];
    }
    // END DSS

    public function getAll($user){
        $userCurrency = UserCurrency::findByUser($user);

        return $userCurrency;
    }

    public function getAgentCurrencies($user,$status = 1){
        $userCurrency = UserCurrency::find(
            array(
                "conditions" => "user = :user: AND status >= :status:",
                "bind" => array(
                    "user" => $user,
                    "status" => $status
                )
            )
        );

        return $userCurrency;
    }

    public function getUserCurrencies($user,$status = 1){
        $userCurrency = UserCurrency::find(
            array(
                "conditions" => "user = :user: AND status = :status:",
                "bind" => array(
                    "user" => $user,
                    "status" => $status
                )
            )
        );

        return $userCurrency;
    }

    public function getAllByUser($user){
        $userCurrency = UserCurrency::find(
            array(
                "conditions" => "user = :user: AND status = 1",
                "bind" => array(
                    "user" => $user,
                ),
            )
        );

        return $userCurrency;
    }

    public function getAllByParent($user){
        $userCurrency = UserCurrency::find(
            array(
                "conditions" => "user = :user: AND status = 1",
                "bind" => array(
                    "user" => $user,
                )
            )
        );

        return $userCurrency;
    }

    public function getByUser($user){
        $userCurrency = UserCurrency::find(
            array(
                "conditions" => "user = :user: AND status = 1",
                "bind" => array(
                    "user" => $user,
                )
            )
        );

        return $userCurrency;
    }

    public function getAllByAgents($agent){
//        $agentCurrency = UserCurrency::findByUser($agent);
//        $userCurrency = array();
//        foreach ($agentCurrency as $key) {
//            $userCurrency = UserCurrency::find(
//                array(
//                    "conditions" => "user = :user: AND user != :agent: AND currency != :currency:",
//                    "bind" => array(
//                        "user" => $user,
//                        "agent" => $agent,
//                        "currency" => $key->getCurrency(),
//                    )
//                )
//            );
//        }
        $agentCurrency = UserCurrency::find(
            array(
                "conditions" => "user = :user:",
                "bind" => array(
                    "user" => $agent,
                )
            )
        );

        return $agentCurrency;
    }

    public function getById($id){
        $userCurrency = UserCurrency::findFirstById($id);

        return $userCurrency;
    }

    public function getUserCurrency($user,$currency){
        $currency = UserCurrency::findFirst(
            array(
                "conditions" => "user = :user: AND currency = :currency:",
                "bind" => array(
                    "user" => $user,
                    "currency" => $currency
                )
            )
        );

        return $currency;
    }

    public function getByUserAndId($user,$id){
        $userCurrency = UserCurrency::findFirst(
            array(
                "conditions" => "id = :id: AND user = :user:",
                "bind" => array(
                    "user" => $user,
                    "id" => $id,
                )
            )
        );

        return $userCurrency;
    }

    public function getByUserAndDefault($user){
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
                "conditions" => "user = :user_id: AND currency = :currency_id: AND status = 1",
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

    public function creates($user,$currency){
        $userCurrency = $this->getUserCurrency($user,$currency);

        if($userCurrency){
            $userCurrency->setStatus(1);
        }else {
            $userCurrency = new UserCurrency();

            if (isset($user)) $userCurrency->setUser($user);
            if (isset($currency)) $userCurrency->setCurrency($currency);
            if (count($this->getAllByUser($user)) == 0) {
                $userCurrency->setDefault(1);
            } else {
                $userCurrency->setDefault(0);
            }
        }

        if(!$userCurrency->save()){
            throw new \Exception('error_add_user_currency');
        }

        return true;
    }

    public function set($data){
        $userId = $data["agent_id"];
        $userCurrencyId = $data["currency_id"];

        $userCurrency = $this->getByUserAndId($userId,$userCurrencyId);
        if($userCurrency->getStatus() == 0){
            throw new \Exception('error_set_default_currency');
        }

        $currentUserCurrency = $this->getByUserAndDefault($userId,$userCurrencyId);
        $currentUserCurrency->setDefault(0);

        if($currentUserCurrency->save()){
            $userCurrency->setDefault(1);

            if(!$userCurrency->save()){
                throw new \Exception('error_set_currency');
            }
        }else{
            throw new \Exception('error_set_currency');
        }
        return $userCurrency;
    }

    public function setCurrencyDefault($userId , $CurrencyId){
        $userCurrency = $this->getByUserAndId($userId,$CurrencyId);
        if($userCurrency->getStatus() == 0){
            throw new \Exception('error_set_default_currency');
        }
        $currentUserCurrency = $this->getByUserAndDefault($userId,$CurrencyId);
        $currentUserCurrency->setDefault(0);

        if($currentUserCurrency->save()){
            $userCurrency->setDefault(1);

            if(!$userCurrency->save()){
                throw new \Exception('error_set_currency');
            }
        }else{
            throw new \Exception('error_set_currency');
        }
        return $userCurrency;


    }

    public function delete($data){
        $userId = $data["agent_id"];
        $userCurrencyId = $data["currency_id"];

        $currentUserCurrency = $this->getByUserAndId($userId,$userCurrencyId);

        if($currentUserCurrency->getDefault() == 1){
            throw new \Exception('error_remove_currency');
        }
        if($currentUserCurrency->getStatus() == 0) {
            throw new \Exception('error_remove_currency');
        }

        $currentUserCurrency->setStatus(0);
        if(!$currentUserCurrency->save()){
            throw new \Exception('error_remove_currency');
        }
        return $currentUserCurrency;
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