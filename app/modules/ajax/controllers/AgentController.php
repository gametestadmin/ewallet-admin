<?php
namespace Backoffice\Ajax\Controllers;


use System\Model\User;

class AgentController extends \Backoffice\Controllers\BaseController
{

    public function checkAction()
    {
        $this->view->disable();

        $response = new \Phalcon\Http\Response();
        $response->setContentType("application/json");
        $message = "";

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            if(isset($data['code'])){
                sleep(1);
                $code = \implode($data['code']);
                $user = User::findFirst(
                    array(
                        "conditions" => "username = :code: OR nickname = :code:",
                        "bind" => array(
                            "code" => $code
                        )
                    )
                );
                if($user == false) {
                    $message = 0;
                    $response->setStatusCode(200);
                    $response->setContent($message);
                }elseif($user == true){
                    $message = 1;
                    $response->setStatusCode(200);
                    $response->setContent($message);
                }else{
                    $response->setStatusCode(404);
                    $response->setContent($message);
                }
            }
            return $response;
        }


//        if(!$this->_user){
//            //return blank json
//            //response json
//            $response = new \Phalcon\Http\Response();
//            $response->setContentType("application/json");
//            $response->setStatusCode(404);
//            $response->setContent(json_encode($data));
//
//            return $response;
//        }

        //logic
//        $data = array(
//            "asd"=> true
//        );
//
//        //response json
//        $response = new \Phalcon\Http\Response();
//        $response->setContentType("application/json");
//        $response->setStatusCode(200);
//        $response->setContent(json_encode($data));

//        return $response;
    }
}
