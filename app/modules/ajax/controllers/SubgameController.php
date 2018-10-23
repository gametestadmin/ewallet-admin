<?php
namespace Backoffice\Ajax\Controllers;

use System\Datalayer\DLGame;

class SubgameController extends \Backoffice\Controllers\BaseController
{
    protected $_categoryType = 1;

    public function indexAction()
    {
        $this->view->disable();

        $response = array();
        $data = array();
        if ($this->request->getPost()) {
            $input = $this->request->getPost();

            if (isset($input['code'])) {
                $response = new \Phalcon\Http\Response();
                $response->setContentType("application/json");

                $DLGame = new DLGame();

                $category = $DLGame->getByCode($input['code'], $this->_categoryType);
                $main = $DLGame->getByGameParent($category->getId());

                if (count($main) == 0) {
                    return false;
                } else {
                    foreach ($main as $key => $value) {
                        $html = "<option value='" . $value->getCode() . "'>" . $value->getName() . "</option>";
                        $data[] = $html;
                    }
                    $response->setStatusCode(200);
                    $response->setContent(json_encode($data));
                }
            }
        }
        return $response;
//        var_dump($response);
//        die;

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
//
//        //logic
//        $data = array(
//            "asd"=> true
//        );
//
//        //response json
//        $response = new \Phalcon\Http\Response();
//        $response->setContentType("application/json");
//        $response->setStatusCode(200);
//        $response->setContent(json_encode($data));
//
//        return $response;
    }
}
