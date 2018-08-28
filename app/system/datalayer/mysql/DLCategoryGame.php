<?php
namespace System\Datalayer;

use System\Model\Game;

class DLCategoryGame{
    public function getAll(){
        $categoryGame = Game::find(
            array(
                "conditions" => "type = 1 AND status = 1"
            )
        );

        return $categoryGame;
    }

    public function getById($id){
        $gameCategory = Game::findFirstById($id);

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

    public function checkByName($name){
        $gameCategory = Game::findFirstByName($name);
        if(!$gameCategory){
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

    public function filterInput($data){
        $data['name'] = \filter_var(\strip_tags(\addslashes($data['category_name'])), FILTER_SANITIZE_STRING);
        $data['code'] = str_replace("-"," ",$data['name']);
        $data['status'] = \intval($data['status']);

        return $data;
    }

    public function validateAdd($data){
        if($this->checkByName($data['name'])){
            throw new \Exception('category_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('category_name_empty');
        }elseif($data['status']<0 || $data['status']>1){
            throw new \Exception('undefined_category_status');
        }

        return true;
    }

    public function validateEdit($data){
        if($this->checkByIdName($data['id'],$data['name'])){
            throw new \Exception('category_name_exist');
        }elseif(empty($data['name'])){
            throw new \Exception('category_name_empty');
        }elseif($data['status']<0 || $data['status']>1){
            throw new \Exception('undefined_category_status');
        }

        return true;
    }

    public function create($data){
        $data = $this->filterInput($data);
        $this->validateAdd($data);
        $gameCategory = new Game();

        $gameCategory->setType(1);
        if(isset($data["code"]))$gameCategory->setCode($data['code']);
        if(isset($data["name"]))$gameCategory->setName(ucfirst($data['name']));
        $gameCategory->setParentStatus(1);
        if(isset($data["status"]))$gameCategory->setStatus($data['status']);

        if(!$gameCategory->save()){
            throw new \Exception($gameCategory->getMessages());
        }
        return true;
    }

    public function set($data){
        $data = $this->filterInput($data);
        $this->validateEdit($data);
        $gameCategory = $this->getById($data['id']);

        if(isset($data["name"]))$gameCategory->setName($data['name']);
        if(isset($data["status"]))$gameCategory->setStatus($data['status']);


        if(!$gameCategory->save()){
            throw new \Exception($gameCategory->getMessages());
        }
        return $gameCategory;
    }
}