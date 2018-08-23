<?php
namespace Backoffice\Currency\Controllers;

use System\Datalayer\DLCurrency;

class EditController extends \Backoffice\Controllers\BaseController
{
    public function indexAction()
    {
        $view = $this->view;

        $currentCode = $this->dispatcher->getParam("code");
        if(!isset($currentCode)){
            $this->flash->error("undefined_currency_code");
            $this->response->redirect("/currency")->send();
        }

        $DLCurrency = new DLCurrency();
        $getCurrency = $DLCurrency->getByCode($currentCode);

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            $data['code'] = $getCurrency->getCode();
            // TODO :: need filterInput here?
//            $data = $DLCurrency->filterInput($data);

            try {
                $this->db->begin();

                $DLCurrency->validateEdit($data);
                $getCurrency = $DLCurrency->set($data);

                $this->db->commit();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        $view->currency = $getCurrency;

        \Phalcon\Tag::setTitle("Edit Currency - ".$this->_website->title);
    }
}
