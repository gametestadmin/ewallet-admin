<?php
namespace System\Datalayer;

use System\Datalayers\Main;

class DLCurrency extends Main{
    // DSS

    public function findFirstById($id){
        $currencyData = false;
        $postData = array(
            'id' => $id,
        );

        $url = '/currency/'.$postData['id'];
        $currencies = $this->curlAppsJson($url,$postData);

        foreach ($currencies['currencies'] as $currency){
            $currencyData = $currency;
        }

        return $currencyData;
    }

    public function findAllByStatus($status){
        $postData = array(
            'status' => $status
        );

        $url = '/currency/find';
        $currency = $this->curlAppsJson($url, $postData);

        return $currency['currencies'];
    }

    public function findByCode($code){
        $postData = array(
            'code' => $code
        );

        $url = '/currency/find';
        $currency = $this->curlAppsJson($url,$postData);

        if($currency && $code <> $currency['currencies'][0]['cd']){
            return false;
        }

        return true;
    }

    public function filterData($data){
        $filterData = array();

        if(isset($data["id"])) $filterData['id'] = \intval($data['id']);
        if(isset($data["code"])) $filterData['cd'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
        if(isset($data["name"])) $filterData['nm'] = \filter_var(\strip_tags(\addslashes($data['name'])), FILTER_SANITIZE_STRING);
        if(isset($data["symbol"])) $filterData['sy'] = \filter_var(\strip_tags(\addslashes($data['symbol'])), FILTER_SANITIZE_STRING);
        $filterData['st'] = (isset($data["status"])?\intval($data['status']):1);
//        if(isset($data["status"])) $filterData['st'] = \intval(($data['status']));
        return $filterData;
    }

    public function validateCreateData($data){
        if($this->findByCode(strtoupper($data['cd']))){
            throw new \Exception('currency_code_exist');
        }elseif(empty($data['nm'])){
            throw new \Exception('currency_name_empty');
        }elseif(empty($data['sy'])){
            throw new \Exception('currency_symbol_empty');
        }elseif($data['st']<0 || $data['st']>1){
            throw new \Exception('undefined_currency_status');
        }

        return true;
    }
    public function validateSetData($data){
        if(empty($data['nm'])){
            throw new \Exception('currency_name_empty');
        }elseif(empty($data['sy'])){
            throw new \Exception('currency_symbol_empty');
        }elseif(strlen($data['sy']) > 3){
            throw new \Exception('currency_symbol_maximum');
        }elseif($data['st']<0 || $data['st']>1){
            throw new \Exception('undefined_currency_status');
        }

        return true;
    }

    public function listCurrency($start,$limit){
        $postData = array(
            'st' => $start,
            'lm' => $limit
        );

        $url = '/currency';
        $currencies = $this->curlAppsJson($url,$postData);

        return $currencies;
    }

    public function create($postData,$user=null){
        $url = '/currency/insert';
        $currency = $this->curlAppsJson($url,$postData);

        //find user type
        $dlUser = new DLUser();
        $userData = $dlUser->findFirstById($user);

        //Insert company currency
        if($userData['tp'] == 9) {
            $dlUserCurrency = new DLUserCurrency();
            $dlUserCurrency->create($userData['id'], $currency['data']['currencies'][0]['id']);
        }

        return $currency;
    }

    public function set($postData){
        $url = '/currency/'.$postData['id'].'/update';
        $currency = $this->curlAppsJson($url,$postData);

        return $currency['data']['currencies'][0]['id'];
    }

    public function detail($id){
        $currency = $this->findFirstById($id);

        return $currency;
    }

    public function delete($id){
        $postData = array(
            'id' => $id,
        );

        $url = '/currency/'.$postData['id'].'/delete';
        $this->curlAppsJson($url,$postData);

        return true;
    }

    // END DSS


//    public function getById($id){
//        $currency = Currency::findFirst($id);
//
//        return $currency;
//    }
//
//    public function getAll(){
//        $currency = Currency::find();
//
//        return $currency;
//    }
//
//    public function getAllByStatus($status){
//        $currency = Currency::findByStatus($status);
//
//        return $currency;
//    }
//
//    public function getByCode($code){
//        $currency = Currency::findFirstByCode($code);
//
//        return $currency;
//    }
//
//    public function checkByCode($code){
//        $currency = Currency::findFirstByCode($code);
//        if(!$currency){
//            return false;
//        }
//        return true;
//    }
//
//    public function filterInput($data){
//        if(isset($data["code"])) $data['code'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
//        if(isset($data["name"])) $data['name'] = \filter_var(\strip_tags(\addslashes($data['name'])), FILTER_SANITIZE_STRING);
//        if(isset($data["symbol"])) $data['symbol'] = \filter_var(\strip_tags(\addslashes($data['symbol'])), FILTER_SANITIZE_STRING);
////        if(isset($data["status"])) $data['status'] = \intval(($data['status']));
//        $data['status'] = (isset($data["status"])?\intval($data['status']):1);
//
//        return $data;
//    }
//
//    public function validateEdit($data){
//        if(empty($data['name'])){
//            throw new \Exception('currency_name_empty');
//        }elseif(empty($data['symbol'])){
//            throw new \Exception('currency_symbol_empty');
//        }elseif($data['status']<0 || $data['status']>1){
//            throw new \Exception('undefined_currency_status');
//        }
//
//        return true;
//    }
//
//    public function validateAdd($data){
//        if($this->checkByCode(strtoupper($data['code']))){
//            throw new \Exception('currency_code_exist');
//        }elseif(empty($data['name'])){
//            throw new \Exception('currency_name_empty');
//        }elseif(empty($data['symbol'])){
//            throw new \Exception('currency_symbol_empty');
//        }elseif($data['status']<0 || $data['status']>1){
//            throw new \Exception('undefined_currency_status');
//        }
//
//        return true;
//    }
//
//    public function creates($data){
//        $newCurrency = new Currency();
//
//        if(isset($data["code"]))$newCurrency->setCode($data['code']);
//        if(isset($data["name"]))$newCurrency->setName($data['name']);
//        if(isset($data["symbol"]))$newCurrency->setSymbol($data['symbol']);
//
//        if($newCurrency->save()){
//            $userCurrencyResult = false;
//
//            $userCurrency = new DLUserCurrency();
//            $DLUser = new DLUser();
//            $companies = $DLUser->getCompany();
//            foreach ($companies as $company){
//                $userCurrencyResult = $userCurrency->create($company->getId(),$newCurrency->getId());
//            }
////            $companyUser = array(
////                "user" => $data['user'],
////                "currency" => $newCurrency->getId(),
////            );
////            $userCurrencyResult = $userCurrency->create($companyUser);
//            if(!$userCurrencyResult) {
//                throw new \Exception('error_create_currency');
//            }
//        }
//
//        return $newCurrency->getCode();
//    }
//
//    public function sets($data){
//        $currency = $this->getByCode($data['code']);
//
//        if(isset($data["name"]))$currency->setName($data['name']);
//        if(isset($data["symbol"]))$currency->setSymbol($data['symbol']);
//        if(isset($data["status"]))$currency->setStatus($data['status']);
//
//        if(!$currency->save()){
//            throw new \Exception('error_set_currency');
//        }
//        return $currency;
//    }

}