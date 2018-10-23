<?php
namespace Backoffice\Agent\Controllers;

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

        $status = GlobalVariable::$threeLayerStatus;

        $DLUser = new DLUser();
        $agent = $DLUser->getByParent($this->_user->getId());

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $agent,
                "limit"=> $limit,
                "page" => $page
            )
        );
        $records = $paginator->getPaginate();

        $totalPage = ceil($agent->count()/$limit);

        $view->status = $status;
        $view->agent_list = $records->items;
        $view->total_page = $totalPage;
        $view->page = $page;
        $view->limit = $limit;

        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
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

        $status = GlobalVariable::$threeLayerStatus;

        $DLUser = new DLUser();
        $parent = $this->_user;
        $agent = $DLUser->getById($agentId);
        $agentList = $DLUser->getByParent($agentId);

        if(!$agent){
            $this->errorFlash("undefined_id");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }

        $agentSecurity = new Agent();

        $security = $agentSecurity->checkAgentAction($parent->getUsername(),$agent->getUsername());
        if($security == 4){
            $this->errorFlash("cannot_access_security");
            return $this->response->redirect("/agent/list")->send();
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $agentList,
                "limit"=> $limit,
                "page" => $page
            )
        );
        $records = $paginator->getPaginate();

        $totalPage = ceil($agentList->count()/$limit);

        $view->status = $status;
        $view->parent = $agent;
        $view->agent_list = $records->items;
        $view->total_page = $totalPage;
        $view->page = $page;
        $view->limit = $limit;

        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
    }
}
