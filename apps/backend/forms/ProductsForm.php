<?php

namespace Biko\Backend\Forms;

use Phalcon\Forms\Form,
	Phalcon\Forms\Element\Text,
	Phalcon\Forms\Element\TextArea,
	Phalcon\Forms\Element\Hidden,

	Phalcon\Validation\Validator\PresenceOf,
	Biko\Validators\Numericality;

class ProductsForm extends FormBase
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

		$code = new Text('code', array('maxlength' => 10));
		$code->setLabel('Code');
		$code->setUserOption('searcheable', true);
		$code->setUserOption('browseable', true);
		$code->addValidator(new PresenceOf(array(
			'message' => 'Code is mandatory'
		)));
		$this->add($code);

		$name = new Text('name', array('maxlength' => 64));
		$name->setLabel('Name');
		$name->setUserOption('searcheable', true);
		$name->setUserOption('browseable', true);
		$name->addValidator(new PresenceOf(array(
			'message' => 'Name is mandatory'
		)));
		$this->add($name);

		$description = new TextArea('description');
		$description->setLabel('Description');
		$description->addValidator(new PresenceOf(array(
			'message' => 'Description is mandatory'
		)));
		$this->add($description);

		$price = new Text('price');
		$price->setLabel('Price');
		$price->setUserOption('searcheable', true);
		$price->setUserOption('browseable', true);
		$price->addValidator(new PresenceOf(array(
			'message' => 'Price is mandatory'
		)));
		$price->addValidator(new Numericality(array(
			'message' => 'Price must be a number'
		)));
		$this->add($price);
	}

}
