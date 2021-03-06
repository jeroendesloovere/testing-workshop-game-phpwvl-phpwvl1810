<?php

if (file_exists(__DIR__ . '/../application/configs/env.php')) {
    require_once __DIR__ . '/../application/configs/env.php';
}

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../vendor/phpunit/phpunit/src'),
)));

require_once APPLICATION_PATH . '/../vendor/autoload.php';

// Set the default timezone !!!
date_default_timezone_set('Europe/Brussels');

// We wanna catch all errors en strict warnings
error_reporting(E_ALL|E_STRICT);

ob_start();

require_once 'Zend/Application.php';
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap();