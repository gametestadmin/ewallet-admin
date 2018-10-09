<?php
namespace Backoffice\User\Controllers;

use System\Library\Security\User as SecurityUser ;
use System\Library\Security\Validation ;
use \System\Datalayer\DLUser;

class PasswordController extends \Backoffice\Controllers\ProtectedController
{
    public function changeAction()
    {
        $view = $this->view;
        if($this->_user->getResetPassword() == 0 ) {
            $this->errorFlash($this->_translate['cannot_access']);
            return $this->response->redirect("/");
        } else {
            if ($this->request->isPost()) {
                $data = $this->request->getPost();

                $securityLibrary = new SecurityUser();
                $password = $securityLibrary->enc_str($data['password']);

                $validation = new Validation();
                $validation->addCondition("password", $data['password'], "format", "password");
                $validation->addCondition("confirm_password_old", $this->_user->getPassword(), "value", "equal", $password);
                $validation->addCondition("password_new", $data['password1'], "format", "password");
                $validation->addCondition("confirm_password_new", $data['password2'], "format", "password");
                $validation->addCondition("confirm_password_new", $data['password2'], "value", "equal", $data['password1']);
                $validation->execute();
                if ($validation->_valid == false) {
                    foreach ($validation->_messages as $fieldName => $messages) {
                        foreach ($messages as $message) {
                            $this->errorFlash($message);
                        }
                    }
                } else {
                    if($this->_user->getStatus() >= 0) {

                        $password = $securityLibrary->enc_str($data['password1']);
                        $DLuser = new DLUser();
                        // TODO :: change password manual
                        $savePassword = $DLuser->setUserPassword($this->_user , $password);
                        if($savePassword){
                            $this->_user->setPassword($password);

                            $this->successFlash($this->_translate['password_changed']);
                            return $this->response->redirect("/");
                        } else {
                            //TODO :: remember_to add error log for this function below
//                        \error_log('USER_UPDATE_PASSWD', 'username', $this->_user->getUsername(), 'oldpass', '' . $data['password'] . '', '', '');
                            $this->errorFlash($this->_translate['system_error']);
                        }

                    }

                }

            }
        }

        \Phalcon\Tag::setTitle("Change Password - ".$this->_website->title);
    }

    public function resetAction()
    {
        $view = $this->view;
        if ($this->request->isPost())
        {
            $data = $this->request->getPost();

            $validation = new Validation();
            $validation->addCondition("Username", $data['username'], "format", "username");
            $validation->addCondition("password", $data['password'], "format", "password");
            $validation->execute();
            if ($validation->_valid == false) {
                foreach ($validation->_messages as $fieldName => $messages) {
                    foreach ($messages as $message) {
                        $this->errorFlash($message);
                    }
                }
            } else {
                $DLuser = new DLUser();
                $user = $DLuser->getByUsername($data['username']);
                if($this->_user->getStatus() > 0 && $user->getStatus() > 0 && $user->getParent() == $this->_user->getId() ) {

                    $securityLibrary = new SecurityUser();
                    $password = $securityLibrary->enc_str($data['password']);

                    // TODO :: change password manual
                    $savePassword = $DLuser->setResetPassword($user , $password);
                    if($savePassword){

                        $this->successFlash($this->_translate['password_changed']);
                        return $this->response->redirect("/");
                    } else {
                        //TODO :: remember_to add error log for this function below
//                        \error_log('USER_UPDATE_PASSWD', 'username', $this->_user->getUsername(), 'oldpass', '' . $data['password'] . '', '', '');
                        $this->errorFlash($this->_translate['system_error']);
                    }

                } else {
                    $this->errorFlash($this->_translate['you_cannot_reset_password_for_this_username']);
                }

            }

        }

        \Phalcon\Tag::setTitle("Change Password - ".$this->_website->title);
    }

}
