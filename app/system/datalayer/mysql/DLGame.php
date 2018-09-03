<?php
namespace System\Datalayer;

use System\Model\Game;

class DLGame{
    public function getAll($type){
        $game = Game::find(
            array(
                "conditions" => "type = ".$type.""
            )
        );
        return $game;
    }

    public function getById($id){
        $gameCategory = Game::findFirstById($id);

        return $gameCategory;
    }

    public function getByGameParent($id){
        $gameCategory = Game::findByGameParent($id);

        return $gameCategory;
    }

    public function getByCode($code){
        $gameCategory = Game::findFirst(
            array(
                "conditions" => "code = :code: AND type = 1",
                "bind" => array(
                    "code" => $code
                )
            )
        );

        return $gameCategory;
    }

    public function checkByName($name,$type){
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

    public function checkByIdName($id,$name){
        $gameCategory = Game::findFirst(
            array(
                "conditions" => "id != :id: AND name = :name:",
                "bind" => array(
                    "id" => $id,
                    "name" => $name,
                )
            )
        );
        if(!$gameCategory){
            return false;
        }

        return true;
    }

    public function filterCategoryInput($data){
        $data['type'] = \intval($data['type']);
        $data['name'] = \filter_var(\strip_tags(\addslashes($data['category_name'])), FILTER_SANITIZE_STRING);
        $data['code'] = \filter_var(\strip_tags(\addslashes($data['category_code'])), FILTER_SANITIZE_STRING);

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

    public function validateEdit($data){
        if($this->checkByIdName($data['id'],$data['name'])){
            throw new \Exception('category_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('category_name_empty');
        }elseif($data['status']<0 || $data['status']>2){
            throw new \Exception('undefined_category_status');
        }

        return true;
    }

    public function createCategory($data){
        $data = $this->filterCategoryInput($data);
        $this->validateCategoryAdd($data);
        $gameCategory = new Game();

        $gameCategory->setType(1);
        if(isset($data["code"]))$gameCategory->setCode(strtolower($data['code']));
        if(isset($data["name"]))$gameCategory->setName(ucfirst($data['name']));
        $gameCategory->setParentStatus(1);

        if(!$gameCategory->save()){
            throw new \Exception($gameCategory->getMessages());
        }
        return true;
    }

    public function set($data){
        $data = $this->filterInput($data);
        $this->validateEdit($data);
        $gameCategory = $this->getById($data['id']);
//        $gameParent = $this->getByGameParent($data['id']);


        if(isset($data["name"]))$gameCategory->setName($data['name']);
        if(isset($data["status"]))$gameCategory->setStatus($data['status']);
        $gameCategory->setParentStatus($data['status']);

//        foreach ($gameParent as $key => $value){
//            $value->setParentStatus($gameCategory->getStatus());
//        }

        $gameParent = Game::findByGameParent($data['id']);
        foreach ($gameParent as $key => $value){
            $parent = Game::findFirstById($value->getId());
            $parent->setParentStatus($data['status']);

            if(!$parent->save()){
                throw new \Exception($gameCategory->getMessages());
            }
        }
        if(!$gameCategory->save()){
            throw new \Exception($gameCategory->getMessages());
        }
        return $gameCategory;
    }
}