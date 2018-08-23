<?php

namespace Backoffice\Controllers;

defined('APP_PATH') || define('APP_PATH', realpath('.'));

use System\Language\Language;
use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;

class BaseController extends Controller
{
    protected $_website = false;
//    protected $_application_name = null;
//    protected $_environment = null;
//    protected $_template = null;
//    protected $_frontend = null;
//    protected $_language = "en";
//    protected $_languageList = null;
//    protected $_user = null;
//    protected $_website = null;
//    protected $_allowedWebsite = null;

    public function initialize()
    {
        $this->_setApplication();
        $this->_setViewTemplate();
        $this->_setBaseUri();
        $this->_setLanguage();
        $this->_setUser();



//        $this->_setWebsite();

//        $this->_language = $this->cookies->get('language')->getValue();
//        $this->view->translate = language::getTranslation($this->_language);

    }

    protected function _setApplication()
    {
        if($this->_website == false){
            $this->_website = new \stdClass();
            $this->_website->title = "New Backoffice";
        }

        $this->_environment = $this->config->environment;
        $this->_template = $this->config->template;
        $this->view->environment = $this->_environment;
        $this->view->template = $this->_template;

//        $this->_application_name = $this->config->application_name;
//        $this->_frontend = $this->config->frontend;
//
//        $this->view->application_name = $this->_application_name;
//        $this->view->site_title = $this->config->site->title;
//        $this->view->site_description = $this->config->site->description;
//        $this->view->site_keywords = $this->config->site->keywords;
//        $this->view->site_author = $this->config->site->author;

//        $this->view->frontend = $this->_frontend;
//
//        $this->view->module = $this->router->getModuleName();
//        $this->view->controller = $this->router->getControllerName();
//        $this->view->action = $this->router->getActionName();
    }

    protected function _setViewTemplate()
    {
        if ($this->dispatcher->getModuleName())
        {
            $this->view->viewInModule = true;
        }
    }

    protected function _setBaseUri()
    {
        $this->view->base_url = $this->config->url->base;
        $this->view->assets_url = $this->config->url->assets;
        $this->view->media_url = $this->config->url->media;
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
        $this->_language = $default;

        $this->view->language = $this->_language;
        $languageLibrary = new Language();
        $this->_translate = $languageLibrary->getTranslation($this->_language);
        $this->view->translate = $this->_translate;
    }

    protected function _setUser()
    {
        //Set user here
        if($this->session->has('user')){
            $this->_user = $this->session->get('user');
        }
        $this->view->user = $this->_user;
    }

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

    protected function _setWebsite()
    {
        $this->_allowedWebsite = ($this->session->has("allowed_websites"))?$this->session->get("allowed_websites"):null;
        $this->_website = ($this->session->has("website"))?$this->session->get("website"):null;

//        if($this->session->has("allowed_websites")){
//            $this->_allowedWebsite = $this->session->get("allowed_websites");
//        }
//
//        if($this->session->has('website')){
//            $this->_website = $this->session->get('website');
//        }
        $this->view->allowed_website = $this->_allowedWebsite;
        $this->view->website = $this->_website;
    }

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




