<?php

/**
 * core config for basic config needed for general apps in restfull
 * @return \Phalcon\Config
 * @package \
 */

if (!defined("INDEXDIR")) {
    define("INDEXDIR", __DIR__ . '/../..');
}

$di['app'] = function () {
    require_once INDEXDIR . '/../config/loader.php';
};

$masterConfig = include __DIR__ . "/../../../config/config.php";

$config = new \Phalcon\Config([

]);

$config = (object)array_merge((array)$masterConfig, (array)$config);

return $config;