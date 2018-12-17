<?php
namespace Backoffice\Setting\Controllers;

use System\Datalayer\DLCurrency;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLUserCurrency;
use System\Datalayer\DLUserGame;
use System\Library\General\GlobalVariable;

class CurrencyController extends \Backoffice\Controllers\ProtectedController
{
    protected $_limit = 50;
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

        $start = \ceil($pages-1)*$limit;
        $dlCurrency = new DLCurrency();

        $status = GlobalVariable::$twoLayerStatusTypes;
        $currencies = $dlCurrency->listCurrency($start,$limit);

        $totalPages = \ceil($currencies['total']/$limit);

        $view->pages = $pages;
        $view->limit = $limit;

        $view->currencies = $currencies['currencies'];
        $view->total_pages = $totalPages;
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
                $filterData = $DLCurrency->filterData($data);
                $DLCurrency->validateCreateData($filterData);
                $currency = $DLCurrency->create($filterData,$data['user']);

                $this->db->commit();
                return $this->response->redirect($this->_module . '/' . $this->_controller . '/detail/' . $currency['id'])->send();
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

                $filterData = $DLCurrency->filterData($data);
                $DLCurrency->validateSetData($filterData);
                $currency = $DLCurrency->set($filterData);

                $this->db->commit();
                return $this->response->redirect($this->_module . '/' . $this->_controller . '/detail/' . $currency)->send();
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

        $view->currency = $getCurrency;

        \Phalcon\Tag::setTitle("Edit Currency - " . $this->_website->title);
    }

    public function deleteAction()
    {
        $currencyId = $this->dispatcher->getParam("id");
        $previousPage = new GlobalVariable();

        if (!isset($currencyId)) {
            $this->flash->error("undefined_currency_code");
            $this->response->redirect($previousPage->previousPage())->send();
        }

        $getCurrency = array();
        try {
            $DLCurrency = new DLCurrency();
            $getCurrency = $DLCurrency->delete($currencyId);
        } catch (\Exception $e) {
            $this->flash->error($e->getMessage());
            $this->response->redirect($previousPage->previousPage())->send();
        }
    }

    public function statusAction()
    {
        $view = $this->view;

        $getParam = $this->dispatcher->getParam("id");

        $previousPage = new GlobalVariable();

        $param = explode("|", $getParam);
        $currencyId = $param[0];
        $status = $param[1];

        if (!isset($currencyId)) {
            $this->flash->error("undefined_currency_code");
            $this->response->redirect("/setting/currency")->send();
        }

        $dlCurrency = new DLCurrency();

        try {
            $this->db->begin();

            $data['st'] = $status;
            $data['id'] = $currencyId;

            $dlCurrency->set($data);

            $games = $users = $currencies = $userCurrencyIdRecords = $gameCurrencyIdRecords = array();
            $dlUserGame = new DLUserGame();

            $dlGameCurrency = new DLGameCurrency();
            $gameCurrencies = $dlGameCurrency->findByCurrency($data['id']);

            // get all game based on selected currency id
            foreach ($gameCurrencies as $gameCurrency) {
                // set game_currency currency_status [0/1] based on game ID
                $gameCurrencyId = $gameCurrency['id'];
                $games[] = $gameCurrency['idgm'];

                $postData = array(
                    'id' => $gameCurrencyId,
                    'cust' => $data['st']
                );
                $dlGameCurrency->set($postData);
            }

            $dlUserCurrency = new DLUserCurrency();
            $userCurrencies = $dlUserCurrency->findByCurrency($data['id']);

            // get all user based on selected currency id
            foreach ($userCurrencies as $userCurrency) {
                // set user_currency currency_status [0/1] based on user ID
                $userCurrencyId = $userCurrency['id'];
                $users[] = $userCurrency['idus'];

                $postData = array(
                    'id' => $userCurrencyId,
                    'cust' => $data['st']
                );

                $dlUserCurrency->set($postData);
            }

            $userCurrencyId = $gameCurrencyId = $userCurrencyRecords = array();
            foreach ($users as $user) {
                $userGames = $dlUserGame->findByUser($user);
                foreach ($userGames as $userGame){
                    $userCurrencies = $dlUserCurrency->findByUser($userGame['idus']);
                    $gameCurrencies = $dlGameCurrency->findByGame($userGame['gm']['id']);

                    foreach ($userCurrencies as $userCurrency){
                        $userCurrencyId[] = $userCurrency['cu']['id'];
                    }

                    foreach ($gameCurrencies as $gameCurrency){
                        $gameCurrencyId[] = $gameCurrency['cu']['id'];
                    }
                }
            }

//            $a = array_unique($userCurrencyId);
//            $b = array_unique($gameCurrencyId);
//            var_dump($a);
//            var_dump($b);
//            $result = array_intersect($a, $b);
//            var_dump($result);
////            if(count(array_intersect($userCurrencyId, $gameCurrencyId)) > 0){
////                var_dump(count(array_intersect($userCurrencyId, $gameCurrencyId)));
////            }
//            die;

//            foreach ($games as $game){
//                $userGames = $dlUserGame->findByGame($game);
//                $gameCurrencies = $dlGameCurrency->findByGame($game);
//
//                foreach ($gameCurrencies as $gameCurrency){
//
//                }
//                foreach ($userGames as $userGame){
//                    var_dump($userGame);
////                    $gameCurrencies = $dlGameCurrency->findByGame($userGame['gm']['id']);
//                }
//            }

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}