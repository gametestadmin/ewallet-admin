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

        $userId = $this->dispatcher->getParam("id");

        $DLUser = new DLUser();
        $DLUserCurrency = new DLUserCurrency();

        $status = GlobalVariable::$threeLayerStatus;

        $parent = $this->_user;
        $agent = $DLUser->getById($userId);

        $userCurrency = $DLUserCurrency->getAllByUser($userId);
        $userCurrencyData = count($userCurrency);

        if(!$agent){
            $this->flash->error("undefined_agent");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

//        if($parent->getId() != $agent->getParent()){
//            $this->errorFlash("cannot_access");
//            return $this->response->redirect("agent/list/")->send();
//        }

        $agentSecurity = new Agent();

        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());
        if($security == false){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/agent/list")->send();
        }

        // TODO : NOTE for view not child
//        $parentUsername = \substr($agent->getUsername(), 0, \strlen($parent->getUsername()));
//        if(($parent->getType() <> 0 && $parent->getType() <> 9) && $parent->getUsername() <> $parentUsername) {
//            $this->errorFlash("cannot_access");
//            return $this->response->redirect("/agent/list")->send();
//        }
//
//        $realParent = true;
//        if($parent->getId() != $agent->getParent()){
//            $realParent = false;
//        }

        $view->agent = $agent;
        $view->status = $status;
        $view->userCurrencyData = $userCurrencyData;
        $view->realParent = $realParent;

        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
    }
}
