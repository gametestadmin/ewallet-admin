<?php
/**
 * Created by PhpStorm.
 * User: Paladise
 * Date: 15-Aug-18
 * Time: 2:58 PM
 */
$application->registerModules(array(
    'user' => array(
        'className' => 'Backoffice\User\Module',
        'path' => __DIR__ . '/../modules/user/Module.php'
    ),
));
