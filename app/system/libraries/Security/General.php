<?php

namespace System\Libraries\Security;

class General
{
    public static function getIP() {
        if(isset($_SERVER['HTTP_CF_CONNECTING_IP']))
            $ip = strip_tags(addslashes($_SERVER['HTTP_CF_CONNECTING_IP']));
        if (\getenv("HTTP_CLIENT_IP") && \strcasecmp(\getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (\getenv("HTTP_X_FORWARDED_FOR") && \strcasecmp(\getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = \getenv("HTTP_X_FORWARDED_FOR");
        else if (\getenv("REMOTE_ADDR") && \strcasecmp(\getenv("REMOTE_ADDR"), "unknown"))
            $ip = \getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && \strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";

        return $ip;
    }

    public static function getBrowser() {
        $browser = 'web';
        if(isset($_SERVER['HTTP_REFERER'])) {
            if (strstr($_SERVER['HTTP_REFERER'], 'mobile') || strstr($_SERVER['HTTP_HOST'], 'mobile')) {
                if (preg_match('/(android)/i', $_SERVER['HTTP_USER_AGENT'])) {
                    $browser = 'android';
                }
                if (preg_match('/(iphone|ipad|ipaq|ipod)/i', $_SERVER['HTTP_USER_AGENT'])) {
                    $browser = 'ios';
                }
            }
        }
        return $browser;
    }
}