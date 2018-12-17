<?php
namespace Backoffice\Ajax\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLProviderGame;

class GameController extends \Backoffice\Controllers\BaseController
{
    protected $_categoryType = 1;
    protected $_mainType = 2;

    public function addAction()
    {
        $this->view->disable();

        if ($this->request->getPost()) {
            $input = $this->request->getPost();

            try {
                $this->db->begin();

                $response = new \Phalcon\Http\Response();
                $response->setContentType("application/json");

                $input['type'] = $this->_mainType;

                $DLGame = new DLGame();
                $filterData = $DLGame->filterMainInput($input);
                $DLGame->validateMainAdd($filterData);
                $create = $DLGame->createMain($filterData);

                $this->db->commit();
                $data = $create->getCode()."|".$create->getName();

                $response->setStatusCode(200);
                $response->setContent(json_encode($data));

                return $response;
            } catch (\Exception $e) {
                $this->db->rollback();
//                var_dump($e->getMessage());
//                die;
                return false;
            }
        }
    }

    public function listAction()
    {
        $this->view->disable();

        $response = array();
        $data = array();
        if ($this->request->getPost()) {
            $input = $this->request->getPost();

            if (isset($input['code'])) {
                $response = new \Phalcon\Http\Response();
                $response->setContentType("application/json");

                $DLGame = new DLGame();

//                $category = $DLGame->getByCode($input['code'], $this->_categoryType);
//                $main = $DLGame->getByGameParent($category->getId());
                $category = $DLGame->findByCode($this->_categoryType,$input['code']);
                $game = $DLGame->findByGameParentAndStatus($category['id']);

                if (count($game) == 0) {
                    return false;
                } else {
                    foreach ($game as $key => $value) {
                        $html = "<option value='".$value['cd']."'>".$value['nm']."</option>";
                        $data[] = $html;
                    }
                    $response->setStatusCode(200);
                    $response->setContent(json_encode($data));
                }
            }elseif(isset($input['mainCode'])){
                $dlGame = new DLGame();
                $dlProvider = new DLProviderGame();

                $category = $dlGame->findByCode($this->_mainType,$input['mainCode']);
                $provider = $dlProvider->findFirstById($category['idpv']);

                return $provider['id']."|".$provider['nm'];
            }
        }
        return $response;
    }

    public function testAction()
    {
        echo "<pre>";
        $dlGame = new DLGame();
        $dlProvider = new DLProviderGame();

        $input['mainCode'] = "SLOTPRAGMATIC";
        $category = $dlGame->findByCode($this->_mainType,$input['mainCode']);
        $provider = $dlProvider->findFirstById($category['idpv']);

        var_dump($category);
        echo "<br>";
        var_dump($provider);
//        return $provider['id']."|".$provider['nm'];
        die;
    }
}
