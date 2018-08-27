<?php
namespace Backoffice\Currency\Controllers;

use System\Datalayer\DLCurrency;

class AddController extends \Backoffice\Controllers\BaseController
{
    public function indexAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            try {
                $this->db->begin();

                $data = $this->request->getPost();

                $DLCurrency = new DLCurrency();
                $DLCurrency->create($data);

                $this->db->commit();

                return $this->response->redirect($this->router->getRewriteUri())->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        \Phalcon\Tag::setTitle("Add New Currency - ".$this->_website->title);
    }
}
