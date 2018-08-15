<?php

namespace System\Language;

use Phalcon\Translate\Adapter\NativeArray;

class Language
{
    public $_lang;

    public function __construct()
    {
        $this->_lang = "";
    }

    public static function getTranslation($language = null)
    {
        $config = include __DIR__.'/../../config/config.php';

        if (is_null($language) || !file_exists(__DIR__. "/" . $language . ".php")) {
            $records = $config->language;

            $language = "en";
            foreach($records as $record){
                if($record["status"]){
                    if($record["default"]) $language = $record["code"];
                }
            }
        }

        $messages = array();
        require __DIR__ . "/".$language.".php";

        // Return a translation object
        return new NativeArray(
            array(
                "content" => $messages
            )
        );
    }
}
