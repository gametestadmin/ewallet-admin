<?php
namespace System\Datalayer;

use System\Model\Currency;

class DLCurrency {

    public function getbyId($id){
        $data = "select * from <TABLE> WHERE id =";

        return $data;
    }


    public function set($data){
        $currency = new Currency();
        if(isset($data["name"])) $currency->setName($data["name"]);
        if(isset($data["country"])) $currency->setCountry($data["country"]);
        $currency->save();

        return $currency;
    }

//    public function increaseUsage($amount){
//        $amount = $asd->getUsage() + $amount;
//
//        $asd->setUsage($amount);
//        $asd->save();
//
//        retur $asd;
//    }

//    public function custom


}