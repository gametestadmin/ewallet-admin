<?php
namespace Backoffice\Currency\Controllers;

use System\Datalayer\DLCurrency;

class AddController extends \Backoffice\Controllers\BaseController
{
    public function indexAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            try {
                $this->db->begin();

                $DLCurrency = new DLCurrency();
                // TODO :: need in here or in create function?
//                $DLCurrency->validateAdd($data);
                $DLCurrency->create($data);

                $db_commit = $this->db->commit();
                if($db_commit) {
                    return $this->response->redirect($this->router->getRewriteUri())->send();
                }
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }

        \Phalcon\Tag::setTitle("Add New Currency - ".$this->_website->title);
    }
}
