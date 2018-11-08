<?php
namespace System\Datalayer;

use System\Model\Game;

class DLGame extends \System\Datalayers\Main{
    // DSS
    public function findGameType($type,$status = null){
        if ($status <> null){
            $postData = array(
                'ty' => $type,
                'st' => $status
            );
        }else{
            $postData = array(
                'ty' => $type
            );
        }

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        return $game;
    }

    public function findByCode($code, $type){
        $postData = array(
            'cd' => $code,
            'ty' => $type
        );

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        return $game;
//        $gameCategory = Game::findFirst(
//            array(
//                "conditions" => "code = :code: AND type = :type:",
//                "bind" => array(
//                    "code" => $code,
//                    "type" => $type
//                )
//            )
//        );
//        return $gameCategory;
    }

    public function findByNameAndType($name,$type){
        $postData = array(
            'nm' => $name,
            'ty' => $type
        );

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        return $game;

//        $game = Game::findFirst(
//            array(
//                "conditions" => "name = :name: AND type = :type:",
//                "bind" => array(
//                    "name" => $name,
//                    "type" => $type
//                )
//            )
//        );
//
//        if(!$game){
//            return false;
//        }
//
//        return true;
    }

    protected function findByIdAndName($id,$name){
        $postData = array(
            'id' => $id,
            'nm' => $name
        );

        $url = '/game/find';
        $game = $this->curlAppsJson($url, $postData);

        return $game;
//        $game = Game::findFirst(
//            array(
//                "conditions" => "id != :id: AND name = :name:",
//                "bind" => array(
//                    "id" => $id,
//                    "name" => $name,
//                )
//            )
//        );
//        if(!$game){
//            return false;
//        }
//
//        return true;
    }

