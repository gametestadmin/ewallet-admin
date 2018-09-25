<?php
namespace Backoffice\User\Controllers;

use \System\Datalayer\DLUser;

class NicknameController extends \Backoffice\Controllers\ProtectedController
{

    public function changeAction()
    {
        $view = $this->view;
        if ($this->request->isPost())
        {
            $data = $this->request->getPost();
            $data['nickname'] = \filter_var(\strip_tags(\addslashes($data['nickname'])), FILTER_SANITIZE_STRING);

            $DLuser = new DLUser();
            $checknick = $DLuser->checkNickname($data['nickname']);

            if($checknick){
                $this->errorFlash("nickname_already_used");
            } else {
                $nickname = $DLuser->setNickname($this->_user , $data['nickname']);
                if($nickname){
                    $this->successFlash("success_change_nickname");
                    return $this->response->redirect("/");
                } else {
                    $this->errorFlash("error_change_nickname");
                }

            }

        }
        \Phalcon\Tag::setTitle("Manage Player - ".$this->_website->title);
    }
}
