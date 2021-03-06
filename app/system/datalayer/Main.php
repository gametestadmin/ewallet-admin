<?php
namespace System\Datalayers;

//use \Phalcon\Session\Adapter\Files as SessionAdapter;
use \Phalcon\Http\Request ;
use System\Language\Language;

class Main
{
    public $_config = null;
    public $_lang = null;
    public $_server = null;

    public function __construct()
    {
        $request = new Request();
        $this->_config = require __DIR__ . '/../../config/config.php';
        $this->_language = Language::getTranslation();
        $this->_server = $request->getServer("HTTP_HOST");
    }

    public function curlAppsJson($url, $data){
        // Setup cURL
        $ch = curl_init($this->_config->dss->url.$url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
//            CURLOPT_PORT => "9090",
//            CURLOPT_ENCODING => "" ,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_POSTFIELDS => json_encode($data),
        ));

        // Send the request
        $result = json_decode(curl_exec($ch),true);
        $response = new \Phalcon\Config($result);

        return $response;
    }

    public function curlConditions( $op , $field , $value){
            $data['op'] = $op ;
            $data['field'] = $field ;
            $data['val'] = $value ;
        return $data ;
    }

    public function curlOrders( $op , $field){
        $data['op'] = $op ;
        $data['field'] = $field ;
        return $data ;
    }

}