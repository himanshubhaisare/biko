<?php

namespace Biko\Backend\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;

class FormBase extends Form
{

	public function show()
	{
		foreach ($this->getElements() as $element) {

			if ($element->getUserOption('read-only')) {
				continue;
			}

			if ($element instanceof Hidden) {
				continue;
			}

			$required = false;
			$validators = $element->getValidators();
			if (count($validators)) {
				foreach ($validators as $validator) {
					if ($validator instanceof PresenceOf) {
						$required = true;
						break;
					}
				}
			}

			echo '<div class="row">';

			if ($this->hasMessagesFor($element->getName())) {
				if ($required) {
					echo '<div class="form-group col-md-12 has-error required">';
				} else {
					echo '<div class="form-group col-md-12 has-error">';
				}
			} else {
				if ($required) {
					echo '<div class="form-group col-md-12 required">';
				} else {
					echo '<div class="form-group col-md-12">';
				}
			}

			echo '<label class="form-label" for="', $element->getName(), '">', $element->getLabel(), '</label>';

			echo $element->render(array('class' => 'form-control'));

			if ($this->hasMessagesFor($element->getName())) {
				echo '<br/>';
				foreach ($this->getMessagesFor($element->getName()) as $message) {
					echo '<span class="help-inline">', $message, '</span><br/>';
				}
			}

			echo '</div>' ;

			echo '</div>' ;
		}

	}

}
