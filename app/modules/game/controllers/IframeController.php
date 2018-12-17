<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLProviderGameIframeUrl;
use System\Library\General\GlobalVariable;

class IframeController extends \Backoffice\Controllers\ProtectedController
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

    public function editAction()
    {
        $previousPage = new GlobalVariable();

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            try {
                $this->db->begin();

                $dlProviderGameIframeUrl = new DLProviderGameIframeUrl();

                $filterData = $dlProviderGameIframeUrl->filterData($data);
                $dlProviderGameIframeUrl->validateSet($filterData);
                $dlProviderGameIframeUrl->set($filterData);

                $this->db->commit();
                $this->flash->success('game_endpoint_edited');
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
            $this->response->redirect($previousPage->previousPage() . "#" . $data['tab'])->send();
        }

        \Phalcon\Tag::setTitle("Game Currency - ".$this->_website->title);
    }
}
