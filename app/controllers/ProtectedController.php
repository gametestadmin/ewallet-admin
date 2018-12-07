<?php
namespace Backoffice\Controllers;

class ProtectedController extends BaseController
{

    public function initialize()
    {
        parent::initialize();

        if (empty($this->_user)) {
            $this->response->setHeader('X-Robots-Tag', 'noindex, nofollow');

            $this->flash->error("login_first_please");
            return $this->response->redirect("/login")->send();
        }

    }
}


