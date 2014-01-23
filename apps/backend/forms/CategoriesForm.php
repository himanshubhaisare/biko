<?php

namespace Biko\Backend\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,

	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email;

class CategoriesForm extends FormBase
{

	public function initialize()
	{

		if (isset($option['edit']) || isset($option['create'])) {
			$id = new Hidden('id');
		} else {
			$id = new Text('id');
			$id->setLabel('Id');
			$id->setUserOption('searcheable', true);
			$id->setUserOption('browseable', true);
			$id->addValidator(new PresenceOf(array(
				'message' => 'Short name is mandatory'
			)));
		}
		$this->add($id);

		$shortName = new Text('shortName');
		$shortName->setLabel('Short Name');
		$shortName->setUserOption('searcheable', true);
		$shortName->setUserOption('browseable', true);
		$shortName->addValidator(new PresenceOf(array(
			'message' => 'Short name is mandatory'
		)));
		$this->add($shortName);

		$name = new Text('name');
		$name->setLabel('Name');
		$name->setUserOption('searcheable', true);
		$name->setUserOption('browseable', true);
		$name->addValidator(new PresenceOf(array(
			'message' => 'Name is mandatory'
		)));
		$this->add($name);
	}

}
