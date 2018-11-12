<?php
namespace System\Datalayer;

use System\Model\Currency;

class DLCurrency extends \System\Datalayers\Main{
    // DSS
    public function findById($id){
        $postData = array(
            'id' => $id
        );

        $url = '/currency/find';
        $currency = $this->curlAppsJson($url,$postData);
//        $currency = Currency::findFirst($id);

        return $currency;
    }

    public function findAll(){
        $currency = Currency::find();

        return $currency;
    }

    public function findAllByStatus($status){
        $currency = Currency::findByStatus($status);

        return $currency;
    }

    public function findByCode($code){
        $postData = array(
//            "cd" => $code
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
    public function validateEditData($data){
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
        $currency = $this->curlAppsJson($url,$postData);

        return $currency['currencies'];
    }

    public function create($postData,$company=null){
        $url = '/currency/insert';
        $currency = $this->curlAppsJson($url,$postData);

        //find user type
        $dlUser = new DLUser();
        $user = $dlUser->findById($company);

        //Insert company currency
        if($user['tp'] == 9) {
            $dlUserCurrency = new DLUserCurrency();
            $dlUserCurrency->create($company, $currency['data']['currencies'][0]['id']);
        }

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
}