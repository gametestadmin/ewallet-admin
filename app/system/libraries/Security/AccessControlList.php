<?php
namespace System\Library\Security;

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;


class AccessControlList extends Plugin
{

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $module = $this->router->getModuleName();
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        //check ACL when there is user
        if($this->session->has('user')){
            $user = $this->session->get('user') ;
            // check ip allowed
            $security = new General();
            $ip = $security->getIP() ;

            $userGeneral = new \System\Library\User\General();
            $ipallowed = $userGeneral->checkIP($user->id , $ip);

            if(!$ipallowed){
                $this->session->destroy();
//                return $this->response->redirect("/logout")->send();
            }

            if($this->session->has('acl') && $module != null && $module != 'ajax' ){
                $acl = $this->session->get('acl') ;
                if( !isset($acl[$module][$controller]) || !isset($acl[$module][$controller][$action]) || $acl[$module][$controller][$action] == 0){
                    return $this->response->redirect($_SERVER['HTTP_REFERER'])->send();
                }

            }
        }

        return true;
    }
}
