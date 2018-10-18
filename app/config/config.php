<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

$config_app = (include 'config_app.php');

$config = array(
    'version' => '1.0.0',
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'migrationsDir'  => APP_PATH . '/app/migrations/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'cacheDir'       => APP_PATH . '/var/cache/',
        'baseUri'        => '/',
    )
);

$config = array_merge($config, $config_app);

return new \Phalcon\Config($config);