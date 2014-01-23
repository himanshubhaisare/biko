<?php

namespace Biko\Frontend\Controllers;

use Biko\Controllers\ControllerBase;

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

