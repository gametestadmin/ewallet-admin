<?php
namespace Backoffice\Controllers;

defined('APP_PATH') || define('APP_PATH', realpath('.'));

use System\Language\Language;
use \System\Datalayer\DLUserCurrency;
use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;
use System\Library\Security\General ;

class BaseController extends Controller
{
    protected $_website = false;
    protected $_user = null;
//    protected $_child = null;
    protected $_realUser = null;
    protected $_environment = null;
    protected $_module = null;
    protected $_controller = null;
    protected $_action = null;
    protected $_allowed = 1;

//    protected $_application_name = null;
//    protected $_template = null;
//    protected $_frontend = null;
//    protected $_language = "en";
//    protected $_languageList = null;
//    protected $_website = null;
//    protected $_allowedWebsite = null;

    public function initialize()
    {
        $this->_setApplication();
        $this->_setViewTemplate();
        $this->_setBaseUri();
        $this->_setUser();
        $this->_setLanguage();
        $this->_setNavigation();
        $this->_checkResetPassword();
//        $this->_checkResetNickname();
//        $this->_checkACL();

//        $this->_language = $this->cookies->get('language')->getValue();
//        $languageLibrary = new Language();
//        $this->view->translate = $languageLibrary->getTranslation($this->_language);

//        $this->_setWebsite();

    }

    protected function _setApplication()
    {
        if($this->_website == false){
            $this->_website = new \stdClass();
            $this->_website->title = "New Backoffice";
        }

        $this->view->environment = $this->_environment = $this->config->environment;
        $this->view->template = $this->_template = $this->config->template;

//        $this->_application_name = $this->config->application_name;
//        $this->_frontend = $this->config->frontend;
//
//        $this->view->application_name = $this->_application_name;
//        $this->view->site_title = $this->config->site->title;
//        $this->view->site_description = $this->config->site->description;
//        $this->view->site_keywords = $this->config->site->keywords;
//        $this->view->site_author = $this->config->site->author;

//        $this->view->frontend = $this->_frontend;

        $security = new General();
        $this->view->time = date("d-m-Y H:i:s"  ) ;

        $this->view->login_ip = $security->getIP() ;
        $this->view->module = $this->_module = $this->router->getModuleName();
        $this->view->controller = $this->_controller  = $this->router->getControllerName();
        $this->view->action = $this->_action = $this->router->getActionName();
    }

    protected function _setViewTemplate()
    {
        if ($this->dispatcher->getModuleName()) {
            $this->view->viewInModule = true;
        }
    }

    protected function _setBaseUri()
    {
//        echo $_SERVER['HTTP_HOST'];die;
        $this->view->url = $this->config->url->base;
        $this->view->base_url = $this->config->url->base;
        $this->view->media_url = $this->config->url->media;
        $this->view->assets_url = 'http://'.$_SERVER['HTTP_HOST'].'/assets/';
//        $this->view->assets_url = $this->config->url->assets;
    }

    protected function _setLanguage()
    {
        //language function call to whole
        $records = $this->config->language;

        $default = "en";
        $language_list = array();
        foreach($records as $record){
            if($record["status"]){
                $language_list[] = $record["code"];

                if($record["default"]) $default = $record["code"];
            }
        }
        if ($this->cookies->has('language')) {
            $default = $this->cookies->get('language')->getValue();
        }else{
            $this->cookies->set('language', $default);
        }
        $this->view->language_list = $language_list;

        $this->view->language = $default ;
        $languageLibrary = new Language();
//        $this->_translate = $languageLibrary->getTranslation($default);
        $this->view->translate = $this->_translate = $languageLibrary->getTranslation($default);
    }

    protected function _setUser()
    {
        //Set user here
        if($this->session->has('user')){
            $this->_user = $this->session->get('user');
//            $this->_child = $this->session->get('child');
        }
        if($this->session->has('real_user')) {
            $this->_realUser = $this->session->get('real_user');
        }
        if($this->session->has('currency')) {
            $currency = $this->session->get('currency');
        }

        $this->view->user = $this->_user ;
        $this->view->real_user = $this->_realUser ;
    }

    protected function _setNavigation()
    {
        //Get ACL for navigation
        if($this->session->has('sidebar')){
            $this->view->navigationlist = $this->session->get('sidebar') ;
        }
//        echo "<pre>";
//        var_dump($this->view->navigationlist);
//        die;

    }

    protected function _checkACL()
    {
        //check ACL when there is user
        if($this->session->has('user')){
            if($this->session->has('acl') && $this->_module != null && $this->_module != 'ajax' ){
                $acl = $this->session->get('acl') ;
                if( $acl[$this->_module][$this->_controller][$this->_action] == 0){
                    $this->errorFlash('cannot_access');
                    $this->_allowed = 0 ;

                    return $this->response->redirect("/");
                }

            }
        }

    }

    protected function _checkResetPassword(){
        if( $this->_realUser ){
            if ($this->_realUser->getResetPassword() == 1){
                if (!($this->_module == 'user' && $this->_controller == 'password' && $this->_action == 'change')){
                    $this->errorFlash('please_change_password');

                    return $this->response->redirect("/user/password/change");
                }
            }
        }
    }

//    protected function _checkResetNickname(){
//        if( $this->_user ) {
//            if ($this->_user->getResetNickname() == 1) {
//                if (!($this->_module == 'user' && $this->_controller == 'nickname' && $this->_action == 'change')){
//                    $this->errorFlash('please_change_nickname');
//
////                    return $this->response->redirect("/user/nickname/change");
//                }
//            }
//        }
//    }



    protected function noticeFlash($message)
    {
        $message = $this->_translate[$message];

        $this->flash->notice($message);
    }
    protected function errorFlash($message)
    {
        $message = $this->_translate[$message];

        $this->flash->error($message);
    }
    protected function successFlash($message)
    {
        $message = $this->_translate[$message];

        $this->flash->success($message);
    }



//    protected function _setWebsite()
//    {
//        $this->_allowedWebsite = ($this->session->has("allowed_websites"))?$this->session->get("allowed_websites"):null;
//        $this->_website = ($this->session->has("website"))?$this->session->get("website"):null;
//
////        if($this->session->has("allowed_websites")){
////            $this->_allowedWebsite = $this->session->get("allowed_websites");
////        }
////
////        if($this->session->has('website')){
////            $this->_website = $this->session->get('website');
////        }
//        $this->view->allowed_website = $this->_allowedWebsite;
//        $this->view->website = $this->_website;
//    }

    protected function _getBrowserID()
    {
        //check if cookie for browserID existed
        if (!$this->cookies->has('browser_id')) {
            $browserID  = \time();
            $this->cookies->set('browser_id', $browserID);
        }else{
            $browserID = $this->cookies->get('browser_id')->getValue();
        }

        return $browserID;
    }



}

