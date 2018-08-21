<?php

$loader = new \Phalcon\Loader();

$namespaces = array(
    'Backoffice\Controllers' => __DIR__ . '/../controllers/',
    'System\Language' => __DIR__ . '/../system/language/',
    'System\Library' => __DIR__ . '/../system/libraries/',
    'System\Models' => __DIR__ . '/../system/models/',
//    'Security\Libraries' => __DIR__ . '/../libraries/Security',
//    'Log\Libraries' => __DIR__ . '/../libraries/Log',
//    'Tangkas\Libraries' => __DIR__ . '/../libraries/Tangkas',
//    'Language\Libraries' => __DIR__ . '/../libraries/Language',
//    'Plugins\Libraries' => __DIR__ . '/../libraries/Plugins',
//    'Volt\Libraries' => __DIR__ . '/../libraries/Volt',
//    'Frontend\Libraries' => __DIR__ . '/../libraries/Frontend',
//    'Frontend\Widgets' => __DIR__ . '/../libraries/Widgets/',
//    'System\Libraries\Language' => __DIR__ . '/../libraries/Language',
//    'System\Libraries' => __DIR__ . '/../system/libraries/',
//    'System\Models' => __DIR__ . '/../system/models/',
//    'Frontend\Models' => __DIR__ . '/../models/',
);

$loader->registerNamespaces($namespaces)->register();