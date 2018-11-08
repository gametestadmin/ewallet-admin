<?php
namespace System\Datalayer;

use System\Model\Currency;

class DLCurrency extends \System\Datalayers\Main{
    // DSS
    public function findByCode($code){
        $postData = array(
            "cd" => $code
        );

        $url = '/currency/code/'.$postData['cd'];
        $currency = $this->curlAppsJson($url,$postData);

        if($code != $currency['currencies'][0]['cd']){
            return false;
        }

        return true;
    }

    public function filterData($data){
        if(isset($data["id"])) $filterData['id'] = \filter_var(\strip_tags(\addslashes($data['id'])), FILTER_SANITIZE_STRING);
        if(isset($data["code"])) $filterData['cd'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
        if(isset($data["name"])) $filterData['nm'] = \filter_var(\strip_tags(\addslashes($data['name'])), FILTER_SANITIZE_STRING);
        if(isset($data["symbol"])) $filterData['sy'] = \filter_var(\strip_tags(\addslashes($data['symbol'])), FILTER_SANITIZE_STRING);
//        if(isset($data["status"])) $data['status'] = \intval(($data['status']));
        $filterData['st'] = (isset($data["status"])?\intval($data['status']):1);

        return $filterData;
    }

    public function validateAddData($data){
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

    public function listCurrency($start,$limit){
        $postData = array(
            'st' => $start,
            'lm' => $limit
        );

        $url = '/currency';
        $currency = $this->curlAppsJson($url,$postData);

        return $currency['currencies'];
    }

    public function create($postData){
        $url = '/currency/insert';
        $currency = $this->curlAppsJson($url,$postData);

        //TODO: Insert to company currency
//        $dlUserCurrency = new DLUserCurrency();
//        $dlUserCurrency->create($agent,$currency);

        return $currency['data']['currencies'][0]['id'];
    }

    public function set($postData){
        $url = '/currency/'.$postData['id'].'/update';
        $currency = $this->curlAppsJson($url,$postData);

        return $currency['data']['currencies'][0]['id'];
    }

    public function detail($id){
        $postData = array(
            'id' => $id,
        );

        $url = '/currency/'.$postData['id'];
        $currency = $this->curlAppsJson($url,$postData);

        return $currency['currencies'][0];
    }

    public function delete($id){
        $postData = array(
            'id' => $id,
        );

        $url = '/currency/'.$postData['id'].'/delete';
        $currency = $this->curlAppsJson($url,$postData);

        return true;
    }

    // END DSS

    public function getById($id){
        $currency = Currency::findFirst($id);

        return $currency;
    }

    public function getAll(){
        $currency = Currency::find();

        return $currency;
    }

    public function getAllByStatus($status){
        $currency = Currency::findByStatus($status);

        return $currency;
    }

    public function getByCode($code){
        $currency = Currency::findFirstByCode($code);

        return $currency;
    }

    public function checkByCode($code){
        $postData = array(
            "cd" => $code
        );

        $url = '/currency/code/'.$postData['cd'];
        $currency = $this->curlAppsJson($url,$postData);

        if($code != $currency['currencies'][0]['cd']){
            return false;
        }

        return true;
    }

    public function filterInput($data){
        if(isset($data["id"])) $filterData['id'] = \filter_var(\strip_tags(\addslashes($data['id'])), FILTER_SANITIZE_STRING);
        if(isset($data["code"])) $filterData['cd'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
        if(isset($data["name"])) $filterData['nm'] = \filter_var(\strip_tags(\addslashes($data['name'])), FILTER_SANITIZE_STRING);
        if(isset($data["symbol"])) $filterData['sy'] = \filter_var(\strip_tags(\addslashes($data['symbol'])), FILTER_SANITIZE_STRING);
//        if(isset($data["status"])) $data['status'] = \intval(($data['status']));
        $filterData['st'] = (isset($data["status"])?\intval($data['status']):1);

        return $filterData;
    }

    public function validateEdit($data){
        // change validate to DSS data
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

    public function validateAdd($data){
        // change validate to DSS data
        if($this->checkByCode(strtoupper($data['cd']))){
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

    public function creates($data){
        $newCurrency = new Currency();

        if(isset($data["code"]))$newCurrency->setCode($data['code']);
        if(isset($data["name"]))$newCurrency->setName($data['name']);
        if(isset($data["symbol"]))$newCurrency->setSymbol($data['symbol']);

        if($newCurrency->save()){
            $userCurrencyResult = false;

            $userCurrency = new DLUserCurrency();
            $DLUser = new DLUser();
            $companies = $DLUser->getCompany();
            foreach ($companies as $company){
                $userCurrencyResult = $userCurrency->create($company->getId(),$newCurrency->getId());
            }
//            $companyUser = array(
//                "user" => $data['user'],
//                "currency" => $newCurrency->getId(),
//            );
//            $userCurrencyResult = $userCurrency->create($companyUser);
            if(!$userCurrencyResult) {
                throw new \Exception('error_create_currency');
            }
        }

        return $newCurrency->getCode();
    }

    public function sets($data){
        $currency = $this->getByCode($data['code']);

        if(isset($data["name"]))$currency->setName($data['name']);
        if(isset($data["symbol"]))$currency->setSymbol($data['symbol']);
        if(isset($data["status"]))$currency->setStatus($data['status']);

        if(!$currency->save()){
            throw new \Exception('error_set_currency');
        }
        return $currency;
    }

}