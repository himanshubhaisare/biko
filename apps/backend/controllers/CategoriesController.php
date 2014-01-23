<?php

namespace Biko\Backend\Controllers;

use Biko\HyperForm\Controller;

/**
 * CRUD to manage categories
 *
 * @Private
 * @RoutePrefix("/admin/categories")
 */
class CategoriesController extends Controller
{

	public function initialize()
	{
		$this->tag->setTitle('Categories');

		$this->config = array(
			'controller'    => 'admin/categories',
			'plural'        => 'categories',
			'single'        => 'category',
			'primaryKey'    => 'id',
			'form'          => 'Biko\Backend\Forms\CategoriesForm',
			'model'         => 'Biko\Models\Categories'
		);

		$this->view->setTemplateBefore(array(
			'menu', 'main'
		));
	}

}


