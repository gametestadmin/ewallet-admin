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
            $acl = $this->session->get('sidebar');
//            echo "<pre>";
//            var_dump($acl);
//            die;

//            $this->view->menu = "home";

            \Phalcon\Tag::setTitle($this->_website->title);
        }
    }

    public function loginAction(){
        $view = $this->view;
        if($this->_user) return $this->response->redirect("/");

        if ($this->request->getPost()){
            $data = $this->request->getPost();
            $username = strtoupper($data['username']);
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
                    //TODO :: if Type == 10, subaccount, $user fill with parent, session sidebar and acl filled with its own acl
                    if($user->getType() == 10) {
                        //TODO :: save and check to redis
                        //TODO :: incomplete
                        //set session add acl for the current user
                        $generalLibrary = new General();
                        $aclObject = $generalLibrary->getACL($user->getId());

                        $acl = $generalLibrary->filterACLlist($aclObject);
                        $sideBar = $generalLibrary->getSidebar($aclObject);

                        $this->session->remove('acl');
                        $this->session->set('acl', $acl);
                        $this->session->remove('sidebar');
                        $this->session->set('sidebar', $sideBar);

//                        $this->session->set('child', $user);
                        $this->session->set('real_user', $user);

                        $user = $DLuser->getById($user->getParent());
                        $this->session->set('user', $user);
                    } else {
                        $this->session->set('user', $user);
//                        $this->session->set('child', $user);
                        $this->session->set('real_user', $user);

                        //TODO :: save and check to redis
                        //TODO :: incomplete
                        //set session add acl for the current user
                        $generalLibrary = new General();
                        $aclObject = $generalLibrary->getACL($user->getId());

                        $acl = $generalLibrary->filterACLlist($aclObject);
                        $sideBar = $generalLibrary->getSidebar($aclObject);

                        $this->session->remove('acl');
                        $this->session->set('acl', $acl);
                        $this->session->remove('sidebar');
                        $this->session->set('sidebar', $sideBar);
                        //TODO :: save and check to redis
                    }
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

        if($this->_user != null){
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