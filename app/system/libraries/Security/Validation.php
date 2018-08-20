<?php

namespace System\Libraries\Security;

use System\Libraries\Language\language;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\DI\FactoryDefault;

class Validation extends \System\Libraries\Main
{
    public $_valid;
    public $_messages;
    public $_conditions;

    public function __construct()
    {
        $this->_valid = true;
        $this->_messages = array();
        $this->_conditions = array();
    }

    public function addCondition($fieldName, $fieldValue, $type, $subType = NULL, $conditionValue = NULL, $conditionMaxValue = NULL){
        $condition = array();
        $condition["fieldName"] = $fieldName;
        $condition["fieldValue"] = $fieldValue;
        $condition["type"] = $type;
        $condition["subType"] = $subType;
        $condition["conditionValue"] = $conditionValue;
        $condition['conditionMaxValue'] = $conditionMaxValue;

        $this->_conditions[] = $condition;
    }

    private function isRequired($value){
        if(!isset($value) || is_null($value) || empty($value)) return false;

        return true;
    }

    private function maxLength($value, $conditionalValue){
        if(strlen($value) > $conditionalValue) return false;

        return true;
    }

    private function minLength($value, $conditionalValue){
        if(strlen($value) < $conditionalValue) return false;

        return true;
    }

    private function checkRegex($value, $conditionalValue){
        if(!preg_match($conditionalValue,$value)){
            if(strlen($value) < $conditionalValue) return false;
        }

        return true;
    }

