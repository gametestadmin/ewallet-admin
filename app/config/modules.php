<?php

$application->registerModules(array(
    'user' => array(
        'className' => 'Backoffice\User\Module',
        'path' => __DIR__ . '/../modules/user/Module.php'
    ),
    'player' => array(
        'className' => 'Backoffice\Player\Module',
        'path' => __DIR__ . '/../modules/player/Module.php'
    ),
    'report' => array(
        'className' => 'Backoffice\Report\Module',
        'path' => __DIR__ . '/../modules/report/Module.php'
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
    'provider' => array(
        'className' => 'Backoffice\Provider\Module',
        'path' => __DIR__ . '/../modules/provider/Module.php'
    ),
    'downline' => array(
        'className' => 'Backoffice\Downline\Module',
        'path' => __DIR__ . '/../modules/downline/Module.php'
    ),
));

