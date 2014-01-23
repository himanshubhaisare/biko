<?php

namespace Biko\Backend\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\Hidden,

	Phalcon\Validation\Validator\PresenceOf,
	Phalcon\Validation\Validator\Email;

class CategoriesForm extends FormBase
{

	public function initialize($entity=null, $options=null)
	{

		if (!isset($options['edit']) && !isset($options['create'])) {
			$id = new Text('id');
			$id->setLabel('Id');
			$id->setUserOption('searcheable', true);
			$id->setUserOption('browseable', true);
			$this->add($id);
		}

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
