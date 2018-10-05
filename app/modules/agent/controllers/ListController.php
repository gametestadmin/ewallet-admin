<?php
namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLUser;

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

        $view->agent_list = $records->items;
        $view->total_page = $totalPage;
        $view->page = $page;
        $view->limit = $limit;

        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
    }

    public function childAction()
    {
        $view = $this->view;

        $id = $this->dispatcher->getParam("id");

        $limit = $this->_limit;
        $page = $this->_page;

        if ($this->request->has("pages")){
            $page = $this->request->get("pages");

        }elseif($this->session->has("pages")){
            $page = $this->session->get("pages");
        }

        $DLUser = new DLUser();
        $agent = $DLUser->getByParent($id);

//        foreach ($agent as $agentKey => $agentValue){

//            var_dump($this->_user->getId()."|".$agentValue->getParent());
//            echo "<br>";
//            if($this->_user->getId() != $agentValue->getParent()){
//                return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
//            }
//        }
//        die;

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $agent,
                "limit"=> $limit,
                "page" => $page
            )
        );
        $records = $paginator->getPaginate();

        $totalPage = ceil($agent->count()/$limit);

        $view->agent_list = $records->items;
        $view->total_page = $totalPage;
        $view->page = $page;
        $view->limit = $limit;

        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
    }
}
