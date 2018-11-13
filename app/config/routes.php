<?php

use Phalcon\Mvc\Router;

$requestUri = $_SERVER['REQUEST_URI'];
$explodeRequestURI = explode('?', $requestUri);
$baseRequestURI = $explodeRequestURI[0];
$queryString = isset($explodeRequestURI[1]) ? $explodeRequestURI[1] : NULL;

$routes = array(
    array(
        'url' => '/',
        'params' => array(
            'controller' => 'index',
            'action' => 'index'
        )
    ),

    array(
        'url' => '/:module',
        'params' => array(
            'module' => 1,
            'controller' => 'index',
            'action' => 'index'
        )
    ),
    array(
        'url' => '/:module/:controller',
        'params' => array(
            'module' => 1,
            'controller' => 2,
            'action' => 'index'
        )
    ),
    array(
        'url' => '/:module/:controller/:action',
        'params' => array(
            'module' => 1,
            'controller' => 2,
            'action' => 3
        )
    ),
    array(
        'url' => '/(login|LOGIN)',
        'params' => array(
            'controller' => 'index',
            'action' => 'login'
        )
    ),
    array(
        'url' => '/(logout|LOGOUT)',
        'params' => array(
            'controller' => 'index',
            'action' => 'logout'
        )
    ),
//    array(
//        'url' => '/(login|LOGIN)',
//        'params' => array(
//            'module' => 'user',
//            'controller' => 'login',
//            'action' => 'login'
//        )
//    ),
//    array(
//        'url' => '/(logout|LOGOUT)',
//        'params' => array(
//            'module' => 'user',
//            'controller' => 'login',
//            'action' => 'logout'
//        )
//    ),
    array(
        'url' => '/(captcha|CAPTCHA)',
        'params' => array(
            'controller' => 'captcha',
            'action' => 'index'
        )
    ),

//    array(
//        'url' => '/(currency|moduletwo)/:controller/([\w]{3})',
//        'params' => array(
//            'module' => 1,
//            'controller' => 2,
//            'action' => 'index',
//            'code' => 3
//        )
//    ),

// currency status
// USD|0
    array(
        'url' => '/(setting)/(currency)/:action/([\w|]{5})',
        'params' => array(
            'module' => 1,
            'controller' => 2,
            'action' => 3,
            'id' => 4
        )
    ),

    array(
        'url' => '/:module/:controller/:action/([a-zA-Z0-9-]+)',
        'params' => array(
            'module' => 1,
            'controller' => 2,
            'action' => 3,
            'id' => 4
        )
    ),

    array(
        'url' => '/:module/:controller/:action/([0-9|]+)',
        'params' => array(
            'module' => 1,
            'controller' => 2,
            'action' => 3,
            'id' => 4
        )
    ),

//    array(
//        'url' => '/agent',
//        'params' => array(
//            'module' => 'agent',
//            'controller' => 'index',
//            'action' => 'index'
//        )
//    ),

    array(
        'url' => '/agent/(detail|edit|status)/([a-zA-Z0-9|]+)',
        'params' => array(
            'module' => 'agent',
            'controller' => 1,
            'action' => 'index',
            'id' => 2
        )
    ),

    array(
        'url' => '/provider/(detail|edit|status)/([a-zA-Z0-9|]+)',
        'params' => array(
            'module' => 'provider',
            'controller' => 1,
            'action' => 'index',
            'id' => 2
        )
    ),

    array(
        'url' => '/agent',
        'params' => array(
            'module' => 'agent',
            'controller' => 'index',
        )
    ),

    array(
        'url' => '/language',
        'params' => array(
            'controller' => 'index',
            'action' => 'language'
        )
    ),
);

$router = new Router();
$router->removeExtraSlashes(true);
// $router->setDefaultController('index')->setDefaultAction('index');

foreach ($routes as $route) {
    $router->add($route['url'], $route['params'])->setName(implode('_', $route['params']));
    $router->handle();
}

$route = $router->getMatchedRoute();
if ($route && $route->getRouteId() > 1) {
    return $router;
}

$cleanRequestURI = substr($baseRequestURI, 1);

if ($cleanRequestURI == '') {
    return $router;
}

$router->notFound(array(
    "controller" => "index",
    "action" => "error404"
));
$router->handle();

return $router;