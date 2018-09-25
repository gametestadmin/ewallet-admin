<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLGameCurrency;
use System\Datalayer\DLProviderGame;
use System\Datalayer\DLProviderGameEndpoint;
use System\Datalayer\DLProviderGameEndpointAuth;
use System\Library\General\GlobalVariable;

class AuthController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            $action = $this->request->get('action');

            var_dump(3);die;
        }

        \Phalcon\Tag::setTitle("Game Currency - ".$this->_website->title);
    }

    public function addAction()
    {
        $previousPage = new GlobalVariable();

        if ($this->request->getPost()) {

            $data = $this->request->getPost();
            $tab = $data['tab'];

            try {
                $this->db->begin();

                if($this->_allowed == 0){
                    return $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
                }

                $DLProviderGameEndpointAuth = new DLProviderGameEndpointAuth();

                $filterData = $DLProviderGameEndpointAuth->filterInput($data);
                $DLProviderGameEndpointAuth->validateAdd($filterData);
                $DLProviderGameEndpointAuth->create($filterData);

                $this->db->commit();
                $this->flash->success('game_auth_added');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
        }
    }

    public function editAction()
    {
        $previousPage = new GlobalVariable();
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();
            $tab = $data['tab'];
            try {
                $this->db->begin();

                $DLProviderGameEndpointAuth = new DLProviderGameEndpointAuth();

                $filterData = $DLProviderGameEndpointAuth->filterInput($data);
                $DLProviderGameEndpointAuth->validateEdit($filterData);
                $DLProviderGameEndpointAuth->set($data);

                $this->db->commit();
                $this->flash->success('game_auth_edited');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage()."#".$tab)->send();
        }

        \Phalcon\Tag::setTitle("Game Auth - ".$this->_website->title);
    }
}
