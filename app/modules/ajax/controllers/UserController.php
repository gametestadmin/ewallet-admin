<?php
namespace Backoffice\Ajax\Controllers;

use \System\Datalayer\DLUser;
use System\Library\Security\Validation ;

class UserController extends \Backoffice\Controllers\BaseController
{

    public function checkNicknameAction()
    {
        $this->view->disable();
        $data = array();
        $response = new \Phalcon\Http\Response();
        $response->setContentType("application/json");

        //return blank json
        //response json
        if(!$this->_user){
            $response->setStatusCode(404);
        } else {
            if ($this->request->isPost()) {
                $post = $this->request->getPost();
                $nickname = $post['nickname'] ;

                $validation = new Validation();
                $validation->addCondition("Nickname", $nickname , "format", "username", 5 , 15  );
                $validation->execute();
                if ($validation->_valid == false) {
                    foreach ($validation->_messages as $fieldName => $messages) {
                        foreach ($messages as $message) {
                            $data["messages"][] = $message ;
                        }
                    }
                    $data['status'] = false ;
                } else {
                    $DLuser = new DLUser();
                    $checknick = $DLuser->checkNickname($nickname);

                    if ($checknick && $nickname != $this->_user->getUsername()){
                        $data['status'] = false ;
                        $data['messages'][] = $this->_translate["nickname_already_exist"] ;
                    } else {
                        $data['status'] = true ;
                        $data['messages'][] = $this->_translate["nickname_can_be_use"] ;
                    }
                }

            }
            //response json
            $response->setStatusCode(200);
        }


        $response->setContent(json_encode($data));
        return $response;
    }
}
