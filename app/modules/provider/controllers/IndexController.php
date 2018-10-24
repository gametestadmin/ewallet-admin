<?php
namespace Backoffice\Provider\Controllers;

use System\Datalayer\DLProviderGame;
use System\Library\General\GlobalVariable;

class IndexController extends \Backoffice\Controllers\ProtectedController
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

        $providerGame = new DLProviderGame();
        $status = GlobalVariable::$threeLayerStatus;
        $provider = $providerGame->getAll($this->_type);

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $provider,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $page = $paginator->getPaginate();

        $pagination = ceil($provider->count()/$limit);
        $view->page = $page->items;
        $view->pagination = $pagination;
        $view->pages = $pages;
        $view->limit = $limit;

        $view->provider = $provider;
        $view->status = $status;

        \Phalcon\Tag::setTitle("Game Provider - ".$this->_website->title);
    }
}
