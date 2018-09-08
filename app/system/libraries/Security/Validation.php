<?php
namespace System\Library\Security;

use \Phalcon\Translate\Adapter\NativeArray;
use \Phalcon\DI\FactoryDefault;

class Validation extends \System\Library\Main
{
    public $_valid;
    public $_messages;
    public $_conditions;

    public function __construct()
    {
        parent::__construct();
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
                        $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_language['must_filled'];
                    }
                    break;
                case "length":
                    switch (strtolower($condition["subType"])) {
                        case "min":
                            if(!$this->minLength($condition["fieldValue"], $condition["conditionValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_language['minimum_character']." ".$condition["conditionValue"];
                            }
                            break;
                        case "max":
                            if(!$this->maxLength($condition["fieldValue"], $condition["conditionValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_language['maximum_character']." ".$condition["conditionValue"];
                            }
                            break;
                        default:
                            $this->_valid = false;
                            $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["subType"])." ".$this->_language['not_defined'];
                    }
                    break;
                case "format":
                    switch (strtolower($condition["subType"])) {
                        case "int":
                            if(!is_numeric($condition["fieldValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_language['format']." ".\ucfirst($condition["fieldName"])." ".$this->_language['integer_field_only'];
                            }
                            break;
                        case "regex":
                            if(!$this->checkRegex($condition["fieldValue"], $condition["conditionValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_language['format']." ".\ucfirst($condition["fieldName"])." ".$this->_language['not_match'];
                            }
                            break;
                        case "date":
                            $date = explode("-", $condition["fieldValue"]);
                            if (!checkdate($date[1] , $date[0] , $date[2]))
                            {
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_language['format']." ".\ucfirst($condition["fieldName"])." ".$this->_language['invalid'];
                            }
                            break;
                        case "username":
                            if(!$this->isRequired($condition["fieldValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_language['must_filled'];
                            }
                            if(!$this->minLength($condition["fieldValue"], 5)){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_language['minimum_character']." ".$condition["conditionValue"];
                            }
                            if(!$this->maxLength($condition["fieldValue"], 15)){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_language['maximum_character']." ".$condition["conditionValue"];
                            }
                            if(!$this->checkRegex($condition["fieldValue"], "/^[\w]+$/")){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_language['format']." ".\ucfirst($condition["fieldName"])." ".$this->_language['not_match'];
                            }
                            if(preg_match('/[^a-zA-Z0-9_\-]/i', $condition["fieldValue"]))
                            {
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_language['format']." ".\ucfirst($condition["fieldName"])." ".$this->_language['only_alphanumeric_is_allowed'];
                            }
                            if(substr(strtolower($condition["fieldValue"]),0,4) == 'bot_' || substr(strtolower($condition["fieldValue"]),0,4) == 'test' || substr(strtolower($condition["fieldValue"]),0,5) == 'admin' || substr(strtolower($condition["fieldValue"]),0,6) == 'manual' || substr(strtolower($condition["fieldValue"]),0,8) == 'operator'){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_language['format']." ".\ucfirst($condition["fieldName"])." ".$this->_language['not_match']." ".$this->_language['blocked_element'];
                            }
                            break;
                        case "password":
                            if(!$this->isRequired($condition["fieldValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($this->_language["password"])." ".$this->_language['must_filled'];
                            }
                            if(!$this->minLength($condition["fieldValue"], $condition["conditionValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($this->_language["password"])." ".$this->_language['minimum_character']." ".$condition["conditionValue"];
                            }
                            if(!$this->maxLength($condition["fieldValue"], $condition['conditionMaxValue']) && ($condition['conditionMaxValue'] != null )){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($this->_language["password"])." ".$this->_language['maximum_character']." ".$condition["conditionValue"];
                            }
                            if(!$this->checkRegex($condition["fieldValue"], "/^[\w]+$/")){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_language['format']." ".\ucfirst($this->_language["password"])." ".$this->_language['not_match'];
                            }
                            if(!preg_match('/[a-z]+/', $condition["fieldValue"]) || !preg_match('/[0-9]+/', $condition["fieldValue"])){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_language['format']." ".\ucfirst($this->_language["password"])." ".$this->_language['must_element'];
                            }
                            break;
                        case "email":
                            if(!filter_var($condition["fieldValue"],FILTER_VALIDATE_EMAIL)){
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = $this->_language['format']." ".\ucfirst($condition["fieldName"])." ".$this->_language['not_match']." ".$this->_language['ex_email'];
                            }
                            break;
                        default:
                            $this->_valid = false;
                            $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["subType"])." ".$this->_language['not_defined'];
                    }
                    break;
                case "value":
                    switch (strtolower($condition["subType"])) {
                        case "equal":
                            if (strtoupper($condition["fieldValue"]) !== strtoupper($condition["conditionValue"])) {
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"]) . " ".$this->_language['must_same'];
                            }
                            break;
                        case "equallengthdigitbank":
                            if (strlen($condition["fieldValue"]) <= $condition["conditionValue"]) {
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($this->_language['bank_account_no'])." ". $this->_language["contain"]." ".$condition["conditionValue"]." ". $this->_language["digit"];
                            }
                            break;
                        case "betweenbank":
                            if (strlen($condition["fieldValue"]) <= $condition["conditionValue"] &&
                                strlen($condition["fieldValue"]) >= $condition['conditionMaxValue'] ) {
//                                echo "length = ".strlen($condition["fieldValue"])." min value = ".$condition["conditionValue"]." max value = ".$condition['conditionMaxValue'];
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($this->_language['bank_account_no'])." ". $this->_language["contain"]." ".$condition["conditionValue"]." ". $this->_language["digit"];
                            }
                            break;
                        case "notequal":
                            if (strtoupper($condition["fieldValue"]) == strtoupper($condition["conditionValue"])) {
                                $this->_valid = false;
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"]) . " ".$this->_language['must_not_same'];
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
                                $this->_messages[$condition["fieldName"]][] = \ucfirst($condition["fieldName"])." ".$this->_language['less_than']." ".$condition["conditionValue"];
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
                        default:
                            $this->_valid = false;
                            $this->_messages[$condition["fieldName"]][] = $condition["subType"]." ".$this->_language['not_defined'];
                    }
                    break;

                default:
                    $this->_valid = false;
                    $this->_messages[$condition["fieldName"]][] = $condition["type"]." ".$this->_language['not_defined'];
            }
        }

        return array(
            "valid" => $this->_valid,
            "messages" => $this->_messages
        );
    }
}
