<?php
namespace Backoffice\User\Controllers;

use \System\Datalayer\DLUser;
use System\Library\Security\Validation ;
use System\Library\General\GlobalVariable;


class SubaccountController extends \Backoffice\Controllers\ProtectedController
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function indexAction()
    {
        $view = $this->view;
        $limit = $this->_limit;
        $pages = $this->_pages;
        if ($this->request->has("pages")){
            $pages = $this->request->get("pages");

        }elseif($this->session->has("pages")){
            $pages = $this->session->get("pages");
        }
        $status = GlobalVariable::$threeLayerStatus;

        $DLuser = new DLUser();
        $user = $DLuser->getChildById($this->_user->getId());

        echo "<pre>";
        var_dump($user);
        die;

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $user,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $page = $paginator->getPaginate();
        $pagination = ceil($main->count()/$limit);
        $view->page = $page->items;
        $view->pagination = $pagination;
        $view->pages = $pages;
        $view->limit = $limit;

        $view->main = $main;
        $view->status = $status;

        \Phalcon\Tag::setTitle("Manage SubAccount - ".$this->_website->title);
    }

    public function addAction()
    {
        $view = $this->view;


        \Phalcon\Tag::setTitle("Add SubAccount - ".$this->_website->title);
    }

    public function editAction()
    {
        $view = $this->view;


        \Phalcon\Tag::setTitle("Edit SubAccount - ".$this->_website->title);
    }

}
