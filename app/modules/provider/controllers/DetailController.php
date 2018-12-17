<?php
namespace Backoffice\Provider\Controllers;

use System\Datalayer\DLProviderGame;
use System\Library\General\GlobalVariable;

class DetailController extends \Backoffice\Controllers\ProtectedController
{
    public function indexAction()
    {
        $view = $this->view;

        $globalVariable = new GlobalVariable();

        $status = $globalVariable::$threeLayerStatusTypes;
        $gmt = $globalVariable->getGmt();

        $currentId = $this->dispatcher->getParam("id");

        $dlProviderGame = new DLProviderGame();
        $providerGame = $dlProviderGame->findFirstById($currentId);

        if(!isset($currentId) || !$providerGame){
            $this->flash->error("undefined_provider_id");
            $this->response->redirect($this->_module."/list/")->send();
        }

        $view->provider = $providerGame;
        $view->gmt = $gmt;
        $view->status = $status;

        \Phalcon\Tag::setTitle("Update Game Provider - ".$this->_website->title);
    }
}
