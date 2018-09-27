<?php
namespace Backoffice\User\Controllers;

use \System\Datalayer\DLUser;
use System\Library\Security\Validation ;

class NicknameController extends \Backoffice\Controllers\ProtectedController
{

    public function changeAction()
    {
        $view = $this->view;
        if ($this->request->isPost())
        {
            $data = $this->request->getPost();
            $data['nickname'] = \filter_var(\strip_tags(\addslashes($data['nickname'])), FILTER_SANITIZE_STRING);

            $validation = new Validation();
            $validation->addCondition("Nickname", $data['nickname'] , "format", "username", 5 , 15  );
            $validation->execute();
            if ($validation->_valid == false) {
                foreach ($validation->_messages as $fieldName => $messages) {
                    foreach ($messages as $message) {
                        $this->errorFlash($message);
                    }
                }
            } else {
                $DLuser = new DLUser();
                $checknick = $DLuser->checkNickname($data['nickname']);

                if($checknick && $data['nickname'] != $this->_user->getUsername()){
                    $this->errorFlash("nickname_already_used");
                } else {
                    $nickname = $DLuser->setNickname($this->_user , $data['nickname']);
                    if($nickname){
                        $this->_user->setNickname($data['nickname']);

                        $this->session->remove('user');
                        $this->session->set('user', $this->_user);

                        $this->successFlash("success_change_nickname");
                        return $this->response->redirect("/");
                    } else {
                        $this->errorFlash("error_change_nickname");
                    }

                }
            }



        }
        $this->view->parameter = $data ;
        \Phalcon\Tag::setTitle("Manage Player - ".$this->_website->title);
    }
}
