<?php

namespace Biko\Frontend\Controllers;

class HelpController extends ControllerBase
{

	/**
     * @Get("/help", name="help")
     */
    public function indexAction()
    {
    	$this->tag->setTitle('Help');
    }

}

