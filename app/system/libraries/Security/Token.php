<?php
namespace System\Libraries\Security;

use System\Models\PokerUsers;
use System\Models\Website;
use System\Models\WebsiteUser;

class Token extends \System\Libraries\Main
{
    // getToken need $data['user'] in User_id or Id
    public function getToken($data){
        $token = null;

        $user = $data["user"];
        if($user) {
            $website = Website::findFirstById($this->_config->website->id);
            if (!$website) {
                $url = "/";

                return $url;
            }
            $websiteUser = WebsiteUser::findFirst(
                array(
                    "conditions" => "website = :website: AND user = :user:",
                    "bind" => array(
                        'website' => $this->_config->website->id,
                        'user' => $user
                    )
                )
            );

            $generalSecurity = new General();
            $date = \date("Y-m-d H:i:s", \strtotime('+3 hours'));

            $token = \bin2hex(\openssl_random_pseudo_bytes(32));
            //check if token exist or not
            while ($check = WebsiteUser::findFirstByToken($token)) {
                $token = \bin2hex(\openssl_random_pseudo_bytes(32));
            }
            if (!$websiteUser) {
                $websiteUser = new WebsiteUser();
                $websiteUser->setUser($user);
                $websiteUser->setWebsite($this->_config->website->id);
                $websiteUser->setToken($token);
                $websiteUser->setTokenValidUntil($date);
                $websiteUser->setIp($generalSecurity->getIP());
                $websiteUser->setAuth(json_encode(array("public_profile", "email", "user_friends")));
                $websiteUser->setStatus(1);

                $websiteUser->save();
//            } else if (strtotime($websiteUser->getTokenValidUntil()) < strtotime(date("d-m-Y H:i:s"))) {
            } else {
                $websiteUser->setToken($token);
                $websiteUser->setTokenValidUntil($date);
                $websiteUser->setIp($generalSecurity->getIP());
                $websiteUser->setStatus(1);

                $websiteUser->save();
            }
        }
        return $token;
    }

    // checkToken need $data['user'] in User_id or Id & $data['token']
    public function checkToken($data)
    {
        $websiteUser = false;

        $user = $data['user'];
        if($user) {
            $websiteUser = WebsiteUser::findFirst(
                array(
                    "conditions" => "website = :website: AND user = :user: AND token=:token: AND token_valid_until >= :time:",
                    "bind" => array(
                        'website' => $this->_config->website->id,
                        'user' => $user,
                        'token' => $data['token'],
                        'time' => date('Y-m-d H:i:s' , time())
                    )
                )
            );
            if ($websiteUser && $websiteUser->getToken() == $data["token"]) {
                $generalSecurity = new General();
                $date = date("Y-m-d H:i:s", strtotime('+3 hours'));
                $websiteUser->setTokenValidUntil($date);
                $websiteUser->setIp($generalSecurity->getIP());
                $websiteUser->setStatus(1);

                $websiteUser->save();
            }
        }
        if($websiteUser == false){
            throw new \Exception('invalid_token');
        }
        return $websiteUser;

    }

}