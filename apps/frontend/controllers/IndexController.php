<?php

namespace Biko\Frontend\Controllers;

class IndexController extends ControllerBase
{

	/**
     * @Get("/index", name="index")
     */
    public function indexAction()
    {
    	$this->tag->setTitle('Welcome');
    }

    public function route404Action()
    {

    }

}

