<?php
namespace Backoffice\Agent\Controllers;

use System\Datalayer\DLAclRole;
use System\Datalayer\DLUser;
use System\Datalayer\DLUserAclAccess;
use System\Datalayer\DLUserAclResource;
use System\Datalayer\DLUserAuth;
use System\Datalayer\DLUserCurrency;
use System\Datalayer\DLUserWhitelistIp;
use System\Library\General\GlobalVariable;

class AddController extends \Backoffice\Controllers\ProtectedController
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function indexAction()
    {
        $view = $this->view;

        $globalVariable = new GlobalVariable();
        $DLUserCurrency = new DLUserCurrency();
        $userCurrency = $DLUserCurrency->getAllByUser($this->_user->getId());

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
                $filterData = $DLUser->filterInputAgent($data);
                $DLUser->validateAddAgent($filterData);
                $user = $DLUser->createAgent($filterData);

                $userId = $user->getId();
                $type = $user->getType();

                $DLAclRole = new DLAclRole();
                $DLUserAclResource = new DLUserAclResource();
                $DLUserAclAccess = new DLUserAclAccess();
                $DLUserAuth = new DLUserAuth();
                $DLUserWhitelistIp = new DLUserWhitelistIp();
                $DLUserCurrency = new DLUserCurrency();

                $DLUserWhitelistIp->create($userId,$data['ip']);
                $DLUserCurrency->create($userId,$data['currency']);
                $DLUserAuth->createAgentAuth($user);

                $aclRoles = $DLAclRole->getByType($type);
                foreach($aclRoles as $aclRole){
                    $userAclResource = $DLUserAclResource->getById($aclRole->getAclResource());

                    $DLUserAclAccess->setAclAccess($userId, $userAclResource);
                }

                $this->db->commit();
                $this->flash->success('agent_create_success');
                return $this->response->redirect("/".$this->_module."/detail/".$userId)->send();
            } catch (\Exception $e) {
                $this->db->rollback();
                $this->flash->error($e->getMessage());
            }

        }
        $view->agent = $this->_user;
        $view->userCurrency = $userCurrency;
        $view->code = $code;
        $view->gmt = $gmt;

        \Phalcon\Tag::setTitle("Agent System - ".$this->_website->title);
    }
}
