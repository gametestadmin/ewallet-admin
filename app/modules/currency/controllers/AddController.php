<?php
namespace Backoffice\Currency\Controllers;

use System\Model\Currency;

class AddController extends \Backoffice\Controllers\BaseController
{

    public function indexAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $data['code'] = \filter_var(\strip_tags(\addslashes($data['code'])), FILTER_SANITIZE_STRING);
            $data['name'] = \filter_var(\strip_tags(\addslashes($data['name'])), FILTER_SANITIZE_STRING);
            $data['symbol'] = \filter_var(\strip_tags(\addslashes($data['symbol'])), FILTER_SANITIZE_STRING);

            $newCurrency = new Currency();
            $newCurrency->setCode($data['code']);
            $newCurrency->setName($data['name']);
            $newCurrency->setSymbol($data['symbol']);
            if(!$newCurrency->save()){
                echo 3;die;
            }
        }

        \Phalcon\Tag::setTitle("Add New Currency - ".$this->_website->title);
    }
}
