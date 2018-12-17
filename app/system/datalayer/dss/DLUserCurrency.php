<?php
namespace System\Datalayer;

use System\Model\Currency;
use System\Model\User;
use System\Model\UserCurrency;

<<<<<<< HEAD
class DLUserCurrency extends \System\Datalayers\Main {
    // DSS

    public function findByCurrency($currency){
//        $userCurrencyData = false;
        $postData = array(
            'currency' => $currency
        );

        $url = '/usercurr/find';
        $userCurrencies = $this->curlAppsJson($url,$postData);

//        foreach ($userCurrencies['uscu'] as $userCurrency){
//            $userCurrencyData = $userCurrency;
//        }

        return $userCurrencies['uscu'];
    }

    public function findByUser($user){
        $postData = array(
            'user_id' => $user
        );

        $url = '/usercurr/find';
        $userCurrencies = $this->curlAppsJson($url,$postData);

        return $userCurrencies['uscu'];
    }

    public function findAgentCurrency($agent,$currency){
        $userCurrency = false;
        // get user currency by user(us) and currency(cr) return all user currency data
        $postData = array(
            'user_id' => $agent,
            'currency' => $currency
        );

        $url = '/usercurr/find';
        $userCurrencyRecords = $this->curlAppsJson($url,$postData);

        foreach ($userCurrencyRecords['uscu'] as $userCurrencyRecord){
            $userCurrency = $userCurrencyRecord;
        }

        return $userCurrency;
    }

    public function findFirstAgentCurrency($agent,$currency){
        $userCurrency = false;

        $postData = array(
            'user_id' => $agent,
            'currency' => $currency
        );

        $url = '/usercurr/find';
        $userCurrencyRecords = $this->curlAppsJson($url,$postData);
        foreach ($userCurrencyRecords['uscu'] as $userCurrencyRecord){
            $userCurrency = $userCurrencyRecord;
        }

        return $userCurrency;
    }

    public function findAllByAgent($agent,$status,$currencyStatus){
        // find user currency by user and status return all user currency data
        $postData = array(
            'user_id' => $agent,
            'status' => $status,
            'currency_status' => $currencyStatus
        );

        $url = '/usercurr/find';
        $userCurrency = $this->curlAppsJson($url,$postData);

        return $userCurrency['uscu'];
    }

    public function findByUserAndAllStatus($agent,$status,$currency_status){
        $postData = array(
            'user_id' => $agent,
            'status' => $status,
            'currency_status' => $currency_status
        );

        $url = '/usercurr/find';
        $userCurrency = $this->curlAppsJson($url,$postData);

        return $userCurrency['uscu'];
    }

    public function findUserCurrency($agent,$status){
        // find user currency by user and status return all user currency data
        $userCurrency = false;
        $postData = array(
            'user_id' => 2,
            'status' => $status
        );

        $url = '/usercurr/find';
        $userCurrencyRecords = $this->curlAppsJson($url,$postData);
        foreach ($userCurrencyRecords['uscu'] as $userCurrencyRecord){
            $userCurrency = $userCurrencyRecord;
        }

        return $userCurrency;
    }

