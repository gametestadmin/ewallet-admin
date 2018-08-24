<?php

namespace Backoffice\Controllers;

use \System\Datalayer\DLUserAclAccess ;
use \System\Datalayer\DLUser ;

use System\Library\Security\User as SecurityUser ;


class IndexController extends \Backoffice\Controllers\BaseController
{


    public function indexAction()
    {
        $view = $this->view;

//        if($this->request->has("flash")) {
            $this->noticeFlash("user");
            $this->errorFlash("add");
            $this->successFlash("success");
//        }
        $this->_translate["test_new"];




        \Phalcon\Tag::setTitle($this->_website->title);
    }

    public function loginAction(){
        $view = $this->view;

        if ($this->request->getPost())
        {
            $data = $this->request->getPost();
            $username = $data['username'];
            $password = $data['password'];

            echo "<pre>";
            var_dump($data);
            $user = new DLUser();
            $user = $user->getByUsername($username);

            $aclAccess = new DLUserAclAccess();
            $acl = $aclAccess->getById($user->getId());

            $securityLibrary = new SecurityUser();

            $password = $securityLibrary->enc_str($password);
            var_dump($password); die;




            //set session add acl for the current user
//            $this->session->set('acl', json_encode(array("asd"=>true)));



        }







        \Phalcon\Tag::setTitle($this->_website->title);
    }


    public function logoutAction(){
        //unset session removing acl
        $this->session->remove('acl');



    }




    public function languageAction()
    {
        $this->view->disable();

        if(!$this->request->has("code")){
//            return $this->response->redirect("/content-editor/edit?id=".$content->getId());
        }

        //check exist di db
        $code = $this->request->get("code");
        $this->cookies->set('language', $code);

        echo $_SERVER['HTTP_REFERER'];
        return $this->response->redirect($_SERVER['HTTP_REFERER']);
    }

}