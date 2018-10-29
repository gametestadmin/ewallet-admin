<?php
namespace Backoffice\User\Controllers;

use System\Datalayer\DLUserCurrency;
use System\Library\General\GlobalVariable;

class CurrencyController extends \Backoffice\Controllers\ProtectedController
{

    public function editAction()
    {
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
        $this->response->redirect($previousPage->previousPage())->send();

        \Phalcon\Tag::setTitle("User Currency - ".$this->_website->title);
    }
}
