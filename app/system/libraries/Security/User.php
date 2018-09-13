<?php

namespace System\Library\Security;


class User
{
    public $_config;
    public $_siteIVSettings;
    public $_siteKeySettings;

    public function __construct()
    {
        $this->_config = include __DIR__.'/../../../config/config.php';

//        $this->_siteIVSettings = GlobalVariable::getWebsiteSetting('site_iv');
//        $this->_siteKeySettings = GlobalVariable::getWebsiteSetting('site_key');
        $this->_siteIVSettings = $this->_config->security->site_iv;
        $this->_siteKeySettings = $this->_config->security->site_key;

    }


    public function enc_str($string)
    {
//        $crypText = \mcrypt_encrypt(MCRYPT_SAFERPLUS, $this->_siteKeySettings, $string, MCRYPT_MODE_ECB, $this->_siteIVSettings);
        $crypText = \openssl_encrypt($string, 'AES-128-CBC', $this->_siteKeySettings, OPENSSL_RAW_DATA, $this->_siteIVSettings);

        return $crypText;
    }

    public function dec_str($key,$string)
    {
//        $decrypText = \mcrypt_decrypt(MCRYPT_SAFERPLUS, $this->_siteKeySettings, $string, MCRYPT_MODE_ECB, $this->_siteIVSettings);
        $decrypText = \openssl_decrypt($string, 'AES-128-CBC', $this->_siteKeySettings, OPENSSL_RAW_DATA, $this->_siteIVSettings);

        return $decrypText;
    }

    public function log_user($log_code, $userIP, $referrer, $browser, $browserID, $time, $log_value1, $log_name2, $log_value2)
    {
        $log = new PokerLogs();
        $log->setLogCode(addslashes($log_code));
        $log->setLogName1(addslashes('username'));
        $log->setLogValue1(addslashes($log_value1));
        $log->setLogName2(addslashes($log_name2));
        $log->setLogValue2(strip_tags(addslashes($log_value2)));
        $log->setLogName3('');
        $log->setLogValue3('');
        $log->setLogTime($time);
        $log->setLogIp($userIP);
        $log->setLogDetail($referrer.", ".$browser);
        $log->setLogUnique($browserID);
        $log->save();

    }

    public function checkUserExist($user){
        $pokerUsers = PokerUsers::findFirstByUsername($user);
        if($pokerUsers == false){
            throw new \Exception('username_not_exist');
        }
        return $pokerUsers->getUserId();
    }

    public function checkUserIsValid($requestData){
        $user = PokerUsers::findFirstByUsername($requestData["username"]);

        $data = array(
            "user" => $user->getUserId(),
            "token" => $requestData["token"]
        );

        $token = new Token();
        return $token->checkToken($data);
    }
}