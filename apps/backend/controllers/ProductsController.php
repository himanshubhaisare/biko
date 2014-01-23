<?php

namespace Biko\Backend\Controllers;

use Biko\HyperForm\Controller;

/**
 * CRUD to manage products
 *
 * @Private
 * @RoutePrefix("/admin/products")
 */
class ProductsController extends Controller
{

	public function initialize()
	{
		$this->tag->setTitle('Products');

		$this->config = array(
			'controller'    => 'admin/products',
			'plural'        => 'products',
			'singular'      => 'product',
			'primaryKey'    => 'id',
			'form'          => 'Biko\Backend\Forms\ProductsForm',
			'model'         => 'Biko\Models\Products'
		);

		$this->view->setTemplateBefore(array(
			'menu', 'main'
		));
	}

}


