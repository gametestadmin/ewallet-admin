<?php
namespace System\Library\General;

class GlobalVariable
{
    public static $threeLayerStatus = array(
        'InActive' => 0,
        'Active' => 1,
        'Suspended' => 2,
    );

    public static $twoLayerStatus = array(
        'InActive' => 0,
        'Active' => 1,
    );

    public static $httpList = array(
        'http://' => 0,
        'https://' => 1,
    );

    public static $providerGameEndpointType = array(
        'Login' => 1,
        'Register' => 2,
        'Transfer In' => 3,
        'Transfer Out' => 4,
        'Transfer History' => 5,
        'User Balance' => 6,
        'Game Record Transfer' => 7,
        'Game Record Seamless' => 8,
        'Game Record Daily Transfer' => 9,
        'Game Record Daily Seamless' => 10,
    );

    public function gameType($data){
        $gameType = "";
        if($data == 1){
            $gameType = "Game Category";
        }elseif($data == 2){
            $gameType = "Main Game";
        }elseif($data == 3){
            $gameType = "Sub Game";
        }

        return $gameType;
    }

    public function previousPage()
    {
        $previous = "javascript:history.go(-1)";
        if(isset($_SERVER['HTTP_REFERER'])) {
            $previous = $_SERVER['HTTP_REFERER'];
        }

        return $previous;
    }
}
