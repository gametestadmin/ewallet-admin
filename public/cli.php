<?php

use Phalcon\DI\FactoryDefault\CLI as CliDI,
    Phalcon\CLI\Console as ConsoleApp;
use Phalcon\Mvc\Collection\Manager as CollectionManager;

error_reporting(E_ALL & ~E_NOTICE);
//error_reporting(E_ALL);

define('VERSION', '1.0.0');

// Using the CLI factory default services container
$di = new CliDI();

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)));

// Load the configuration file (if any)
if (is_readable(APPLICATION_PATH . '/../app/config/config.php')) {
    $config = include APPLICATION_PATH . '/../app/config/config.php';
    $di->set('config', $config);
}

/**
 * Register the autoloader and tell it to register the tasks directory
 */
$loader = new \Phalcon\Loader();

$namespaces = array(
    'Backoffice\Controllers' => __DIR__ . '/../controllers/',
    'System\Language' => __DIR__ . '/../system/language/',
    'System\Library' => __DIR__ . '/../system/libraries/',
    'System\Model' => __DIR__ . '/../system/models/',
    'System\Datalayer' => __DIR__ . '/../system/datalayer/'.$config->dbenvironment."/" ,
    'System\Datalayers' => __DIR__ . '/../system/datalayer/' ,
    'System\Widgets' => __DIR__ . '/../system/libraries/Widget',
    'Volt\Libraries' => __DIR__ . '/../system/libraries/Volt',
    'General\Libraries' => __DIR__ . '/../system/libraries/General',
);

$loader->registerNamespaces($namespaces)->register();

$loader->registerDirs(
    array(
        APPLICATION_PATH . '/../app/system/tasks'
    )
)->register();

$di->set('collectionManager', function () {
    // Setting a default EventsManager
    $modelsManager = new CollectionManager();
    return $modelsManager;
}, true);

// Create a console application
$console = new ConsoleApp();
$console->setDI($di);

////Setup the master database service
//$di->set('db', function(){
//    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
//        "host" => "localhost",
//        "username" => "root",
//        "password" => "root",
//        "dbname" => "temp_games",
//        'options' => [PDO::ATTR_CASE => PDO::CASE_LOWER, PDO::ATTR_PERSISTENT => TRUE,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC],
//    ));
//});
/**
 * Database connection for postgresql
 */
$di->setShared('postgre', function () use ($config) {
    $dbConfig = $config->postgre_db->toArray();
    $adapter = $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

    return new $class($dbConfig);
});


/**
 * Process the console arguments
 */
$arguments = array();
foreach ($argv as $k => $arg) {
    if ($k == 1) {
        $arguments['task'] = $arg;
    } elseif ($k == 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

// Define global constants for the current task and action
define('CURRENT_TASK',   (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
    exit(255);
}