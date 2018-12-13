<?php
namespace Volt\Libraries;

class Format
{
    public static function currency($amount)
    {
        return "IDR" . number_format($amount, 0, ',', '.');
    }

    public static function number($amount)
    {
        return number_format($amount, 0, '.', ',');
    }

    public static function number2dec($amount)
    {
        return number_format($amount, 2, '.', ',');
    }

    public static function percentage($amount)
    {
        $amount = $amount*100;

        return $amount.' %';
    }

    public static function date($data)
    {
        if(!isset($data["date"])){
            return date($data["format"]);
        }else {
            if(!isset($data["int"])) {
                return date($data["format"], strtotime($data["date"]));
            }else{
                return date($data["format"], (int)$data["date"]);
            }
        }
    }
    public static function dateFormat($data)
    {
        $data = date("d-m-Y");
        return $data;
    }

    public static function subStr($text)
    {
        if(substr($text,0,4) == "http"){
            $true = 1;
        }else{
            $true = 0;
        }
        return $true;
    }

    public static function explTube($text)
    {
        $text = explode("/embed/", $text);
        return $text[1];
    }
}
