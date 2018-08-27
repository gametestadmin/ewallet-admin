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
//            $this->noticeFlash("user");
//            $this->errorFlash("add");
            $this->successFlash("success");
//        }
//        $this->_translate["test_new"];
        echo "<pre>";
        var_dump($this->session->get("acl"));
//        die;



        \Phalcon\Tag::setTitle($this->_website->title);
    }

    public function loginAction(){
        $view = $this->view;

        if ($this->request->getPost()){
            $data = $this->request->getPost();
            $username = $data['username'];
            $password = $data['password'];

            $DLuser = new DLUser();
            $user = $DLuser->getByUsername($username);

            if($user){
                $securityLibrary = new SecurityUser();
                $password = $securityLibrary->enc_str($password);

                // TODO :: change password manual
//            $test = $DLuser->setUserPassword($user , $password);
//            var_dump($test);

                if( $password === $user->getPassword() ){
                    $this->session->set('user', $user);

                    //set session add acl for the current user
                    $aclAccess = new DLUserAclAccess();
                    $acl = $aclAccess->getById($user->getId());
                    $this->session->set('acl', json_encode(array("asdasdasdqweqweqwe"=>true)));

                    $this->successFlash($view->translate['login_success']);
                    return $this->response->redirect("/");
                } else {
                    $this->errorFlash($view->translate['login_error']);
                    return $this->response->redirect("/login");
                }
            } else {
                $this->errorFlash($view->translate['login_error']);
                return $this->response->redirect("/login");
            }

        }

        \Phalcon\Tag::setTitle($this->_website->title);
    }


    public function logoutAction(){
        $view = $this->view;

        \Phalcon\Tag::setTitle($this->config->site->title);
        if($view->user != null){
            $this->session->destroy();
        }
        $this->successFlash($view->translate['logout_success']);
        return $this->response->redirect("/login")->send();

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