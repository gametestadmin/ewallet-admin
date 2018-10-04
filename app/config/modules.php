<?php

$application->registerModules(array(
    'user' => array(
        'className' => 'Backoffice\User\Module',
        'path' => __DIR__ . '/../modules/user/Module.php'
    ),
    'subaccount' => array(
        'className' => 'Backoffice\Subaccount\Module',
        'path' => __DIR__ . '/../modules/subaccount/Module.php'
    ),
    'setting' => array(
        'className' => 'Backoffice\Setting\Module',
        'path' => __DIR__ . '/../modules/setting/Module.php'
    ),
    'game' => array(
        'className' => 'Backoffice\Game\Module',
        'path' => __DIR__ . '/../modules/game/Module.php'
    ),
    'agent' => array(
        'className' => 'Backoffice\Agent\Module',
        'path' => __DIR__ . '/../modules/agent/Module.php'
    ),
    'ajax' => array(
        'className' => 'Backoffice\Ajax\Module',
        'path' => __DIR__ . '/../modules/ajax/Module.php'
    ),
));
