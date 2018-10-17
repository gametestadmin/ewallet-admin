<?php
namespace Volt\Libraries;

class Currency
{
    public static function currencyName($id)
    {
        $currency = \System\Model\Currency::findFirstById($id);
        $name = $currency->getName();

        return $name;
    }
}