    public function execute(){
        $conditions = $this->_conditions;

        foreach ($conditions as $condition){
            switch (strtolower($condition["type"])) {
                case "required":
                    if(!$this->isRequired($condition["fieldValue"])){
                        $this->_valid = false;
                        $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_lang['must_filled'];
                    }
                    break;
                case "length":
                    switch (strtolower($condition["subType"])) {
                        case "min":
                            if(!$this->minLength($condition["fieldValue"], $condition["conditionValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_lang['min_character']." ".$condition["conditionValue"];
                            }
                            break;
                        case "max":
                            if(!$this->maxLength($condition["fieldValue"], $condition["conditionValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_lang['max_character']." ".$condition["conditionValue"];
                            }
                            break;
                        default:
                            $this->_valid = false;
                            $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["subType"])." ".$this->_lang['not_defined'];
                    }
                    break;
                case "format":
                    switch (strtolower($condition["subType"])) {
                        case "int":
                            if(!is_numeric($condition["fieldValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_lang['format']." ".\ucfirst($condition["fieldName"])." ".$this->_lang['integer_field_only'];
                            }
                            break;
                        case "regex":
                            if(!$this->checkRegex($condition["fieldValue"], $condition["conditionValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_lang['format']." ".\ucfirst($condition["fieldName"])." ".$this->_lang['not_match'];
                            }
                            break;
                        case "date":
                            $date = explode("-", $condition["fieldValue"]);
                            if (!checkdate($date[1] , $date[0] , $date[2]))
                            {
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_lang['format']." ".\ucfirst($condition["fieldName"])." ".$this->_lang['invalid'];
                            }
                            break;
                        case "username":
                            if(!$this->isRequired($condition["fieldValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_lang['must_filled'];
                            }
                            if(!$this->minLength($condition["fieldValue"], 5)){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_lang['min_character']." ".$condition["conditionValue"];
                            }
                            if(!$this->maxLength($condition["fieldValue"], 15)){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_lang['max_character']." ".$condition["conditionValue"];
                            }
                            if(!$this->checkRegex($condition["fieldValue"], "/^[\w]+$/")){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_lang['format']." ".\ucfirst($condition["fieldName"])." ".$this->_lang['not_match'];
                            }
                            if(preg_match('/[^a-zA-Z0-9_\-]/i', $condition["fieldValue"]))
                            {
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_lang['format']." ".\ucfirst($condition["fieldName"])." ".$this->_lang['only_alphanumeric_is_allowed'];
                            }
                            if(substr(strtolower($condition["fieldValue"]),0,4) == 'bot_' || substr(strtolower($condition["fieldValue"]),0,4) == 'test' || substr(strtolower($condition["fieldValue"]),0,5) == 'admin' || substr(strtolower($condition["fieldValue"]),0,6) == 'manual' || substr(strtolower($condition["fieldValue"]),0,8) == 'operator'){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_lang['format']." ".\ucfirst($condition["fieldName"])." ".$this->_lang['not_match']." ".$this->_lang['blocked_element'];
                            }
                            break;
                        case "password":
                            if(!$this->isRequired($condition["fieldValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($this->_lang["password"])." ".$this->_lang['must_filled'];
                            }
                            if(!$this->minLength($condition["fieldValue"], 5)){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($this->_lang["password"])." ".$this->_lang['min_character']." ".$condition["conditionValue"];
                            }
                            if(!$this->maxLength($condition["fieldValue"], 10)){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($this->_lang["password"])." ".$this->_lang['max_character']." ".$condition["conditionValue"];
                            }
                            if(!$this->checkRegex($condition["fieldValue"], "/^[\w]+$/")){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_lang['format']." ".\ucfirst($this->_lang["password"])." ".$this->_lang['not_match'];
                            }
                            if(!preg_match('/[a-z]+/', $condition["fieldValue"]) || !preg_match('/[0-9]+/', $condition["fieldValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_lang['format']." ".\ucfirst($this->_lang["password"])." ".$this->_lang['must_element'];
                            }
                            break;
                        case "email":
                            if(!filter_var($condition["fieldValue"],FILTER_VALIDATE_EMAIL)){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_lang['format']." ".\ucfirst($condition["fieldName"])." ".$this->_lang['not_match']." ".$this->_lang['ex_email'];
                            }
                            break;
                        default:
                            $this->_valid = false;
                            $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["subType"])." ".$this->_lang['not_defined'];
                    }
                    break;
                case "value":
                    switch (strtolower($condition["subType"])) {
                        case "equal":
                            if (strtoupper($condition["fieldValue"]) !== strtoupper($condition["conditionValue"])) {
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"]) . " ".$this->_lang['must_same'];
                            }
                            break;
                        case "equallengthdigitbank":
                            if (strlen($condition["fieldValue"]) <= $condition["conditionValue"]) {
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($this->_lang['bank_account_no'])." ". $this->_lang["contain"]." ".$condition["conditionValue"]." ". $this->_lang["digit"];
                            }
                            break;
                        case "betweenbank":
                            if (strlen($condition["fieldValue"]) <= $condition["conditionValue"] &&
                                strlen($condition["fieldValue"]) >= $condition['conditionMaxValue'] ) {
//                                echo "length = ".strlen($condition["fieldValue"])." min value = ".$condition["conditionValue"]." max value = ".$condition['conditionMaxValue'];
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($this->_lang['bank_account_no'])." ". $this->_lang["contain"]." ".$condition["conditionValue"]." ". $this->_lang["digit"];
                            }
                            break;
                        case "notequal":
                            if (strtoupper($condition["fieldValue"]) == strtoupper($condition["conditionValue"])) {
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"]) . " ".$this->_lang['must_not_same'];
                            }
                            break;
                        case "lte":
                            if($condition["fieldValue"] <= $condition["conditionValue"]){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$condition["conditionValue"];
                            }
                            break;
                        case "lt":
                            if($condition["fieldValue"] < $condition["conditionValue"]){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_lang['less_than']." ".$condition["conditionValue"];
                            }
                            break;
                        case "gte":
                            if($condition["fieldValue"] >= $condition["conditionValue"]){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$condition["conditionValue"];
                            }
                            break;
                        case "gt":
                            if($condition["fieldValue"] > $condition["conditionValue"]){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$condition["conditionValue"];
                            }
                            break;
                        case "bca":
                            if(strlen($condition["fieldValue"]) > 10 || strlen($condition["fieldValue"]) < 9){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['first_bank_digits'];
                            }
                            break;
                        case "bni":
                            if(strlen($condition["fieldValue"]) > 10 || strlen($condition["fieldValue"]) < 9){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['second_bank_digits'];
                            }
                            break;
                        case "mandiri":
                            if(strlen($condition["fieldValue"]) != 13){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['third_bank_digits'];
                            }
                            break;
                        case "bri":
                            if(strlen($condition["fieldValue"]) != 15){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['fourth_bank_digits'];
                            }
                            break;
                        case "danamon":
                            if(strlen($condition["fieldValue"]) != 12){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['fifth_bank_digits'];
                            }
                            break;
                        case "cimb niaga":
                            if(strlen($condition["fieldValue"]) != 12){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['fifth_bank_digits'];
                            }
                            break;
                        // TODO :: validation untuk bank china, kalo gak kepake bisa di hapus. tapi jangan jika kepake
                        case "中国银行":
                            if(strlen($condition["fieldValue"]) != 19){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['fifth_bank_digits'];
                            }
                            break;
                        case "工商银行":
                            if(strlen($condition["fieldValue"]) != 19){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['fifth_bank_digits'];
                            }
                            break;
                        case "建设银行":
                            if(strlen($condition["fieldValue"]) != 19){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['fifth_bank_digits'];
                            }
                            break;
                        case "农业银行":
                            if(strlen($condition["fieldValue"]) != 19){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['fifth_bank_digits'];
                            }
                            break;
                        case "交通银行":
                            if(strlen($condition["fieldValue"]) != 19){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['fifth_bank_digits'];
                            }
                            break;
                        case "兴业银行":
                            if(strlen($condition["fieldValue"]) != 19){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." bank ".$condition["subType"]." ".$this->_lang['fifth_bank_digits'];
                            }
                            break;
                        // TODO :: validation china bank until here
                        default:
                            $this->_valid = false;
                            $this->_messages[$condition["fieldName"]][] = $condition["subType"]." ".$this->_lang['not_defined'];
                    }
                    break;

                default:
                    $this->_valid = false;
                    $this->_messages[$condition["fieldName"]][] = $condition["type"]." ".$this->_lang['not_defined'];
            }
        }

        return array(
            "valid" => $this->_valid,
            "messages" => $this->_messages
        );
    }
}