    public function findAllByUser($user){
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

    public function listUserCurrency($start,$limit){
        $postData = array(
            'st' => $start,
            'lm' => $limit
        );

        $url = '/usercurr';
        $userCurrencies = $this->curlAppsJson($url,$postData);

        return $userCurrencies['uscu'];
    }

    public function findByAgent($agent){
        $userCurrency = false;

        $postData = array(
            "user_id" => $agent,
        );

        $url = '/usercurr/find';
        $userCurrencyRecords = $this->curlAppsJson($url,$postData);

        foreach ($userCurrencyRecords['uscu'] as $userCurrencyRecord){
            $userCurrency = $userCurrencyRecord;
        }
        return $userCurrency;
    }

    public function findFirstById($id){
        $userCurrency = false;
        $postData = array(
            "id" => $id,
        );

        $url = '/usercurr/'.$postData['id'];
        $userCurrencyRecords = $this->curlAppsJson($url,$postData);
        foreach ($userCurrencyRecords['uscu'] as $userCurrencyRecord){
            $userCurrency = $userCurrencyRecord;
        }

        return $userCurrency;
    }
    public function findByUserCurrencyDefault($user){
        $userCurrency = false;
        $postData = array(
            "user_id" => $user,
            "default_val" => 1
        );
        $url = '/usercurr/find';
        $userCurrencyRecords = $this->curlAppsJson($url,$postData);

        foreach ($userCurrencyRecords['uscu'] as $userCurrencyRecord){
            $userCurrency = $userCurrencyRecord;
        }
        return $userCurrency;
    }

    public function filterData($data){
        $filterData = array();

        if(isset($data["user"])) $filterData['idus'] = \intval($data['user']);
        if(isset($data["currency"])) $filterData['idcu'] = \intval($data['currency']);
//        $filterData['st'] = (isset($data["status"])?\intval($data['status']):1);
        $filterData['cust'] = (isset($data["currency_status"])?\intval($data['currency_status']):1);

        return $filterData;
    }

    public function create($agent,$currency){
        $userCurrency = $this->findFirstAgentCurrency($agent,$currency);

        if($userCurrency <> false){
            $postData = array(
                "id" => $userCurrency['id'],
                "st" => 1
            );
            $url = '/usercurr/'.$postData['id'].'/update';
            $this->curlAppsJson($url,$postData);

        }else {
            $userCurrency = $this->findByAgent($agent);

            $default = 0;
            if($userCurrency == false){
                $default = 1;
            }
            $postData = array(
                "idus" => $agent,
                "idcu" => $currency,
                "df" => $default,
                "st" => 1,
                "cust" => 1,
            );
            $url = '/usercurr/insert';
            $this->curlAppsJson($url,$postData);
        }

        return true;
    }

    public function setDefault($id,$user){
        $userCurrency = $this->findFirstById($id);
        if($userCurrency->st == 0){
            throw new \Exception('error_set_default_currency');
        }
        $currencyUserCurrencyDefault = $this->findByUserCurrencyDefault($user);

        if($currencyUserCurrencyDefault) {
            $postData = array(
                "id" => $currencyUserCurrencyDefault['id'],
                "df" => 0
            );

            $this->set($postData);
        }

        $postData = array(
            "id" => $id,
            "df" => 1
        );

        $this->set($postData);

        return true;
    }

    public function set($postData){

        $url = '/usercurr/'.$postData['id'].'/update';
        $this->curlAppsJson($url,$postData);

        return true;
    }

    public function delete($postData){
        $userCurrency = $this->findFirstById($postData['id']);
        if($userCurrency['df'] == 1 || $userCurrency['st'] == 0){
            throw new \Exception('error_remove_currency');
        }

        $url = '/usercurr/'.$postData['id'].'/delete';
        $this->curlAppsJson($url,$postData);

        return true;
    }

    // END DSS
=======
class DLUserCurrency  extends \System\Datalayers\Main
{

    // 2 , 6
    public function setCurrencyDefault($userId , $CurrencyId){

        $userCurrency = $this->getByUserAndId( $userId , $CurrencyId );
        if( $userCurrency->{0}->st == 0){
            throw new \Exception('error_set_default_currency');
        }
        $currentUserCurrency = $this->getByUserAndDefault( $userId , $CurrencyId );
        $oldcurrency = $this->setDefault( $currentUserCurrency->{0}->id , 0 ) ;
        $newcurrency = $this->setDefault( $userCurrency->{0}->id , 1 ) ;
        if ( $oldcurrency->ec == 0 ){
            if( $newcurrency->ec != 0  ){
                throw new \Exception('error_set_currency');
            }
        }else{
            throw new \Exception('error_set_currency');
        }
//        $currentUserCurrency->setDefault(0);
//        if($currentUserCurrency->save()){
//            $userCurrency->setDefault(1);
//
//            if(!$userCurrency->save()){
//                throw new \Exception('error_set_currency');
//            }
//        }else{
//            throw new \Exception('error_set_currency');
//        }

        return true ;


    }

    public function getByUserAndId( $user , $id ){
        $postData = array(
            'id' => $id ,
            'user_id' => $user ,
        );
        $url = '/usercurr/find';
        $result = $this->curlAppsJson( $url , $postData);

        return $result->uscu ;
    }


    public function getByUserAndDefault($user){
        $postData = array(
            'default_val' => 1 ,
            'user_id' => $user ,
        );
        $url = '/usercurr/find';
        $result = $this->curlAppsJson( $url , $postData);

        return $result->uscu ;
    }

    public function getByUser($user){
        $postData = array(
            'status' => 1 ,
            'user_id' => $user ,
        );
        $url = '/usercurr/find';
        $result = $this->curlAppsJson( $url , $postData);

        return $result->uscu ;
    }

    public function setDefault( $id , $value ){
        $postData = array(
            'df' => $value
        );
        $url = '/usercurr/'.$id.'/update';
        $result = $this->curlAppsJson( $url , $postData);

        return $result ;
    }


//////////////////////////////////////////////////////////////////////////////////////////////////////////





>>>>>>> 8afdccbf98f3d33b7315d9b53ca0930b5903294b

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



    public function getAllByAgents($agent){
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

    public function sets($data){
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

<<<<<<< HEAD
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
=======
>>>>>>> 8afdccbf98f3d33b7315d9b53ca0930b5903294b

    public function deletes($data){
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