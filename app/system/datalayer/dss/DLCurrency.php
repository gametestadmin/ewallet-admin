<?php
namespace System\Datalayer;

use System\Model\Currency;

class DLCurrency extends \System\Datalayers\Main{

    protected $_url = 'http://10.22.0.199:9090';

    public function lists($st,$limit)
    {
        $postData = array(
            'st' => $st,
            'lm' => $limit
        );

        $url = '/currency';
        $currency = $this->curlAppsJson($url,$postData);

        return $currency['currencies'];
    }

    public function insert($data)
    {
        $postData = array(
            'cd' => $data['code'],
            'nm' => $data['name'],
            'sy' => $data['symbol'],
            'st' => $data['status']
        );

        $url = '/currency/insert';
        $currency = $this->curlAppsJson($url,$postData);

        return $currency['data']['currencies'][0]['id'];
    }

    public function update($postData)
    {
        $url = '/currency/'.$postData['id'].'/update';
        $currency = $this->curlAppsJson($url,$postData);

        return $currency['data']['currencies'][0]['id'];
    }

    public function detail($id)
    {
        $postData = array(
            'id' => $id,
        );

        $url = '/currency/'.$postData['id'];
        $currency = $this->curlAppsJson($url,$postData);

        return $currency['currencies'];
    }

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

        $url = $this->_url.'/currency/code/'.$postData['cd'];
        $currency = $this->curlAppsJson($url,$postData);

        echo "<pre>";
        var_dump($currency);
        die;

        $currency = Currency::findFirstByCode($code);
        if(!$currency){
            return false;
        }
        return true;
    }

    public function filterInput($data){
        if(isset($data["code"])) $data['code'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
        if(isset($data["name"])) $data['name'] = \filter_var(\strip_tags(\addslashes($data['name'])), FILTER_SANITIZE_STRING);
        if(isset($data["symbol"])) $data['symbol'] = \filter_var(\strip_tags(\addslashes($data['symbol'])), FILTER_SANITIZE_STRING);
//        if(isset($data["status"])) $data['status'] = \intval(($data['status']));
        $data['status'] = (isset($data["status"])?\intval($data['status']):1);

        return $data;
    }

    public function validateEdit($data){
        if(empty($data['name'])){
            throw new \Exception('currency_name_empty');
        }elseif(empty($data['symbol'])){
            throw new \Exception('currency_symbol_empty');
        }elseif($data['status']<0 || $data['status']>1){
            throw new \Exception('undefined_currency_status');
        }

        return true;
    }

    public function validateAdd($data){
        if($this->checkByCode(strtoupper($data['code']))){
            throw new \Exception('currency_code_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('currency_name_empty');
        }elseif(empty($data['symbol'])){
            throw new \Exception('currency_symbol_empty');
        }elseif($data['status']<0 || $data['status']>1){
            throw new \Exception('undefined_currency_status');
        }

        return true;
    }

    public function create($data){
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

    public function set($data){
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