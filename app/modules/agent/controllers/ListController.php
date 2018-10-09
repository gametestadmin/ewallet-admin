<?php
namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLUser;
use System\Library\General\GlobalVariable;

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

        $userId = $this->dispatcher->getParam("id");

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
        $agentList = $DLUser->getByParent($userId);
        $agent = $DLUser->getById($userId);

        if(!$agent){
            $this->errorFlash("undefined_id");
            return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
        }
        $parentUsername = \substr($agent->getUsername(), 0, \strlen($parent->getUsername()));

        if(($parent->getType() <> 0 && $parent->getType() <> 9) && $parent->getUsername() <> $parentUsername) {
            $this->errorFlash("cannot_access");
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

    public function statusAction()
    {
        $view = $this->view;

        $previousPage = new GlobalVariable();
        $currentId = $this->dispatcher->getParam("id");

        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();

        $currentId = explode("|",$currentId);
        $id = $currentId[0];
        $status = $currentId[1];

        $DLUser = new DLUser();
        $user = $DLUser->getById($id);
        if(!isset($currentId) || !$user){
            $this->flash->error("undefined_user");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        try {
            $this->db->begin();

            $DLUser->setStatus($id,$status);

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
