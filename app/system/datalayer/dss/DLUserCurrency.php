<?php
namespace System\Datalayer;

use System\Model\Currency;
use System\Model\User;
use System\Model\UserCurrency;


class DLUserCurrency extends \System\Datalayers\Main {

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
//        $userCurrency = $userCurrencyRecords['uscu']{0};
//        var_dump($userCurrency);die;
        foreach ($userCurrencyRecords['uscu'] as $userCurrencyRecord){
            $userCurrency = $userCurrencyRecord;

//            break;
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
        $userCurrencies = $this->curlAppsJson($url,$postData);

        return $userCurrencies['uscu'];
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

    public function setDefaultCurrency($id,$user){
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


}
