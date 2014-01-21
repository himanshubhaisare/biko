<?php

//$_GET['_url'] = '/admin/session/login';
//$_SERVER['REQUEST_METHOD'] = 'POST';

//$_POST['login'] = 'admin';
//$_POST['password'] = 'secret';

use Phalcon\Mvc\Application;

if (empty($_GET['_url'])) {
	$_GET['_url'] = '/index';
}

error_reporting(E_ALL);

$debug = new Phalcon\Debug();
$debug->listen();

/**
 * Include services
 */
require __DIR__ . '/../config/services.php';

/**
 * Include loaders
 */
require __DIR__ . '/../config/loader.php';

/**
 * Handle the request
 */
$application = new Application();

/**
 * Assign the DI
 */
$application->setDI($di);

/**
 * Include modules
 */
require __DIR__ . '/../config/modules.php';

echo $application->handle()->getContent();
