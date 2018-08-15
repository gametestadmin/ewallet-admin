<?php

namespace Backoffice\Controllers;

class IndexController extends \Backoffice\Controllers\BaseController
{
    public function indexAction()
    {
        $view = $this->view;

//        if($this->request->has("flash")) {
            $this->noticeFlash("user");
            $this->errorFlash("add");
            $this->successFlash("success");
//        }
        $this->_translate["test_new"];

        \Phalcon\Tag::setTitle($this->_website->title);
    }

    public function languageAction()
    {
        $this->view->disable();

        if(!$this->request->has("code")){
//            return $this->response->redirect("/content-editor/edit?id=".$content->getId());
        }

        //check exist di db
        $code = $this->request->get("code");
        $this->cookies->set('language', $code);

        echo $_SERVER['HTTP_REFERER'];
        return $this->response->redirect($_SERVER['HTTP_REFERER']);
    }

}