<?php

namespace Biko\Mapper;

use Phalcon\Events\Event,
	Phalcon\Mvc\User\Plugin as MvcPlugin,
	Phalcon\Mvc\Model\Manager as ModelsManager;

class AnnotationsInitializer extends MvcPlugin
{

	/**
	 * This is called after initialize the model
	 *
	 * @param Phalcon\Events\Event $event
	 * @param Phalcon\Mvc\Model\Manager $manager
	 */
	public function afterInitialize(Event $event, ModelsManager $manager, $model)
	{

		//Reflector
		$reflector = $this->annotations->get($model);

		/**
		 * Read the annotations in the class' docblock
		 */
		$annotations = $reflector->getClassAnnotations();
		if ($annotations) {

			/**
			 * Traverse the annotations
			 */
			foreach ($annotations as $annotation) {
				switch ($annotation->getName()) {

					/**
					 * Initializes the model's source
					 */
					case 'Source':
						$arguments = $annotation->getArguments();
						$manager->setModelSource($model, $arguments[0]);
						break;

					/**
					 * Initializes Has-Many relations
					 */
					case 'HasMany':
						$arguments = $annotation->getArguments();
						if (isset($arguments[3])) {
							$manager->addHasMany($model, $arguments[0], $arguments[1], $arguments[2], $arguments[3]);
						} else {
							$manager->addHasMany($model, $arguments[0], $arguments[1], $arguments[2]);
						}
						break;

					/**
					 * Initializes Has-Many relations
					 */
					case 'BelongsTo':
						$arguments = $annotation->getArguments();
						if (isset($arguments[3])) {
							$manager->addBelongsTo($model, $arguments[0], $arguments[1], $arguments[2], $arguments[3]);
						} else {
							$manager->addBelongsTo($model, $arguments[0], $arguments[1], $arguments[2]);
						}
						break;

				}
			}
		}

	}

}