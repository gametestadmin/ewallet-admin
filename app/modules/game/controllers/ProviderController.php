<?php
namespace Backoffice\Game\Controllers;

use System\Model\Currency;

class ProviderController extends \Backoffice\Controllers\BaseController
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

        \Phalcon\Tag::setTitle("Game Provider - ".$this->_website->title);
    }

    public function addAction()
    {
        $view = $this->view;

        $view = $this->view;

        if ($this->request->getPost()) {

            $data = $this->request->getPost();
            $data['timezone'] = \filter_var(\strip_tags(\addslashes($data['timezone'])), FILTER_SANITIZE_STRING);
            $data['name'] = \filter_var(\strip_tags(\addslashes($data['name'])), FILTER_SANITIZE_STRING);
            $data['app_id'] = "asdasd";
            $data['app_secret'] = "asdasd";

            $newCurrency = new Currency();

            $newCurrency->setCode($data['code']);
            $newCurrency->setCode($data['code']);

            $newCurrency->setName($data['name']);
            $newCurrency->setSymbol($data['symbol']);
            if(!$newCurrency->save()){
                echo 3;die;
            }
        }

        \Phalcon\Tag::setTitle("Add New Game Provider - ".$this->_website->title);
    }
}
