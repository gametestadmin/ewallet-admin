<?php
/**
 * Created by PhpStorm.
 * User: Paladise
 * Date: 15-Aug-18
 * Time: 1:11 PM
 */

defined('APP_PATH') || define('APP_PATH', realpath('.'));

$config_apps = array(
    'environment' => "development",               //TODO :: development | production
    'version' => '1.0.0',
    'url' => array(
        'base' => 'http://develop.admin/',
        'assets' => 'http://develop.admin/assets/',
        'media' => 'http://develop.admin/media/'
    ),
    'template' => 'admin',
    'language' => array(
        'id' => array(
            "code" => "id",
            "name" => "Indonesia",
            "status" => true,
            'default' => false
        ),
        'en' => array(
            "code" => "en",
            "name" => "English",
            "status" => true,
            'default' => true
        ),
        'cn' => array(
            "code" => "cn",
            "name" => "China",
            "status" => true,
            'default' => false
        )
    ),
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'bo',
        'charset'     => 'utf8',
    )
);


return $config_apps;