    public function filterCategoryData($data){
        if(isset($data["id"]))$data['id'] = \intval($data['id']);
        if(isset($data["type"]))$data['ty'] = \intval($data['type']);
        $data['nm'] = \filter_var(\strip_tags(\addslashes($data['category_name'])), FILTER_SANITIZE_STRING);
        if(isset($data["category_code"]))$data['cd'] = \filter_var(\strip_tags(\addslashes($data['category_code'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function validateCategoryAddData($data){
        if($this->findByNameAndType($data['nm'],$data['ty'])){
            throw new \Exception('category_name_exist');
        }elseif(empty($data['nm'])){
            throw new \Exception('category_name_empty');
        }

        return true;
    }

    public function validateCategoryEditData($data){
        if($this->findByIdAndName($data['id'],$data['nm'])){
            throw new \Exception('category_name_exist');
        }elseif(empty($data['nm'])){
            throw new \Exception('category_name_empty');
        }
        return true;
    }

    public function createCategoryData($postData){
        $url = '/game/insert';
        $category = $this->curlAppsJson($url, $postData);

        return $category;

//        $gameCategory = new Game();
//
//        $gameCategory->setType($data['type']);
//        if(isset($data["code"]))$gameCategory->setCode(strtolower($data['code']));
//        if(isset($data["name"]))$gameCategory->setName(ucfirst($data['name']));
//
//        if(!$gameCategory->save()){
//            throw new \Exception($gameCategory->getMessages());
//        }
//        return $gameCategory;
    }

    public function setCategoryData($postData){
        $url = '/game/'.$postData['id'].'/update';
        $category = $this->curlAppsJson($url, $postData);

        return $category;
//        $gameCategory = $this->getById($data['id']);
//
//        if(isset($data["name"]))$gameCategory->setName(ucfirst($data['name']));
//
//        if(!$gameCategory->save()){
//            throw new \Exception($gameCategory->getMessages());
//        }
//        return $gameCategory;
    }

    public function filterMainData($data){
        $data['type'] = \intval($data['type']);
        $data['name'] = \filter_var(\strip_tags(\addslashes($data['main_name'])), FILTER_SANITIZE_STRING);
        if(isset($data["main_code"]))$data['code'] = \filter_var(\strip_tags(\addslashes($data['main_code'])), FILTER_SANITIZE_STRING);
        if(isset($data["provider"]))$data['provider'] = \filter_var(\strip_tags(\addslashes($data['provider'])), FILTER_SANITIZE_STRING);
        if(isset($data["category"]))$data['category'] = \filter_var(\strip_tags(\addslashes($data['category'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function validateMainAddData($data){
        if(empty($data['provider'])){
            throw new \Exception('provider_name_empty');
        }elseif(empty($data['category'])){
            throw new \Exception('category_name_empty');
        }elseif($this->checkByName($data['name'],$data['type'])){
            throw new \Exception('main_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('main_name_empty');
        }

        return true;
    }

    public function validateGameEditData($data){
        if($this->checkByIdName($data['id'],$data['name'])){
            throw new \Exception('main_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('main_name_empty');
        }
        return true;
    }

    public function createGameData($data){
        $game = new Game();
        $category = $this->getByCodeOnly($data['category']);

        $game->setType($data['type']);
        if(isset($data["provider"]))$game->setProvider($data['provider']);
        if(isset($data["category"]))$game->setGameParent($category->getId());
        if(isset($data["code"]))$game->setCode(strtolower($data["category"]."-".$data['code']));
        if(isset($data["name"]))$game->setName(ucfirst($data['name']));

        if(!$game->save()){
            throw new \Exception($game->getMessages());
        }

        return $game;
    }

    public function setGameData($data){
        $mainGame = $this->getById($data['id']);

        if(isset($data["name"]))$mainGame->setName(ucfirst($data['name']));

        if(!$mainGame->save()){
            throw new \Exception($mainGame->getMessages());
        }
        return $mainGame;
    }

    // END DSS

    public function getAll($type){
        $game = Game::find(
            array(
                "conditions" => "type = :type:",
                "bind" => array(
                    "type" => $type,
                )
            )
        );
        return $game;
    }

    public function getById($id){
        $game = Game::findFirstById($id);

        return $game;
    }

    public function getByGameParent($id){
        $game = Game::findByGameParent($id);

        return $game;
    }

    public function getByGameParentAndGame($category,$id){
        $game = Game::findFirst(
            array(
                "conditions" => "game_parent = :category: AND id = :id:",
                "bind" => array(
                    "category" => $category,
                    "id" => $id
                )
            )
        );

        return $game;
    }

    public function getByCode($code, $type){
        $gameCategory = Game::findFirst(
            array(
                "conditions" => "code = :code: AND type = :type:",
                "bind" => array(
                    "code" => $code,
                    "type" => $type
                )
            )
        );
        return $gameCategory;
    }

    public function getByCodeOnly($code){
        $gameCategory = Game::findFirst(
            array(
                "conditions" => "code = :code:",
                "bind" => array(
                    "code" => $code,
                )
            )
        );
        return $gameCategory;
    }

    protected function checkByName($name,$type){
        $game = Game::findFirst(
            array(
                "conditions" => "name = :name: AND type = :type:",
                "bind" => array(
                    "name" => $name,
                    "type" => $type
                )
            )
        );

        if(!$game){
            return false;
        }

        return true;
    }

    protected function checkByIdName($id,$name){
        $game = Game::findFirst(
            array(
                "conditions" => "id != :id: AND name = :name:",
                "bind" => array(
                    "id" => $id,
                    "name" => $name,
                )
            )
        );
        if(!$game){
            return false;
        }

        return true;
    }

    public function filterCategoryInput($data){
        $data['type'] = \intval($data['type']);
        $data['name'] = \filter_var(\strip_tags(\addslashes($data['category_name'])), FILTER_SANITIZE_STRING);
        if(isset($data["category_code"]))$data['code'] = \filter_var(\strip_tags(\addslashes($data['category_code'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function validateCategoryAdd($data){
        if($this->checkByName($data['name'],$data['type'])){
            throw new \Exception('category_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('category_name_empty');
        }

        return true;
    }

    public function validateCategoryEdit($data){
        if($this->checkByIdName($data['id'],$data['name'])){
            throw new \Exception('category_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('category_name_empty');
        }
        return true;
    }

    public function createCategory($data){
        $gameCategory = new Game();

        $gameCategory->setType($data['type']);
        if(isset($data["code"]))$gameCategory->setCode(strtolower($data['code']));
        if(isset($data["name"]))$gameCategory->setName(ucfirst($data['name']));

        if(!$gameCategory->save()){
            throw new \Exception($gameCategory->getMessages());
        }
//        return $gameCategory->getCode();
        return $gameCategory;
    }

    public function setCategory($data){
        $gameCategory = $this->getById($data['id']);

        if(isset($data["name"]))$gameCategory->setName(ucfirst($data['name']));

        if(!$gameCategory->save()){
            throw new \Exception($gameCategory->getMessages());
        }
        return $gameCategory;
    }

    public function filterMainInput($data){
        $data['type'] = \intval($data['type']);
        $data['name'] = \filter_var(\strip_tags(\addslashes($data['main_name'])), FILTER_SANITIZE_STRING);
        if(isset($data["main_code"]))$data['code'] = \filter_var(\strip_tags(\addslashes($data['main_code'])), FILTER_SANITIZE_STRING);
        if(isset($data["provider"]))$data['provider'] = \filter_var(\strip_tags(\addslashes($data['provider'])), FILTER_SANITIZE_STRING);
        if(isset($data["category"]))$data['category'] = \filter_var(\strip_tags(\addslashes($data['category'])), FILTER_SANITIZE_STRING);

        return $data;
    }

    public function validateMainAdd($data){
        if(empty($data['provider'])){
            throw new \Exception('provider_name_empty');
        }elseif(empty($data['category'])){
            throw new \Exception('category_name_empty');
        }elseif($this->checkByName($data['name'],$data['type'])){
            throw new \Exception('main_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('main_name_empty');
        }

        return true;
    }

    public function validateMainEdit($data){
        if($this->checkByIdName($data['id'],$data['name'])){
            throw new \Exception('main_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('main_name_empty');
        }
        return true;
    }

    public function createMain($data){
        $game = new Game();
        $category = $this->getByCodeOnly($data['category']);

        $game->setType($data['type']);
        if(isset($data["provider"]))$game->setProvider($data['provider']);
        if(isset($data["category"]))$game->setGameParent($category->getId());
        if(isset($data["code"]))$game->setCode(strtolower($data["category"]."-".$data['code']));
        if(isset($data["name"]))$game->setName(ucfirst($data['name']));

        if(!$game->save()){
            throw new \Exception($game->getMessages());
        }

        return $game;
    }

    public function setMain($data){
        $mainGame = $this->getById($data['id']);

        if(isset($data["name"]))$mainGame->setName(ucfirst($data['name']));

        if(!$mainGame->save()){
            throw new \Exception($mainGame->getMessages());
        }
        return $mainGame;
    }

    public function filterSubInput($data){
        $data['type'] = \intval($data['type']);
        $data['name'] = \filter_var(\strip_tags(\addslashes($data['sub_name'])), FILTER_SANITIZE_STRING);
        if(isset($data["sub_code"]))$data['code'] = \filter_var(\strip_tags(\addslashes($data['sub_code'])), FILTER_SANITIZE_STRING);
        if(isset($data["provider"]))$data['provider'] = \filter_var(\strip_tags(\addslashes($data['provider'])), FILTER_SANITIZE_STRING);
        if(isset($data["category"]))$data['category'] = \filter_var(\strip_tags(\addslashes($data['category'])), FILTER_SANITIZE_STRING);
        if(isset($data["main"]))$data['main'] = \filter_var(\strip_tags(\addslashes($data['main'])), FILTER_SANITIZE_STRING);
        if(isset($data["sub_name"]))$data['sub_name'] = \filter_var(\strip_tags(\addslashes($data['sub_name'])), FILTER_SANITIZE_STRING);
        $data['parent_currency'] = (isset($data['parent_currency'])?1:0);

        return $data;
    }

    public function validateSubAdd($data){
        if(empty($data['provider'])){
            throw new \Exception('provider_name_empty');
        }elseif(empty($data['category'])){
            throw new \Exception('category_name_empty');
        }elseif(empty($data['main'])){
            throw new \Exception('main_game_empty');
        }elseif(empty($data['sub_name'])){
            throw new \Exception('sub_game_empty');
        }elseif(empty($data['code'])){
            throw new \Exception('sub_code_game_empty');
        }elseif($this->checkByName($data['name'],$data['type'])){
            throw new \Exception('main_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('main_name_empty');
        }

        return true;
    }

    public function validateSubEdit($data){
        if($this->checkByIdName($data['id'],$data['name'])){
            throw new \Exception('main_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('main_name_empty');
        }
        return true;
    }

    public function createSub($data){
        $game = new Game();
        $main = $this->getByCodeOnly($data['main']);

        $game->setType($data['type']);
        if(isset($data["provider"]))$game->setProvider($data['provider']);
//        if(isset($data["category"]))$game->setGameParent($main->getId());
        if(isset($data["main"]))$game->setGameParent($main->getId());
        if(isset($data["code"]))$game->setCode(strtolower($data["main"]."-".$data['code']));
        if(isset($data["name"]))$game->setName(ucfirst($data['name']));

        if(!$game->save()){
            throw new \Exception($game->getMessages());
        }

        return $game;
    }

    public function setSub($data){
        $mainGame = $this->getById($data['id']);

        if(isset($data["name"]))$mainGame->setName(ucfirst($data['name']));

        if(!$mainGame->save()){
            throw new \Exception($mainGame->getMessages());
        }
        return $mainGame;
    }

//    public function setStatus($id, $status){
//        $this->setParentStatus($id, $status);
//        $this->setChildStatus($id, $status);
//        return true;
//    }
//
//    protected function setParentStatus($id, $status){
//        $game = Game::findFirstById($id);
//        $game->setStatus($status);
//        $game->save();
//
//        return true;
//    }
//    protected function setChildStatus($id, $status){
//        $game = Game::findFirstById($id);
//
//        if($game) {
//            $gameParent = Game::findByGameParent($game->getId());
//
//            foreach ($gameParent as $key => $value) {
//                if($status == 1 && ($value->getParentStatus() == 2 || $value->getParentStatus() == 0)){
//                    $childStatus = 1;
//                }elseif($status == 2 && ($value->getParentStatus() == 2 || $value->getParentStatus() == 1)){
//                    $childStatus = 2;
//                }else{
//                    $childStatus = 0;
//                }
//                $value->setParentStatus($childStatus);
//                $value->save();
//
//                self::setChildStatus($value->getId(), $childStatus);
//            }
//        }
//        return true;
//    }


    public function setStatus($id, $status){
        $this->setGameStatus($id, $status);

        return true;
    }

    protected function setGameStatus($id, $status){
        $game = $this->getById($id);
        $game->setStatus($status);
        $game->save();

        $this->setChildParentStatus($id, $status, $game->getParentStatus());

        return true;
    }

    protected function setChildParentStatus($parentId, $parentStatus, $grandParentStatus){
        $childParentStatus = 1;
        if($grandParentStatus == 0 || $parentStatus == 0){
            $childParentStatus = 0;
        }else if($grandParentStatus == 2 || $parentStatus == 2){
            $childParentStatus = 2;
        }

        //get childs
        $childs = $this->getByGameParent($parentId);

        foreach ($childs as $child){
            $child->setParentStatus($childParentStatus);
            $child->save();

            //change all childs parent status
            $this->setChildParentStatus($child->getId(), $child->getStatus(), $childParentStatus);
        }
        return true;
    }
}