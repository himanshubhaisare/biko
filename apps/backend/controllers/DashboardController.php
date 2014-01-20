<?php

namespace Biko\Backend\Controllers;

use Biko\Backend\Forms\LoginForm;
use Biko\Models\Users;

/**
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
    }

}

