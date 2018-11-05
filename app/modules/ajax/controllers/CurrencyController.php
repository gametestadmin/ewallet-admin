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
        } else {
            $DLUserCurrency = new DLUserCurrency();
            $currency = $DLUserCurrency->getByUser($this->_user->getId());
            $DlCurrency = new DLCurrency();


            $data = array();
            foreach( $currency as $key => $value ){
                $currencylisting = $DlCurrency->getById($value->getCurrency()) ;
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
        $data = array();
        $response = new \Phalcon\Http\Response();
        $response->setContentType("application/json");

        //return blank json
        //response json
        if(!$this->_user){
            $response->setStatusCode(404);
        } else {
            if ($this->request->isPost()) {


                $currencyId = $this->dispatcher->getParam("id");
                $previousPage = new GlobalVariable();

                try {
                    $this->db->begin();

                    $DLUserCurrency = new DLUserCurrency();
                    $DLUserCurrency->setCurrencyDefault($this->_realUser->getId() , $currencyId);

                    $this->db->commit();
                    $this->flash->success('user_currency_default');
                } catch (\Exception $e) {
                    $this->db->rollback();
                    $this->flash->error($e->getMessage());
                }




            }
            //response json
            $response->setStatusCode(200);
        }


        $response->setContent(json_encode($data));
        return $response;




    }

}
