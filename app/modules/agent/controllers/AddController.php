<?php

namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLAclRole;
use System\Datalayer\DLUser;
use System\Datalayer\DLUserAclAccess;
use System\Datalayer\DLUserAclResource;
use System\Library\General\GlobalVariable;

class AddController extends \Backoffice\Controllers\ProtectedController
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function indexAction()
    {
        $view = $this->view;

        $globalVariable = new GlobalVariable();
        $gmt = $globalVariable->getGmt();
        $code = array();
        foreach(range(0,9) as $v){
            $code[] = $v;
        }
        foreach(range('A','Z') as $v){
            $code[] = $v;
        }

        if ($this->request->getPost()) {

            try {
                $this->db->begin();
                $data = $this->request->getPost();

                $data['agent'] = $this->_user;

                $DLUser = new DLUser();
                $filterData = $DLUser->filterAddAgent($data);
                $DLUser->validateAddAgent($filterData);
                $user = $DLUser->setAddAgent($filterData);

                $userId = $user->getId();
                $type = $user->getType();

                $DLAclRole = new DLAclRole();
                $DLUserAclResource = new DLUserAclResource();
                $DLUserAclAccess = new DLUserAclAccess();

                $aclRoles = $DLAclRole->getByType($type);

                foreach($aclRoles as $aclRole){
                    $userAclResource = $DLUserAclResource->getById($aclRole->getAclResource());

                    $DLUserAclAccess->setAclAccess($userId, $userAclResource);
                }

                $this->db->commit();
                $this->flash->success('agent_create_success');
                return $this->response->redirect("/".$this->_module."/".$this->_controller)->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }

        }
        $view->agent = $this->_user;
        $view->code = $code;
        $view->gmt = $gmt;

        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
    }
}
