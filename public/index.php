<?php

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

$eventsManager = new Phalcon\Events\Manager();

$application->setEventsManager($eventsManager);

$eventsManager->attach('application:viewRender', function($event, $application) {
	$dispatcher = $application->getDI()->getDispatcher();
	$controllerName = strtolower($dispatcher->getControllerName());
	if (substr($controllerName, 0, 1) == '\\') {
		$dispatcher->setControllerName(substr($controllerName, 1));
	}
});

/**
 * Assign the DI
 */
$application->setDI($di);

/**
 * Include modules
 */
require __DIR__ . '/../config/modules.php';

echo $application->handle()->getContent();
