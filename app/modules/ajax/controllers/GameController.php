<?php
namespace Backoffice\Ajax\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLProviderGame;

class GameController extends \Backoffice\Controllers\BaseController
{

    public function retrievesomethingAction()
    {
        $this->view->disable();

        $data = array();

        if(!$this->_user){
            //return blank json
            //response json
            $response = new \Phalcon\Http\Response();
            $response->setContentType("application/json");
            $response->setStatusCode(404);
            $response->setContent(json_encode($data));

            return $response;
        }

        //logic
        $data = array(
            "asd"=> true
        );

        //response json
        $response = new \Phalcon\Http\Response();
        $response->setContentType("application/json");
        $response->setStatusCode(200);
        $response->setContent(json_encode($data));

        return $response;
    }
}
