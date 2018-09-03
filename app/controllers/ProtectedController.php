<?php
namespace Backoffice\Controllers;

class ProtectedController extends BaseController
{

    public function initialize()
    {
        parent::initialize();

        if (empty($this->_user)) {
            $this->response->setHeader('X-Robots-Tag', 'noindex, nofollow');

            return $this->response->redirect("/login");
        }

//        if(!($this->session->has('acl'))){
//            return $this->response->redirect("/login");
//        }
    }
}


