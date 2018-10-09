<?php
namespace Backoffice\Subaccount\Controllers;

use System\Datalayer\DLUser;
use System\Library\Security\User as SecurityUser ;

class PasswordController extends \Backoffice\Controllers\ProtectedController
{

    public function resetAction()
    {
        $view = $this->view;

        $childId = $this->dispatcher->getParam("id");
        $DLUser = new DLUser();
        $Child = $DLUser->getById($childId);

        if(!isset($childId) || !$Child){
            $this->flash->error("undefined_subaccount");
            $this->response->redirect($this->_module."/subaccount/")->send();
        }

        if($this->_user->getId() != $Child->getParent()){
            $this->errorFlash("cannot_access");
            return $this->response->redirect($this->_module."/subaccount/detail/".$childId)->send();
        }

        if ($this->request->getPost()) {
            try {
                $this->db->begin();
                $data = $this->request->getPost();

                $securityLibrary = new SecurityUser();

                $filterData = $DLUser->filterResetPassword($data);
                $password = $securityLibrary->enc_str($filterData['password']);

                $DLUser->validateResetPassword($filterData);
                $DLUser->setResetPassword($Child,$password);

                $this->db->commit();
                $this->flash->success("reset_password_successful");
                $this->response->redirect($this->_module."/subaccount/detail/".$childId)->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }
        }
        \Phalcon\Tag::setTitle("Reset Subaccount Password- ".$this->_website->title);



    }


}
