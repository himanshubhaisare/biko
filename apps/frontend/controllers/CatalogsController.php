<?php

namespace Biko\Frontend\Controllers;

use Biko\Models\Categories;
use Biko\Controllers\ControllerBase;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * @Public
 */
class CatalogsController extends ControllerBase
{

    /**
     * @Get("/category/{short-name:[a-z]+}", name="show-category")
     */
    public function categoryAction($shortName=null)
    {
        $category = Categories::findFirstByShortName($shortName);
        if (!$category) {
        	return $this->dispatcher->forward(array('controller' => 'index', 'action' => 'index'));
        }

        switch ($this->request->getQuery("order")) {
            case 'newest':
                $products = $category->products;
                break;
            case 'price':
                $products = $category->getProducts(array('order' => 'price'));
                break;
            case 'name':
                $products = $category->getProducts(array('order' => 'name'));
                break;
            default:
                $products = $category->products;
        }

		$paginator = new Paginator(array(
			"data" => $products,
			"limit"=> 4,
			"page" => $this->request->getQuery("page", null, 1)
		));

		$this->view->category = $category;
        $this->view->page = $paginator->getPaginate();

        $this->tag->setTitle($category->name);
    }

}

