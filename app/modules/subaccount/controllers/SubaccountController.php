<?php
namespace Backoffice\Subaccount\Controllers;

use System\Datalayer\DLUser;
use System\Datalayer\DLUserAclAccess;
use System\Datalayer\DLUserAclResource;
use System\Library\User\General ;
use System\Library\Security\Validation ;
use System\Library\General\GlobalVariable;
use System\Library\Security\User as SecurityUser ;



class SubaccountController extends \Backoffice\Controllers\ProtectedController
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
        $status = GlobalVariable::$threeLayerStatus;

        $DLuser = new DLUser();
        $user = $DLuser->getSubaccountById($this->_user->getId());

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $user,
                "limit"=> $limit,
                "page" => $pages
            )
        );
        $page = $paginator->getPaginate();
        $pagination = ceil($user->count()/$limit);
        $view->page = $page->items;
        $view->pagination = $pagination;
        $view->pages = $pages;
        $view->limit = $limit;

        $view->main = $user ;
        $view->status = $status;

        \Phalcon\Tag::setTitle("Manage SubAccount - ".$this->_website->title);
    }

    public function addAction()
    {
        $view = $this->view;

        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $data['username'] = \filter_var(\strip_tags(\addslashes(strtoupper($data['username']))), FILTER_SANITIZE_STRING);
            $data['password'] = \filter_var(\strip_tags(\addslashes($data['password'])), FILTER_SANITIZE_STRING);
            $data['password_confirm'] = \filter_var(\strip_tags(\addslashes($data['password_confirm'])), FILTER_SANITIZE_STRING);

            $validation = new Validation();
            $validation->addCondition("Username", $data['username'] , "format", "username", 5 , 15  );
            $validation->addCondition("Password", $data['password'], "format", "password");
            $validation->addCondition("confirm_password", $data['password_confirm'], "value", "equal", $data['password']);
            $validation->execute();
            if ($validation->_valid == false) {
                foreach ($validation->_messages as $fieldName => $messages) {
                    foreach ($messages as $message) {
                        $this->errorFlash($message);
                    }
                }
            } else {
                $DLuser = new DLUser();
                $checknick = $DLuser->checkNickname($data['username']);

                if($checknick){
                    $this->errorFlash("nickname_already_used");
                } else {
                    $securityLibrary = new SecurityUser();
                    $data['password'] = $securityLibrary->enc_str($data['password']);
                    $data['parent'] = $this->_user->getId();
                    $data['timezone'] = $this->_user->getTimezone();

                    try {
                        $this->db->begin();

                        $user = $DLuser->createSubaccount($data);
                        $generalLibrary = new General();
//                        $aclObject = $generalLibrary->getACL($this->_user->getId() , $this->_user->getParent() );
                        $aclObject = $generalLibrary->getSubaccountACLParent($this->_user->getId());

                        $access = $generalLibrary->setSubaccountDefault($aclObject , $user->getId());
                        //TODO :: dont insert subaccount, and module user default = 1


                        $this->db->commit();
                        $this->flash->success("subaccount_add_successful");
                        $this->response->redirect($this->_module."/".$this->_controller."/detail/".$user->getId()."#tab-acl")->send();
                    } catch (\Exception $e) {
                        $this->db->rollback();
                        $this->flash->error($e->getMessage());
                    }

//                    if($user){
//
//                        $this->successFlash($this->_translate['new_subaccount_success']);
//                        return $this->response->redirect("/");
//                    } else {
//                        //TODO :: remember_to add error log for this function below
////                        \error_log('USER_UPDATE_PASSWD', 'username', $this->_user->getUsername(), 'oldpass', '' . $data['password'] . '', '', '');
//                        $this->errorFlash($this->_translate['new_subaccount_failed']);
//                    }


                }


            }


        }

        \Phalcon\Tag::setTitle("Add SubAccount - ".$this->_website->title);
    }

    public function editAction()
    {
        $view = $this->view;
        $previousPage = new GlobalVariable();
        $childId = $this->dispatcher->getParam("id");
        $generalLibrary = new General();

        $DLUser = new DLUser();
        $user = $DLUser->getById($childId);
        if($user->getParent() == $this->_user->getId()){
            if ($this->request->isPost()) {
                $data = $this->request->getPost();

                $DLAccess = new DLUserAclAccess();
                try {
                    $this->db->begin();
//
                    $aclChild = $generalLibrary->getACL( $user->getId() , true );
                    $DLAccess->setACLSubaccountFalse($aclChild);

//                    echo "<pre>";
//                    var_dump($data);
//                    die;

                    if(!is_null($data['acl']))
                    $result = $generalLibrary->editSubaccountACL($data['acl'] , $user->getParent() , $user->getId()) ;

                    $this->db->commit();
                    $this->flash->success("subaccount_edit_acl_success");
                    $this->response->redirect($this->_module."/".$this->_controller."/detail/".$user->getId());
                } catch (\Exception $e) {
                    $this->db->rollback();
                    $this->flash->error($e->getMessage());
                }

            } else {
//                $aclParent = $generalLibrary->getACL($this->_user->getId() , $this->_user->getParent() );
                $aclParent = $generalLibrary->getSubaccountACLParent($this->_user->getId() , true );
                $aclParent = $generalLibrary->filterACLlistSubaccount($aclParent);

                $aclChild = $generalLibrary->getACL( $user->getId() );
                $aclChild = $generalLibrary->filterACLsubaccountParentId($aclChild) ;

                $view->childuser = $user ;
                $view->aclParent = $aclParent ;
                $view->aclChild = $aclChild ;
            }
        } else {
            $this->errorFlash($this->_translate['cannot_access']);
            $this->response->redirect($previousPage->previousPage());
        }



        $view->status = GlobalVariable::$threeLayerStatus;
        \Phalcon\Tag::setTitle("Edit SubAccount - ".$this->_website->title);
    }

    public function detailAction(){
        $view = $this->view;
        $previousPage = new GlobalVariable();
        $childId = $this->dispatcher->getParam("id");

        $DLUser = new DLUser();
        $user = $DLUser->getById($childId);
        if($user->getParent() == $this->_user->getId()){
            $generalLibrary = new General();
//                $aclParent = $generalLibrary->getACL($this->_user->getId() , $this->_user->getParent() );
            $aclParent = $generalLibrary->getSubaccountACLParent($this->_user->getId() , true );
            $aclParent = $generalLibrary->filterACLlistSubaccount($aclParent);

            $aclChild = $generalLibrary->getACL( $user->getId() );
            $aclChild = $generalLibrary->filterACLsubaccountParentId($aclChild) ;

            $view->childuser = $user ;
            $view->aclParent = $aclParent ;
            $view->aclChild = $aclChild ;

        } else {
            $this->errorFlash($this->_translate['cannot_access']);
            $this->response->redirect($previousPage->previousPage());
        }


        $view->status = GlobalVariable::$threeLayerStatus;
        \Phalcon\Tag::setTitle("Detail SubAccount - ".$this->_website->title);
    }

    public function statusAction(){
        //TODO: FIX THIS , redirect from basecontroller still run the code below this
        if($this->_allowed == 0 ) return $this->response->redirect($this->_module . "/" . $this->_controller . "/")->send();
        $previousPage = new GlobalVariable();
        $currentId = $this->dispatcher->getParam("id");

        $currentId = explode("|",$currentId);
        $id = $currentId[0];
        $status = $currentId[1];

        $DLUser = new DLUser();
        $user = $DLUser->getById($id);
        if(!isset($currentId) || !$user){
            $this->flash->error("user_not_exist");
            $this->response->redirect($this->_module."/".$this->_controller."/");
        }

        try {
            $this->db->begin();

            $DLUser->setStatus($user , $status);

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage());
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
 
    }


}
