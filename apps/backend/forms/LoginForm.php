<?php

namespace Biko\Backend\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Password,

	Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends Form
{

	public function initialize()
	{

		$login = new Text('login', array('maxlength' => 16));
		$login->addValidator(new PresenceOf(array(
			'message' => 'User name is required'
		)));
		$login->setLabel('Login');
		$this->add($login);

		$password = new Password('password');
		$password->addValidator(new PresenceOf(array(
			'message' => 'Password is required'
		)));
		$password->setLabel('Password');
		$this->add($password);

	}

	public function show()
	{
		$html = '<fieldset>';
		foreach ($this->getElements() as $element) {

			if ($this->hasMessagesFor($element->getName())) {
				$html .= '<div class="form-group has-error">';
			} else {
				$html .= '<div class="form-group">';
			}

			$html .= '<label class="control-label" for="' . $element->getName() . '">' . $element->getLabel() . '</label>';
			$html .= '<div class="controls">' . $element->render(array('form-control'));

			if ($this->hasMessagesFor($element->getName())) {
				foreach ($this->getMessagesFor($element->getName()) as $message) {
					$html .= '<br><span class="help-inline">' . $message . '</span>';
				}
			}

			$html .= '</div>';
			$html .= '</div>' ;
		}
		$html .= '</fieldset>';

		return $html;
	}

}
