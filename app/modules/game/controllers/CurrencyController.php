<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLProviderGame;
use System\Library\General\GlobalVariable;

class CurrencyController extends \Backoffice\Controllers\BaseController
{
    public function indexAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            $action = $this->request->get('action');

            var_dump(3);die;
        }

        \Phalcon\Tag::setTitle("Game Currency - ".$this->_website->title);
    }

    public function addAction()
    {
        $previousPage = new GlobalVariable();

        if ($this->request->getPost()) {

            try {
                $this->db->begin();

                $data = $this->request->getPost();

                $DLGameCurrency = new DLGameCurrency();

                $filterData = $DLGameCurrency->filterInput($data);
                $DLGameCurrency->validateAdd($filterData);
                $DLGameCurrency->create($filterData);

                $this->db->commit();
                $this->flash->success('game_currency_added');
                $this->response->redirect($previousPage->previousPage())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
                $this->response->redirect($previousPage->previousPage())->send();
            }
        }

        \Phalcon\Tag::setTitle("Game Currency - ".$this->_website->title);
    }

    public function editAction()
    {
        $previousPage = new GlobalVariable();

        $currentId = $this->dispatcher->getParam("id");

        $currentId = explode("|",$currentId);

        try {
            $this->db->begin();

            $DLGameCurrency = new DLGameCurrency();

            $DLGameCurrency->set($currentId);

            $this->db->commit();
            $this->flash->success('game_currency_default');
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
            $this->response->redirect($previousPage->previousPage())->send();
        }

        \Phalcon\Tag::setTitle("Game Currency - ".$this->_website->title);
    }
}
