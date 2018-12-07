<?php
namespace Backoffice\Ajax\Controllers;

use System\Datalayer\DLGame;

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

                $category = $DLGame->getByCode($input['code'], $this->_categoryType);
                $main = $DLGame->getByGameParent($category->getId());

                if (count($main) == 0) {
                    return false;
                } else {
                    foreach ($main as $key => $value) {
                        $html = "<option value='" . $value->getCode() . "'>" . $value->getName() . "</option>";
                        $data[] = $html;
                    }
                    $response->setStatusCode(200);
                    $response->setContent(json_encode($data));
                }
            }
        }
        return $response;
    }
}
