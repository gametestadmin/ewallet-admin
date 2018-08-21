<?php

error_reporting(E_ALL);

define('APP_PATH', realpath('..'));

try {
    /**
     * Read the configuration
     */
    $config = include APP_PATH . "/app/config/config.php";

    /**
     * Read auto-loader
     */
    include APP_PATH . "/app/config/loader.php";

    /**
     * Read services
     */
    include APP_PATH . "/app/config/services.php";

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    /**
     * Include modules
     */
    require __DIR__ . '/../app/config/modules.php';

    echo $application->handle()->getContent();
} catch (\Exception $e) {
    //redirect to 500 error
//    header("Location: /500");
    echo "<pre>";
    var_dump($e->getMessage());
    die;
}
