<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLProviderGame;

class AjaxController extends \Backoffice\Controllers\BaseController
{
    protected $_categoryType = 1;
    protected $_mainType = 2;
    public function indexAction()
    {
        $view = $this->view;

        if ($this->request->getPost()) {
            $data = $this->request->getPost();

            $action = $this->request->get('action');

            if(isset($data['code'])){
                $DLGame = new DLGame();

                $category = $DLGame->getByCode($data['code'], $this->_categoryType);
                $main = $DLGame->getByGameParent($category->getId());

                foreach ($main as $key => $value){
                    $html = "<option value='".$value->getCode()."'>".$value->getName()."</option>";
                    echo $html;
                }
            }elseif(isset($data['mainCode'])){
                $DLGame = new DLGame();
                $DLProvider = new DLProviderGame();

                $category = $DLGame->getByCode($data['mainCode'], $this->_mainType);
                $provider = $DLProvider->getById($category->getProvider());

                echo $provider->getId()."|".$provider->getName();

            }elseif(isset($action)){
                if($action == "sub"){
                    try {
                        $this->db->begin();
                        $data['type'] = $this->_mainType;

                        $DLGame = new DLGame();
                        $filterData = $DLGame->filterMainInput($data);
                        $DLGame->validateMainAdd($filterData);
                        $create = $DLGame->createMain($filterData);

                        $this->db->commit();
                        echo $create->getCode()."|".$create->getName();
                    } catch (\Exception $e) {
                        $this->db->rollback();
                        var_dump($e->getMessage());
                    }
                }
            }else {
                try {
                    $this->db->begin();
                    $data['type'] = $this->_categoryType;

                    $DLGame = new DLGame();
                    $filterData = $DLGame->filterCategoryInput($data);
                    $DLGame->validateCategoryAdd($filterData);
                    $create = $DLGame->createCategory($filterData);

                    $this->db->commit();
                    echo $create->getCode()."|".$create->getName();
                } catch (\Exception $e) {
                    $this->db->rollback();
                    echo "error";
                }
            }
        }

        \Phalcon\Tag::setTitle("Game Category - ".$this->_website->title);

        exit();
    }
}
