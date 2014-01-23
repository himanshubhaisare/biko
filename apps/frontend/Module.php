<?php

namespace Biko\Frontend;

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\Collection\Manager as CollectionManager;
use Biko\Unique\Generator;

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
		 * The database connection is created based on the parameters defined in the configuration file
		 */
		$di['db'] = function () use ($config) {
			return new DbAdapter(array(
				"host"     => $config->database->host,
				"username" => $config->database->username,
				"password" => $config->database->password,
				"dbname"   => $config->database->dbname
			));
		};

		/**
		 * The mongo connection is created
		 */
		$di['mongo'] = function() {
			$mongo = new \Mongo();
			return $mongo->selectDb("biko");
		};

		/**
		 * ODM Collection Manager
		 */
		$di['collectionManager'] = function() {
			return new CollectionManager();
		};

		/**
		 * Unique Cart ID generator
		 */
		$di['unique'] = function() {
			return new Generator();
		};

	}

}
