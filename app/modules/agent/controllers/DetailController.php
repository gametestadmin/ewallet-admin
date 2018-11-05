<?php
namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLUser;
use System\Datalayer\DLUserCurrency;
use System\Library\General\GlobalVariable;
use System\Library\Security\Agent;

class DetailController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        $agentId = $this->dispatcher->getParam("id");

        $DLUser = new DLUser();
        $DLUserCurrency = new DLUserCurrency();

        $status = GlobalVariable::$threeLayerStatusTypes;

        $parent = $this->_user;
        $agent = $DLUser->getById($agentId);

        $userCurrency = $DLUserCurrency->getAllByUser($agentId);
        $userCurrencyData = count($userCurrency);

        if(!$agent){
            $this->flash->error("undefined_agent");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        $agentSecurity = new Agent();

        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());

        if($security == false){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/agent/list")->send();
        }

        $view->agent = $agent;
        $view->status = $status;
        $view->userCurrencyData = $userCurrencyData;
        $view->realParent = $security;

        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
    }
}
