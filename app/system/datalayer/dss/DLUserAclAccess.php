<?php
namespace System\Datalayer;

use System\Model\UserAclAccess;

class DLUserAclAccess{
    public $_config;
    public $_adapter;

    public function __construct()
    {
        $this->_config = include __DIR__.'/../../config/config.php';
        $this->_adapter = $this->_config->dbenvironment;
    }

    public function getById($user){
        $acl = UserAclAccess::findByUser($user);

        return $acl;
    }





}