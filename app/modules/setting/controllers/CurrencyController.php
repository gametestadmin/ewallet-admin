<?php
namespace Backoffice\Setting\Controllers;

use System\Datalayer\DLCurrency;
use System\Library\General\GlobalVariable;

class CurrencyController extends \Backoffice\Controllers\BaseController
{

    public function indexAction()
    {
        $view = $this->view;

        $DLCurrency = new DLCurrency();
        $status = GlobalVariable::$twoLayerStatus;

        $view->currency = $DLCurrency->getAll();
        $view->status = $status;

        \Phalcon\Tag::setTitle("Currency - ".$this->_website->title);
    }

    public function addAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $module = $this->router->getModuleName();
                $controller = $this->router->getControllerName();

                $data = $this->request->getPost();

                $DLCurrency = new DLCurrency();
                $currency = $DLCurrency->create($data);

                $this->db->commit();
                return $this->response->redirect($module.'/'.$controller.'/detail/'.strtolower($currency))->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        \Phalcon\Tag::setTitle("Add New Currency - ".$this->_website->title);
    }

    public function editAction()
    {
        $view = $this->view;

        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();

        $currentCode = $this->dispatcher->getParam("code");

        $DLCurrency = new DLCurrency();
        $getCurrency = $DLCurrency->getByCode($currentCode);
        if(!isset($currentCode) || !$getCurrency){
            $this->flash->error("undefined_currency_code");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();
                $data['code'] = $getCurrency->getCode();

                $data = $DLCurrency->filterInput($data);
                $DLCurrency->validateEdit($data);
                $getCurrency = $DLCurrency->set($data);

                $this->db->commit();
                return $this->response->redirect($module.'/'.$controller.'/detail/'.$currentCode)->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        $view->currency = $getCurrency;

        \Phalcon\Tag::setTitle("Edit Currency - ".$this->_website->title);
    }

    public function detailAction()
    {
        $view = $this->view;

        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();

        $currentCode = $this->dispatcher->getParam("code");

        $DLCurrency = new DLCurrency();
        $getCurrency = $DLCurrency->getByCode($currentCode);
        if(!isset($currentCode) || !$getCurrency){
            $this->flash->error("undefined_currency_code");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();
                $data['code'] = $getCurrency->getCode();

                $data = $DLCurrency->filterInput($data);
                $DLCurrency->validateEdit($data);
                $getCurrency = $DLCurrency->set($data);

                $this->db->commit();
                return $this->response->redirect($this->router->getRewriteUri())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        $view->currency = $getCurrency;
        $view->module = $module;
        $view->controller = $controller;

        \Phalcon\Tag::setTitle("Edit Currency - ".$this->_website->title);
    }

    public function statusAction()
    {
        $view = $this->view;

        $i = 1;
        $getParam = $this->dispatcher->getParam("code");

        $param = explode("|",$getParam);
        $currentCode = $param[0];
        $status = $param[1];
        if(!isset($currentCode)){
            $this->flash->error("undefined_currency_code");
            $this->response->redirect("/setting/currency")->send();
        }

        $DLCurrency = new DLCurrency();
        $getCurrency = $DLCurrency->getByCode($currentCode);

        try {
            $this->db->begin();

            $data['status'] = $status;
            $data['code'] = $getCurrency->getCode();

            $getCurrency = $DLCurrency->set($data);

            $this->db->commit();
            $this->flash->success("status_changed");
            return $this->response->redirect("/setting/currency")->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }

        \Phalcon\Tag::setTitle("Edit Currency - ".$this->_website->title);
    }
}
