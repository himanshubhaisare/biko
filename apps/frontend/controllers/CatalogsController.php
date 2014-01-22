<?php

namespace Biko\Frontend\Controllers;

use Biko\Models\Categories;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CatalogsController extends ControllerBase
{

    /**
     * @Get("/category/{short-name:[a-z]+}", name="show-category")
     */
    public function categoryAction($shortName=null)
    {
        $category = Categories::findFirstByShortName($shortName);
        if (!$category) {
        	return $this->dispatcher->forward(array('controller' => 'index'));
        }

        // Create a Model paginator, show 5 rows by page starting from $currentPage
		$paginator = new Paginator(array(
			"data" => $category->products,
			"limit"=> 4,
			"page" => $this->request->getQuery("page", null, 1)
		));

		$this->view->category = $category;
        $this->view->page = $paginator->getPaginate();
    }

}

