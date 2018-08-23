<?php
namespace Backoffice\Currency\Controllers;

use System\Model\Currency;

class EditController extends \Backoffice\Controllers\BaseController
{

    public function indexAction()
    {
        $view = $this->view;

        $currentCurrency = $this->dispatcher->getParam("code");
        $currency = Currency::findFirstByCode($currentCurrency);


        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $data['name'] = \filter_var(\strip_tags(\addslashes($data['name'])), FILTER_SANITIZE_STRING);
            $data['symbol'] = \filter_var(\strip_tags(\addslashes($data['symbol'])), FILTER_SANITIZE_STRING);
            $data['status'] = \intval($data['status']);

            if($currency) {
                $currency->setName($data['name']);
                $currency->setSymbol($data['symbol']);
                $currency->setStatus($data['status']);
                $currency->save();
            }
        }
        $view->code = $currency->getCode();
        $view->name = $currency->getName();
        $view->symbol = $currency->getSymbol();
        $view->status = $currency->getStatus();

        \Phalcon\Tag::setTitle("Edit Currency - ".$this->_website->title);
    }
}
