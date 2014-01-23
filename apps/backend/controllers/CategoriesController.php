<?php

namespace Biko\Backend\Controllers;

use Biko\HyperForm\Controller;

/**
 * CRUD to manage categories
 *
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
			'singular'      => 'category',
			'primaryKey'    => 'id',
			'form'          => 'Biko\Backend\Forms\CategoriesForm',
			'model'         => 'Biko\Models\Categories'
		);

		$this->view->setTemplateBefore(array(
			'menu', 'main'
		));
	}

}


