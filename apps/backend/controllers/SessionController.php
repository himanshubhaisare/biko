<?php

namespace Biko\Backend\Controllers;

use Biko\Models\Users;
use Biko\Backend\Forms\LoginForm;
use Biko\Controllers\ControllerBase;

/**
 * @RoutePrefix("/admin/session")
 */
class SessionController extends ControllerBase
{

    /**
     * @Get("/", name="session-login")
     * @Post("/login", name="session-do-login")
     */
    public function indexAction()
    {
        $this->tag->setTitle('Log In');

        $form = new LoginForm();
        $this->view->form = $form;

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost())) {

                $user = Users::findFirstByLogin($this->request->getPost("login"));
                if (!$user) {
                    return $this->flash->error('Incorrect User/Password');
                }

                if (!$this->security->checkHash($this->request->getPost("password"), $user->password)) {
                    return $this->flash->error('Incorrect User/Password');
                }

                $this->session->set('identity', array(
                    'id' => $user->id
                ));

                return $this->dispatcher->forward(array('controller' => 'dashboard'));
            }

        }

    }

    /**
     * @Get("/logout", name="session-do-logout")
     */
    public function logoutAction()
    {
        $this->flash->notice('Good bye!');
        $this->session->remove('identity');
        return $this->dispatcher->forward(array('action' => 'index'));
    }

}

