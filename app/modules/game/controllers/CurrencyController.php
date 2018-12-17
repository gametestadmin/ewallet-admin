<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLGameWhitelistIp;
use System\Datalayer\DLProviderGame;
use System\Library\General\GlobalVariable;

class CurrencyController extends \Backoffice\Controllers\ProtectedController
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

                $dlGameCurrency = new DLGameCurrency();

                $filterData = $dlGameCurrency->filterData($data);
//                $dlGameCurrency->validateCreate($filterData);
                $dlGameCurrency->create($filterData);

                $this->db->commit();
                $this->flash->success('game_currency_added');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage()."#".$data['tab'])->send();
        }

        \Phalcon\Tag::setTitle("Game Currency - ".$this->_website->title);
    }

    public function editAction()
    {
        $previousPage = new GlobalVariable();

        $data["game_id"] = $this->dispatcher->getParam("id");
        $data["id"] = $this->request->get("idgc");
        $tab = $this->request->get("tab");

        if($this->_allowed == 0){
            return $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
        }
        try {
            $this->db->begin();

            $dlGameCurrency = new DLGameCurrency();

            $dlGameCurrency->setDefault($data);

            $this->db->commit();
            $this->flash->success('game_currency_default');
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
        $this->response->redirect($previousPage->previousPage()."#".$tab)->send();

        \Phalcon\Tag::setTitle("Game Currency - ".$this->_website->title);
    }
}
