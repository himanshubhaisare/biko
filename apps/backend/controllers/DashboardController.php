<?php

namespace Biko\Backend\Controllers;

use Biko\Models\Users;
use Biko\Backend\Forms\LoginForm;
use Biko\Controllers\ControllerBase;

/**
 * @Private
 * @RoutePrefix("/admin/dashboard")
 */
class DashboardController extends ControllerBase
{

	/**
	 * @Get("/", name="session-login")
	 */
    public function indexAction()
    {
    	$this->tag->setTitle('Dashboard');

    	$this->view->setTemplateBefore(array(
			'menu', 'main'
		));
    }

}

