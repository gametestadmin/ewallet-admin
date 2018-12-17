<?php
namespace Backoffice\Downline\Controllers;

use System\Datalayer\DLUser;
use System\Library\General\GlobalVariable;
use System\Library\Security\Agent;

class ListController extends \Backoffice\Controllers\ProtectedController
{
    protected $_limit = 10;
    protected $_page = 1;

    public function indexAction()
    {
        $view = $this->view;

        $limit = $this->_limit;
        $page = $this->_page;

        if ($this->request->has("pages")){
            $page = $this->request->get("pages");

        }elseif($this->session->has("pages")){
            $page = $this->session->get("pages");
        }

        $status = GlobalVariable::$threeLayerStatusTypes;

        $DLUser = new DLUser();
//        $agent = $DLUser->getByParent($this->_user->getId());
        $agent = $DLUser->findByParent($this->_user->getId());

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $agent,
//                "limit"=> $limit,
//                "page" => $page
//            )
//        );
//        $records = $paginator->getPaginate();
//
//        $totalPage = ceil($agent->count()/$limit);

//        $view->agent_list = $records->items;
//        $view->total_page = $totalPage;
        $view->page = $page;
        $view->limit = $limit;
        $view->agent_list = $agent;
        $view->status = $status;

        \Phalcon\Tag::setTitle("Downline System - ".$this->_website->title);
    }

    public function childAction()
    {
        $view = $this->view;

        $agentId = $this->dispatcher->getParam("id");

        $limit = $this->_limit;
        $page = $this->_page;

        if ($this->request->has("pages")) {
            $page = $this->request->get("pages");

        } elseif ($this->session->has("pages")) {
            $page = $this->session->get("pages");
        }

        $status = GlobalVariable::$threeLayerStatusTypes;

        $dlUser = new DLUser();
        $parent = $this->_user;
//        $agent = $DLUser->getById($agentId);
//        $agentList = $DLUser->getByParent($agentId);
        $agent = $dlUser->findFirstById($agentId);
        $agentList = $dlUser->findByParent($agentId);

        if(!$agent){
            $this->errorFlash("notification_undefined_downline");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        $agentSecurity = new Agent();

//        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());
        // TODO :: temp $parent->username array data
        $security = $agentSecurity->checkAgentAction($parent->username,$agent->sn);
        if($security == false){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/".$this->_module."/list")->send();
        }

//        $paginator = new \Phalcon\Paginator\Adapter\Model(
//            array(
//                "data" => $agentList,
//                "limit"=> $limit,
//                "page" => $page
//            )
//        );
//        $records = $paginator->getPaginate();
//
//        $totalPage = ceil($agentList->count()/$limit);

        $view->status = $status;
        $view->parent = $agent;
        $view->agent_list = $agentList;
//        $view->agent_list = $records->items;
//        $view->total_page = $totalPage;
        $view->page = $page;
        $view->limit = $limit;

        \Phalcon\Tag::setTitle("Downline System - ".$this->_website->title);
    }
}
