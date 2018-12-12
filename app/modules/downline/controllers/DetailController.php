<?php
namespace Backoffice\Downline\Controllers;

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

        // dss use
        $parent = $this->_user;
        $agent = $DLUser->findFirstById($agentId);
        $agentCurrency = $DLUserCurrency->findAllByAgent($agentId,1);
        $agentCurrencyData = count($agentCurrency);

        if(!$agent){
            $this->flash->error("notification_undefined_downline");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        $agentSecurity = new Agent();

        // TODO :: temp $parent->username array data
        $security = $agentSecurity->checkAgentAction($parent->username,$agent->sn);

        if($security == false){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/".$this->_module."/list")->send();
        }

        $view->agent = $agent;
        $view->status = $status;
        $view->userCurrencyData = $agentCurrencyData;
        $view->realParent = $security;

        \Phalcon\Tag::setTitle("Downline System - ".$this->_website->title);
    }
}
