<?php

namespace Biko\Frontend\Controllers;

use Biko\Models\Categories;

class CatalogsController extends ControllerBase
{

    /**
     * @Get("/category/{short-name:[a-z]+}", name="show-category")
     */
    public function categoryAction($shortName=null)
    {
        Categories::findFirstByShortName($shortName);
    }

}

