<?php
namespace Backoffice\Game\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLProviderGame;

class AjaxController extends \Backoffice\Controllers\ProtectedController
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

//                echo "<pre>";
                $result = array();
                if(count($main) == 0){
                    return false;
                }else {
                    foreach ($main as $key) {
                        $html = "<option value='" . $key->getCode() . "'>" . $key->getName() . "</option>";
                        $result[] = $html;
//                        var_dump($html);
                    }
//                    die;
                    return $result;
                }
//                var_dump($category->getId());
//                foreach ($main as $key){
//                    var_dump($key->getName());
//                }
//                die;
            }elseif(isset($data['mainCode'])){
                $DLGame = new DLGame();
                $DLProvider = new DLProviderGame();

                $category = $DLGame->getByCode($data['mainCode'], $this->_mainType);
                $provider = $DLProvider->getById($category->getProvider());

                return $provider->getId()."|".$provider->getName();

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
                        return $create->getCode()."|".$create->getName();
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
                    return $create->getCode()."|".$create->getName();
                } catch (\Exception $e) {
                    $this->db->rollback();
                    return "error";
                }
            }
        }

        \Phalcon\Tag::setTitle("Game Category - ".$this->_website->title);
//return true;
    }
}
