<?php

namespace Backoffice\Downline\Controllers;

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
        $dlUserCurrency = new DLUserCurrency();
        $userCurrency = $dlUserCurrency->findByUserAndAllStatus($this->_user->id,1,1);


        $gmt = $globalVariable->getGmt();

        $code = array();
        foreach(range(0,9) as $v){
            $code[] = $v;
        }
        foreach(range('A','Z') as $v){
            $code[] = $v;
        }
//        $dlUserAclResource = new DLUserAclResource();
//        $dlAclRole = new DLAclRole();
//        $aclRoles = $dlAclRole->findAll(6);
//        foreach ($aclRoles as $aclRole){
//            $postData = array(
//                "tp" => 5,
//                "idusaclrs" => $aclRole['idusaclrs']
//            );
//            $dlAclRole->create($postData);
//        }
//        die;

        if ($this->request->getPost()) {

            try {
                $this->db->begin();
                $data = $this->request->getPost();

                $data['agent'] = $this->_user;

                $dlUser = new DLUser();
                $filterData = $dlUser->filterInputAgentData($data);
                $user = $dlUser->create($filterData);

                $userId = $user['id'];
                $downlineRecord = $dlUser->findFirstById($userId);
                $type = $downlineRecord['tp'];

                $dlAclRole = new DLAclRole();
                $dlUserAclResource = new DLUserAclResource();
                $dlUserAclAccess = new DLUserAclAccess();
                $dlUserAuth = new DLUserAuth();
                $dlUserWhitelistIp = new DLUserWhitelistIp();
                $dlUserCurrency = new DLUserCurrency();

                $dlUserWhitelistIp->create($userId,$filterData['ip']);
                $dlUserCurrency->create($userId,$filterData['idcu']);
                $dlUserAuth->create($downlineRecord);

                $aclRoles = $dlAclRole->findByType($type);
                foreach($aclRoles as $aclRole){
                    $userAclResource = $dlUserAclResource->findFirstById($aclRole['idusaclrs']);
                    $dlUserAclAccess->setAclAccess($downlineRecord['id'], $userAclResource);
                }

                $this->db->commit();
                $this->flash->success('notification_downline_create_success');
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

        \Phalcon\Tag::setTitle("Downline System - ".$this->_website->title);
    }
}
