<?php

use \Phalcon\Di\FactoryDefault;
use \Phalcon\Mvc\View;
use \Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use \Phalcon\Session\Adapter\Files as SessionAdapter;
use \Phalcon\Http\Response\Cookies;
use \Phalcon\Flash\Session as Flash;
use \Phalcon\Mvc\Model\Manager as ModelManager;
use \Phalcon\Mvc\Dispatcher as Dispatcher;
use System\Library\Security\AccessControlList;


/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * set config
 */
$di->setShared('config', function () use ($config) {
    return $config;
});

$di->set('modelsManager', function () {
    return new ModelManager();
});

$di->set('flash', function () {
    return new Flash();
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () use ($config) {
    $dbConfig = $config->database->toArray();
    $adapter = $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

    return new $class($dbConfig);
});

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
 * Registering a router
 */
$di['router'] = function () {
    return require __DIR__ . '/routes.php';
};

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir.$config->template."/");

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_',
                'compileAlways' => true
//                'compileAlways' => ($config->environment == 'development') ? true : false
            ));

            $compiler = $volt->getCompiler();

            $compiler->addFunction('widget', function ($resolvedArgs) {
                return 'System\Widgets\Manager::get(' . $resolvedArgs . ')->getContent()';
            });

            $compiler->addFilter('agentType', function ($resolvedArgs) {
                return 'Volt\Libraries\Agent::agentType(' . $resolvedArgs . ')';
            });

            $compiler->addFilter('currencyName', function ($resolvedArgs) {
                return 'Volt\Libraries\Currency::currencyName(' . $resolvedArgs . ')';
            });

            $compiler->addFilter('agentStatus', function ($resolvedArgs) {
                return 'Volt\Libraries\Agent::agentStatus(' . $resolvedArgs . ')';
            });

            $compiler->addFilter('gameStatus', function ($resolvedArgs) {
                return 'Volt\Libraries\Game::gameStatus(' . $resolvedArgs . ')';
            });

            $compiler->addFilter('date', function ($resolvedArgs) {
                return 'Volt\Libraries\Format::date(' . $resolvedArgs . ')';
            });

            $compiler->addFilter('gameName', function ($resolvedArgs) {
                return 'Volt\Libraries\Game::gameName(' . $resolvedArgs . ')';
            });

            $compiler->addFilter('gameType', function ($resolvedArgs) {
                return 'Volt\Libraries\Game::gameType(' . $resolvedArgs . ')';
            });

            $compiler->addFilter('endPointType', function ($resolvedArgs) {
                return 'Volt\Libraries\Endpoint::endPointType(' . $resolvedArgs . ')';
            });

            $compiler->addFilter('endPointAuth', function ($resolvedArgs) {
                return 'Volt\Libraries\Endpoint::endPointAuth(' . $resolvedArgs . ')';
            });

            $compiler->addFilter('providerName', function ($resolvedArgs) {
                return 'Volt\Libraries\Game::gameProvider(' . $resolvedArgs . ')';
            });

//            $compiler->addFilter('currencyCode', function ($resolvedArgs) {
//                return 'Volt\Libraries\Currency::CurrencyCode(' . $resolvedArgs . ')';
//            });
//
//            $compiler->addFilter('currencyName', function ($resolvedArgs) {
//                return 'Volt\Libraries\Currency::CurrencyName(' . $resolvedArgs . ')';
//            });
//
//            $compiler->addFilter('currencySymbol', function ($resolvedArgs) {
//                return 'Volt\Libraries\Currency::CurrencySymbol(' . $resolvedArgs . ')';
//            });

            return $volt;
        }
    ));

    $view->setLayout('core');
    $view->setLayoutsDir('layouts/');

    return $view;
});


/**
 * new setting dispatcher
 */
$di->set('dispatcher', function () use ($di) {
    $evManager = $di->getShared('eventsManager');

    $evManager->attach('dispatch:beforeExecuteRoute', new AccessControlList());

    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Backoffice\Controllers');
    $dispatcher->setEventsManager($evManager);

    return $dispatcher;
}, true);


/**
 * setting CURL
 */
$di->set('curl', function () {
    $curl = ClientRequest::getProvider();
    $curl->setConnectTimeout(5);
    $curl->setTimeout(6);
    return $curl;
});

$di->set('cookies', function () {
    $cookies = new Cookies();
    $cookies->useEncryption(false);
    return $cookies;
}, true);

