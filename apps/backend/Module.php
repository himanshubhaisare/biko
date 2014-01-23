<?php

namespace Biko\Backend;

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Events\Manager as EventsManager;

class Module implements ModuleDefinitionInterface
{

	/**
	 * Registers the module auto-loader
	 */
	public function registerAutoloaders()
	{

	}

	/**
	 * Registers the module-only services
	 *
	 * @param Phalcon\DI $di
	 */
	public function registerServices($di)
	{

		/**
		 * Read configuration
		 */
		$config = include __DIR__ . "/config/config.php";

		$di['view']->setViewsDir(__DIR__ . '/views/');

		/**
		 * Database connection is created based in the parameters defined in the configuration file
		 */
		$di['db'] = function () use ($config) {

			$connection = new DbAdapter(array(
				"host"     => $config->database->host,
				"username" => $config->database->username,
				"password" => $config->database->password,
				"dbname"   => $config->database->dbname
			));

			$eventsManager = new EventsManager();

			$logger = new FileLogger(__DIR__ . "/logs/db.log");

			//Listen all the database events
			$eventsManager->attach('db:beforeQuery', function($event, $connection) use ($logger) {
				$sqlVariables = $connection->getSQLVariables();
				if (count($sqlVariables)) {
					$logger->log($connection->getSQLStatement() . ' ' . join(', ', $sqlVariables), Logger::INFO);
				} else {
					$logger->log($connection->getSQLStatement(), Logger::INFO);
				}
			});

			//Assign the eventsManager to the db adapter instance
			$connection->setEventsManager($eventsManager);

			return $connection;
		};

	}

}
