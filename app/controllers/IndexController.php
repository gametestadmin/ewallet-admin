<?php

namespace Backoffice\Controllers;

use \System\Datalayer\DLUser;
use System\Library\Security\User as SecurityUser ;
use System\Library\General\Captcha;
use System\Library\User\General;

class IndexController extends \Backoffice\Controllers\BaseController
{


    public function indexAction()
    {
        if (empty($this->_user)) {
            $this->response->setHeader('X-Robots-Tag', 'noindex, nofollow');

            return $this->response->redirect("/login");
        } else {
//            $generalLibrary = new General();
//            if($this->_user->getParent() == 0){
//                $aclObject = $generalLibrary->getCompanyACL();
//            } else {
//                $aclObject = $generalLibrary->getACL($this->_user->getId());
//            }
//            echo "<pre>";
//            var_dump($aclObject);
//            die;



            \Phalcon\Tag::setTitle($this->_website->title);
        }
    }

    public function loginAction(){
        $view = $this->view;
        if($this->_user) return $this->response->redirect("/");

        if ($this->request->getPost()){
            $data = $this->request->getPost();
            $username = $data['username'];
            $password = $data['password'];

            $DLuser = new DLUser();
            $user = $DLuser->getByNickname($username);

            if($user){
                $securityLibrary = new SecurityUser();
                $password = $securityLibrary->enc_str($password);

                // TODO :: change password manual
//            $test = $DLuser->setUserPassword($user , $password);
//            var_dump($test);

                //check Captcha
                $checkcaptcha = new Captcha();
                $captchaTime = $checkcaptcha->checkCaptchaTime();
                $captcha = $checkcaptcha->checkCatpcha($data["captcha"]);

                if( $password === $user->getPassword() && $captchaTime && $captcha ){
                    $this->session->set('user', $user);

                    //TODO :: save and check to redis
                    //TODO :: incomplete
                    //set session add acl for the current user
                    $generalLibrary = new General();
                    if($user->getParent() == 0){
                        $aclObject = $generalLibrary->getCompanyACL();
                    } else {
                        $aclObject = $generalLibrary->getACL($user->getId());
                    }
                    $acl = $generalLibrary->filterACLlist($aclObject);
                    $sideBar = $generalLibrary->getSidebar($aclObject);

                    $this->session->remove('acl');
                    $this->session->set('acl', $acl);
                    $this->session->remove('sidebar');
                    $this->session->set('sidebar', $sideBar);
                    //TODO :: save and check to redis

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

//        \Phalcon\Tag::setTitle($this->config->site->title);
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

//        echo $_SERVER['HTTP_REFERER'];
        return $this->response->redirect($_SERVER['HTTP_REFERER']);
    }

}