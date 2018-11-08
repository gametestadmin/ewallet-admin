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
            $currency = $DLUserCurrency->getByUser($this->_user->getId());
            $DlCurrency = new DLCurrency();

            foreach( $currency as $key => $value ){
                $currencylisting = $DlCurrency->getById($value->getCurrency()) ;
                $datalist['id'] = $value->getId();
                $datalist['symbol'] = $currencylisting->getSymbol();
                $datalist['code'] = $currencylisting->getCode();
                $datalist['currency_name'] = $currencylisting->getName();
                $datalist['default'] = $value->getDefault();
                $datalist['status'] = $value->getStatus();
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
                $DLUserCurrency->setCurrencyDefault($this->_realUser->getId() , $data['id'] );
                $data['messages'] = $this->_translate['user_currency_set_default_success'] ;
                //response json
                $response->setStatusCode(200);
            }
        }


        $response->setContent(json_encode($data));
        return $response;
    }

}
