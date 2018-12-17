<?php
namespace Backoffice\Ajax\Controllers;

use System\Datalayer\DLUserCurrency;
use System\Datalayer\DLCurrency;

class CurrencyController extends \Backoffice\Controllers\BaseController
{

    public function listAction()
    {
        $this->view->disable();
        $data = array();
        $response = new \Phalcon\Http\Response();
        $response->setContentType("application/json");

        //return blank json
        //response json
        if(!$this->_user){
            $response->setStatusCode(404);
            $data['messages'] = $this->_translate['user_not_found'] ;
        } else {
            $DLUserCurrency = new DLUserCurrency();
            $currency = $DLUserCurrency->getByUser( $this->_user->id );

            foreach( $currency as $key => $value ){
                $datalist['id'] = $value->id ;
                $datalist['default'] = $value->df ;
                $datalist['status'] = $value->st ;
                $datalist['symbol'] = $value->cu->sy ;
                $datalist['code'] = $value->cu->cd ;
                $datalist['currency_name'] = $value->cu->nm ;
                $data[] = $datalist ;
            }

            //response json
            $response->setStatusCode(200);
        }


        $response->setContent(json_encode($data));
        return $response;
    }


    public function defaultAction()
    {

        $this->view->disable();
        $data = array();
        $response = new \Phalcon\Http\Response();
        $response->setContentType("application/json");

        //return blank json
        //response json
        if(!$this->_user){
            $response->setStatusCode(404);
            $data['messages'] = $this->_translate['user_not_found'] ;
        } else {
            if ($this->request->isPost()) {
                $data = $this->request->getPost();

                $DLUserCurrency = new DLUserCurrency();
                $data = $DLUserCurrency->setCurrencyDefault( $this->_realUser->id , $data['id'] );
                $data['messages'] = $this->_translate['user_currency_set_default_success'] ;
                //response json
                $response->setStatusCode(200);
            } else {
                $response->setStatusCode(404);
                $data['messages'] = $this->_translate['user_currency_set_default_failed'] ;
            }
        }


        $response->setContent(json_encode($data));
        return $response;
    }

}
