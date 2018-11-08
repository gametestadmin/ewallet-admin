<?php
namespace Backoffice\Setting\Controllers;

use System\Datalayer\DLCurrency;
use System\Library\General\GlobalVariable;

class CurrencyController extends \Backoffice\Controllers\ProtectedController
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function indexAction()
    {
        $view = $this->view;

        $limit = $this->_limit;
        $pages = $this->_pages;

        if ($this->request->has("pages")) {
            $pages = $this->request->get("pages");

        } elseif ($this->session->has("pages")) {
            $pages = $this->session->get("pages");

        }

        $DLCurrency = new DLCurrency();
        $status = GlobalVariable::$twoLayerStatusTypes;
        $currencies = $DLCurrency->lists(0,$limit);

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $currency,
//                "limit" => $limit,
//                "page" => $pages
//            )
//        );
//
//        $page = $paginator->getPaginate();
//
//        $pagination = ceil($currency->count() / $limit);
//
//        $view->page = $page->items;
//        $view->pagination = $pagination;
//        $view->pages = $pages;
//        $view->limit = $limit;

        $view->currencies = $currencies;
        $view->status = $status;

        \Phalcon\Tag::setTitle("Currency - " . $this->_website->title);
    }

    public function addAction()
    {
        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();
                $data['user'] = $this->_user->getId();

                $DLCurrency = new DLCurrency();
                $filterData = $DLCurrency->filterInput($data);
                $DLCurrency->validateAdd($filterData);
                $currency = $DLCurrency->insert($filterData);

                $this->db->commit();
                return $this->response->redirect($this->_module . '/' . $this->_controller . '/detail/' . strtolower($currency))->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        \Phalcon\Tag::setTitle("Add New Currency - " . $this->_website->title);
    }

    public function editAction()
    {
        $view = $this->view;

        $currencyId = $this->dispatcher->getParam("id");

        $DLCurrency = new DLCurrency();
        $getCurrency = $DLCurrency->detail($currencyId);

        if (!isset($currencyId)) {
            $this->flash->error("undefined_currency");
            $this->response->redirect($this->_module . "/" . $this->_controller . "/")->send();
        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();
                $data['id'] = $getCurrency['id'];

                $data = $DLCurrency->filterInput($data);
                $DLCurrency->validateEdit($data);
                $getCurrency = $DLCurrency->update($data);

                $this->db->commit();
                return $this->response->redirect($this->_module . '/' . $this->_controller . '/detail/' . $currentCode)->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        $view->currency = $getCurrency;

        \Phalcon\Tag::setTitle("Edit Currency - " . $this->_website->title);
    }

    public function detailAction()
    {
        $view = $this->view;

        $currencyId = $this->dispatcher->getParam("id");

        if (!isset($currencyId)) {
            $this->flash->error("undefined_currency_code");
            $this->response->redirect($this->_module . "/" . $this->_controller)->send();
        }

        $getCurrency = array();
        try {
            $DLCurrency = new DLCurrency();
            $getCurrency = $DLCurrency->detail($currencyId);
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
            $this->response->redirect($this->_module . "/" . $this->_controller)->send();
        }

        $view->currency = $getCurrency[0];

        \Phalcon\Tag::setTitle("Edit Currency - " . $this->_website->title);
    }

    public function statusAction()
    {
        $view = $this->view;

        $getParam = $this->dispatcher->getParam("id");

        $previousPage = new GlobalVariable();

        $param = explode("|", $getParam);
        $currentId = $param[0];
        $status = $param[1];

        if (!isset($currentId)) {
            $this->flash->error("undefined_currency_code");
            $this->response->redirect("/setting/currency")->send();
        }

        $DLCurrency = new DLCurrency();

        try {
            $this->db->begin();

            $data['st'] = $status;
            $data['id'] = $currentId;

            $DLCurrency->update($data);

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}