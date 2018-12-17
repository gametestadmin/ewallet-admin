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
//        $agent = $DLUser->getById($agentId);
        $agent = $DLUser->findFirstById($agentId);

        $userCurrency = $DLUserCurrency->findAllByUser($agentId);
        $userCurrencyData = count($userCurrency);

        // dss use
//        $parent = $this->_user;
//        $agent = $DLUser->findById($agentId);
//        $agentCurrency = $DLUserCurrency->findAllByAgent($agentId,1);
//        $agentCurrencyData = count($agentCurrency);

        if(!$agent){
            $this->flash->error("undefined_agent");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        $agentSecurity = new Agent();

//        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());
        $security = $agentSecurity->checkAgentAction($parent->username,$agent->sn);

//        var_dump($security);
//        die;
        // dss use
//        $security = $agentSecurity->checkAgentAction($parent->username,$agent->username);

        if($security == false){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/agent/list")->send();
        }

        $view->agent = $agent;
        $view->status = $status;
        $view->userCurrencyData = $userCurrencyData;
        $view->realParent = $security;
//        $view->agentCurrencyData = $agentCurrencyData;

        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
    }
}
