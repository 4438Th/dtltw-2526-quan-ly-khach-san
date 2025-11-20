<?php
define('CONFIGS_PATH', ROOT_PATH . '/configs');
define('SRC_PATH', ROOT_PATH . '/src');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('ASSETS_PATH', PUBLIC_PATH . '/assets');
define('CORE_PATH', SRC_PATH . '/Core');
define('MODULES_PATH', SRC_PATH . '/Modules');
define('SHARE_PATH', SRC_PATH . '/Share');

$route = [
    'defaultModule' => 'HomeModule',
    'defaultController' => 'HomeController',
    'defaultAction' => 'index',
    'defaultParams' => []
];
