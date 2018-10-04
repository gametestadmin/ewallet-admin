<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLProviderGame;
use System\Library\General\GlobalVariable;

class ProviderController extends \Backoffice\Controllers\ProtectedController
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

    public function addAction()
    {
        $view = $this->view;

        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();
        $gmt = $this->getGmt();
        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();

                $DLProviderGame = new DLProviderGame();
                $providerGameId = $DLProviderGame->create($data);

                $this->db->commit();

                $this->flash->success('provider_game_create_success');
                return $this->response->redirect($module.'/'.$controller.'/detail/'.$providerGameId)->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }
        $view->gmt = $gmt;

        \Phalcon\Tag::setTitle("Add New Game Provider - ".$this->_website->title);
    }

    public function editAction()
    {
        $view = $this->view;
        $gmt = $this->getGmt();

        $currentId = $this->dispatcher->getParam("id");

        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();

        $DLProviderGame = new DLProviderGame();
        $providerGame = $DLProviderGame->getById($currentId);
        if(!isset($currentId) || !$providerGame){
            $this->flash->error("undefined_provider_id");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();

                $data['id'] = $providerGame->getId();

                $data = $DLProviderGame->filterInput($data);
                $DLProviderGame->validateEdit($data);
                $DLProviderGame->set($data);

                $this->db->commit();

                $this->flash->success('provider_game_update_success');
                return $this->response->redirect($module.'/'.$controller.'/detail/'.$providerGame->getId())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }
        $view->provider = $providerGame;
        $view->gmt = $gmt;

        \Phalcon\Tag::setTitle("Update Game Provider - ".$this->_website->title);
    }

    public function detailAction()
    {
        $view = $this->view;

        $status = GlobalVariable::$threeLayerStatus;
        $gmt = $this->getGmt();

        $currentId = $this->dispatcher->getParam("id");

        $module = $this->router->getModuleName();
        $controller = $this->router->getControllerName();

        $DLProviderGame = new DLProviderGame();
        $providerGame = $DLProviderGame->getById($currentId);
        if(!isset($currentId) || !$providerGame){
            $this->flash->error("undefined_provider_id");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        $view->provider = $providerGame;
        $view->gmt = $gmt;
        $view->status = $status;

        \Phalcon\Tag::setTitle("Update Game Provider - ".$this->_website->title);
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

        $DLProviderGame = new DLProviderGame();
        $providerGame = $DLProviderGame->getById($id);
        if(!isset($currentId) || !$providerGame){
            $this->flash->error("undefined_provider_id");
            $this->response->redirect($module."/".$controller."/")->send();
        }

        try {
            $this->db->begin();

            $data['id'] = $id;
            $data['status'] = $status;

            $DLProviderGame->set($data);

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }

        \Phalcon\Tag::setTitle("Edit Currency - ".$this->_website->title);
    }

    public function getGmt()
    {
        $i = -12;
        $gmt = array();
        while ($i <= 14){
            $gmt[$i] = $i;
            $i++;
        }

        return $gmt;
    }
}
