<?php
namespace System\Datalayer;

use System\Datalayers\Main;

class DLUserAuth extends Main{
    // DSS
    public function create($user){

        $app_id = md5("app_id".strtotime("now").$user['id'].$user['un']);
        $app_secret =  md5("app_secret".$user['id'].$user['un'].strtotime("now"));

        $date = "3000-01-01 00:00:00";

        $postData = array(
            "idus" => $user['id'],
            "apid" => $app_id,
            "apsc" => $app_secret,
            "vu" => $date,
            "st" => 1,
        );
        $url = '/userauth/insert';
        $this->curlAppsJson($url,$postData);

        return true;
    }
    // END DSS
}