<?php

namespace Backoffice\Downline\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLUserGame;
use System\Library\General\GlobalVariable;

class SubgameController extends \Backoffice\Controllers\ProtectedController
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function addAction()
    {
        $view = $this->view;

        $globalVariable = new GlobalVariable();

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            try {
                $this->db->begin();

//                $data['agent'] = $this->_user;
                $dlGame = new DLGame();
                $game = $dlGame->getById($data['game']);
                $data['game_type'] = $game->getType();

                $dlUserGame = new DLUserGame();
                $filterData = $dlUserGame->filterInputAgentGame($data);
                $dlUserGame->validateCreateAgentGame($filterData);
                $dlUserGame->createAgentGame($filterData);

                $this->db->commit();
                $this->flash->success('notification_downline_create_subgame_success');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            return $this->response->redirect($globalVariable->previousPage()."#".$data['tab'])->send();
        }
        $view->agent = $this->_user;

        \Phalcon\Tag::setTitle("Downline System - ".$this->_website->title);
    }
    public function detailAction()
    {
        $view = $this->view;

        $agentGameId = $this->dispatcher->getParam("id");

        $dlUserGame = new DLUserGame();
        $agentGame = $dlUserGame->getById($agentGameId);

        $view->agentGame = $agentGame;

        \Phalcon\Tag::setTitle("Downline System - ".$this->_website->title);
    }
}
