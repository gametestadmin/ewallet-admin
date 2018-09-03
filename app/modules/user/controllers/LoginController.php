<?php
namespace Backoffice\User\Controllers;

use \System\Datalayer\DLUser;
use System\Library\Security\User as SecurityUser ;
use System\Library\General\Captcha;
use System\Library\User\General;

class LoginController extends \Backoffice\Controllers\BaseController
{

    public function loginAction(){
        $view = $this->view;
        if($this->_user) return $this->response->redirect("/");

//        echo "something here<pre>";
//        var_dump($this->session->get('acl'));
//        die;


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

                //check Captcha
                $checkcaptcha = new Captcha();
                $captchaTime = $checkcaptcha->checkCaptchaTime();
                $captcha = $checkcaptcha->checkCatpcha($data["captcha"]);

                if( $password === $user->getPassword() && $captchaTime && $captcha ){
                    $this->session->set('user', $user);


                    //TODO :: incomplete
                    //set session add acl for the current user

                    $generalLibrary = new General();
                    if($user->getParent() == 1){
                        $aclObject = $generalLibrary->getCompanyACL();
                    } else {
                        $aclObject = $generalLibrary->getACL($user->getId());
                    }
                    $acl = $generalLibrary->filterACLlist($aclObject);

                    $this->session->remove('acl');
                    $this->session->set('acl', json_encode($acl));
//                    echo "something here<pre>";
//                    var_dump($acl);
//                    die;


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


}
