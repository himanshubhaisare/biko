<?php

namespace Biko\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
	public function initialize()
	{
		$this->view->setTemplateBefore('main');
	}
}
