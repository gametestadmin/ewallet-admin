<?php
namespace System\Library\General;

class GlobalVariable
{
    // TODO :: change to below
    public static $threeLayerStatus = array(
        'InActive' => 0,
        'Active' => 1,
        'Suspended' => 2,
    );

    public static $threeLayerStatusTypes = array(
        0 => "inactive",
        1 => "active",
        2 => "suspended",
    );

    public static $twoLayerStatusTypes = array(
        0 => "inactive",
        1 => "active",
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

//    public static $newProviderGameEndpointTypes = array(
//        101 => "Login",
//        102 => 'Register',
//        103 => 'User Information',
//        104 => 'User Balance',
//        105 => '(Transfer) Transaction In',
//        106 => '(Transfer) Transaction Out',
//        107 => '(Transfer) Transaction Status',
//        108 => '(Transfer) Transaction History',
//        109 => '(Transfer) Transaction Daily',
//        110 => '(Transfer) Game Record',
//        201 => '(Seamless) Transaction Buy In',
//        202 => '(Seamless) Transaction Stand Up',
//        203 => '(Seamless) Transaction Bet',
//        204 => '(Seamless) Transaction History',
//        205 => '(Seamless) Transaction Daily',
//        206 => '(Seamless) Game Record',
//        111 => 'Statement Daily',
//        112 => 'Statement Detail',
//    );

    public static $transferProviderGameEndpointTypes = array(
        101 => "Login",
        102 => 'Register',
        103 => 'User Information',
        104 => 'User Balance',
        105 => 'Transaction In',
        106 => 'Transaction Out',
        108 => 'Transaction Status',
        109 => 'Transaction History',
        110 => 'Transaction Daily',
        111 => 'Game Record',
        112 => 'Statement Daily',
        113 => 'Statement Detail',
    );

    public static $seamlessProviderGameEndpointTypes = array(
        201 => "Login",
        202 => 'Register',
        203 => 'User Information',
        204 => 'User Balance',
        205 => 'Transaction Buy In',
        206 => 'Transaction Stand Up',
        207 => 'Transaction Bet',
        208 => 'Transaction Status',
        209 => 'Transaction History',
        210 => 'Transaction Daily',
        211 => 'Game Record',
        212 => 'Statement Daily',
        213 => 'Statement Detail',
    );

    public static $agentType = array(
        0 => 'god',
        9 => 'company',
        8 => 'super_senior_master_agent',
        7 => 'senior_master_agent',
        6 => 'master_agent',
        5 => 'agent',
    );

    public function gameType($data){
        $gameType = "";
        if($data == 1){
            $gameType = "Category Game";
        }elseif($data == 2){
            $gameType = "Game";
        }elseif($data == 3){
            $gameType = "Sub-Game";
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
