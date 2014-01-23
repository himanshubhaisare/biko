<?php

namespace Biko\Behaviors;

/**
 * Timestampable
 *
 */
class Timestampable
{
	public function __construct($options=null)
	{
		$this->_options = $options;
	}

	/**
	 * This handler is called everytime an event happens in the models manager
	 *
	 * @param string $eventType
	 * @param Phalcon\Mvc\ModelInstance $record
	 */
	public function notify($eventType, $record)
    {
        switch ($eventType) {
        	case 'beforeValidationOnCreate':
        		$record->writeAttribute($this->_options['field'], time());
        		break;
		}
	}

	public function missingMethod()
	{

	}

}