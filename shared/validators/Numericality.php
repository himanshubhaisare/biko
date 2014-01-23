<?php

namespace Biko\Validators;

use Phalcon\Validation\Validator,
	Phalcon\Validation\ValidatorInterface,
	Phalcon\Validation\Message;

class Numericality extends Validator implements ValidatorInterface
{

	/**
	 * Executes the validation
	 *
	 * @param Phalcon\Validation $validator
	 * @param string $attribute
	 * @return boolean
	 */
	public function validate($validator, $attribute)
	{
		$value = $validator->getValue($attribute);
		if ($value !== null && $value !== '') {
			if (!is_numeric($value) || !preg_match('/^[0-9\.]+$/', $value)) {
				$message = $this->getOption('message');
				if ($message) {
					$validator->appendMessage(new Message($message, $attribute, 'Numericality'));
				} else {
					$validator->appendMessage(new Message('This field must be a number', $attribute, 'Numericality'));
				}
				return false;
			}
		}
		return true;
	}

}