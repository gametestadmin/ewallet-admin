<?php
namespace System\Datalayer;

use System\Model\Game;

class DLMainGame{
    public function getById($id){
        $mainGame = Game::findFirstById($id);

        return $mainGame;
    }

    public function getByGameParent($id){
        $mainGame = Game::findFirstByGameParent($id);

        return $mainGame;
    }

    public function getByCode($code){
        $mainGame = Game::findFirst(
            array(
                "conditions" => "code = :code: AND type = 2",
                "bind" => array(
                    "code" => $code
                )
            )
        );

        return $mainGame;
    }

    public function checkByProviderAndName($provider,$name){
        $mainGame = Game::findFirst(
            array(
                "conditions" => "provider = :provider: AND name = :name:",
                "bind" => array(
                    "name" => $name,
                    "provider" => $provider,
                )
            )
        );
        if(!$mainGame){
            return false;
        }

        return true;
    }

    public function checkByIdName($id,$name){
        $mainGame = Game::findFirst(
            array(
                "conditions" => "id != :id: AND name = :name:",
                "bind" => array(
                    "id" => $id,
                    "name" => $name,
                )
            )
        );
        if(!$mainGame){
            return false;
        }

        return true;
    }

    public function filterInput($data){
        $data['provider'] = \filter_var(\strip_tags(\addslashes($data['provider'])), FILTER_SANITIZE_STRING);
        $data['category'] = \filter_var(\strip_tags(\addslashes($data['category'])), FILTER_SANITIZE_STRING);
        $data['name'] = \filter_var(\strip_tags(\addslashes($data['main_name'])), FILTER_SANITIZE_STRING);
        $data['status'] = \intval($data['status']);

        return $data;
    }

    public function validateAdd($data){
        if(empty($data['provider'])){
            throw new \Exception('choose_provider_field');
        }elseif(empty($data['category'])){
            throw new \Exception('choose_category_field');
        }elseif($this->checkByProviderAndName($data['provider'],$data['name'])){
            throw new \Exception('main_name_exist');
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
        $parentCategory = $this->getById($data['category']);
        $mainGame = new Game();

        $name = str_replace(" ","",$data['name']);
        if(isset($data["provider"]))$mainGame->setProvider($data['provider']);
        if(isset($data["category"]))$mainGame->setGameParent($data['category']);
        if(isset($data["name"]))$mainGame->setName(ucfirst($data['name']));
        $mainGame->setType(2);
        $mainGame->setCode(strtolower($parentCategory->getCode()."-".$name));
        $mainGame->setParentStatus($parentCategory->getStatus());
        $mainGame->setStatus($data['status']);

        if(!$mainGame->save()){
            throw new \Exception($mainGame->getMessages());
        }
        return true;
    }

    public function set($data){
        $data = $this->filterInput($data);
        $this->validateEdit($data);
        $gameCategory = $this->getById($data['id']);
        $gameParent = $this->getByGameParent($gameCategory->getGameParent());

        var_dump($gameParent);
        die;

        if(isset($data["name"]))$gameCategory->setName($data['name']);
        if(isset($data["status"]))$gameCategory->setStatus($data['status']);


        if(!$gameCategory->save()){
            throw new \Exception($gameCategory->getMessages());
        }
        return $gameCategory;
    }
}