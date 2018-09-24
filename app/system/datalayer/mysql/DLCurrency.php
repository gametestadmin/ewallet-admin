<?php
namespace System\Datalayer;

use System\Model\Currency;

class DLCurrency {

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
        if(isset($data["status"])) $data['status'] = \intval($data['status']);

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
        $data = $this->filterInput($data);
        $this->validateAdd($data);

        $newCurrency = new Currency();

        if(isset($data["code"]))$newCurrency->setCode($data['code']);
        if(isset($data["name"]))$newCurrency->setName($data['name']);
        if(isset($data["symbol"]))$newCurrency->setSymbol($data['symbol']);

        if(!$newCurrency->save()){
            throw new \Exception('error_create_currency');
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