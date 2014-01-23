<?php

namespace Biko\Backend\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Date;

use Phalcon\Validation\Validator\PresenceOf;
use Biko\Validators\Numericality;

use Biko\Models\Categories;

class ProductsForm extends FormBase
{

	/**
	 * @param Phalcon\Mvc\ModelInstance $entity
	 * @param array $options
	 */
	public function initialize($entity=null, $options=null)
	{

		if (!isset($options['edit']) && !isset($options['create'])) {
			$id = new Text('id');
			$id->setLabel('Id');
			$this->add($id);
		}

		$category = new Select('categoriesId', Categories::find(), array(
			'using'     => array('id', 'name'),
			'useEmpty'  => true,
			'emptyText' => '...'
		));
		$category->setLabel('Category');
		$category->addValidator(new PresenceOf(array(
			'message' => 'Category is mandatory'
		)));
		$category->setUserOption('searcheable', true);
		$category->setUserOption('browseable', true);
		$category->setUserOption('relation', 'category');
		$this->add($category);

		$icon = new Text('icon', array('placeholder' => 'Enter a css-icon class name'));
		$icon->setLabel('Icon');
		$icon->addValidator(new PresenceOf(array(
			'message' => 'Icon is mandatory'
		)));
		$this->add($icon);

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

		$stock = new Text('stock');
		$stock->setLabel('Stock');
		$stock->setUserOption('browseable', true);
		$stock->addValidator(new PresenceOf(array(
			'message' => 'Current stock is mandatory'
		)));
		$stock->addValidator(new Numericality(array(
			'message' => 'Current stock must be a number'
		)));
		$this->add($stock);

		if (isset($options['edit'])) {
			$createdAt = new Date('created', array('readonly' => 'readonly'));
			$createdAt->setLabel('Created At');
			if ($entity->createdAt) {
				$entity->created = date('Y-m-d', $entity->createdAt);
			}
			$this->add($createdAt);
		}
	}

}
