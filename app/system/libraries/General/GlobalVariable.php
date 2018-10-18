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
        'User Information' => 3,
        'User Balance' => 4,
        '(Transfer) Transaction In' => 5,
        '(Transfer) Transaction Out' => 6,
        '(Transfer) Transaction Status' => 7,
        '(Transfer) Transaction History' => 8,
        '(Transfer) Transaction Daily' => 9,
        '(Transfer) Game Record' => 10,
        '(Seamless) Transaction Bet' => 11,
        '(Seamless) Transaction History' => 12,
        '(Seamless) Transaction Daily' => 13,
        '(Seamless) Game Record' => 14,
        'Statement Daily' => 15,
        'Statement Detail' => 16,
    );

    public static $providerGameEndpointTypes = array(
        1 => "Login",
        2 => 'Register',
        3 => 'User Information',
        4 => 'User Balance',
        5 => '(Transfer) Transaction In',
        6 => '(Transfer) Transaction Out',
        7 => '(Transfer) Transaction Status',
        8 => '(Transfer) Transaction History',
        9 => '(Transfer) Transaction Daily',
        10 => '(Transfer) Game Record',
        11 => '(Seamless) Transaction Bet',
        12 => '(Seamless) Transaction History',
        13 => '(Seamless) Transaction Daily',
        14 => '(Seamless) Game Record',
        15 => 'Statement Daily',
        16 => 'Statement Detail',
    );

    public static $agentType = array(
        'God' => 0,
        'Company' => 9,
        'Super Senior Master Agent' => 8,
        'Senior Master Agent' => 7,
        'Master Agent' => 6,
        'Agent' => 5,
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

    public function getGmt()
    {
        $i = -12;
        $gmt = array();
        while ($i <= 14){
            $gmt[$i] = $i;
            $i++;
        }

        return $gmt;
    }
}
