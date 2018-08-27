<?php
namespace System\Datalayer;

use System\Model\Game;
use System\Model\ProviderGame;

class DLCategoryGame{
    public function getAll(){
        $providerGame = ProviderGame::find(
            array(
                "conditions" => "status = 1"
            )
        );

        return $providerGame;
    }

    public function getById($id){
        $providerGame = ProviderGame::findFirstById($id);

        return $providerGame;
    }

    public function checkByName($name){
        $providerGame = Game::findFirstByName($name);
        if(!$providerGame){
            return false;
        }

        return true;
    }

    public function checkByIdName($id,$name){
        $providerGame = Game::findFirst(
            array(
                "conditions" => "id != :id: AND name = :name:",
                "bind" => array(
                    "id" => $id,
                    "name" => $name,
                )
            )
        );
        if(!$providerGame){
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
        $providerGame = new Game();

        $providerGame->setType(1);
        if(isset($data["code"]))$providerGame->setCode($data['code']);
        if(isset($data["name"]))$providerGame->setName($data['name']);
        $providerGame->setParentStatus(1);
        if(isset($data["status"]))$providerGame->setStatus($data['status']);

        if(!$providerGame->save()){
            throw new \Exception($providerGame->getMessages());
        }
        return true;
    }

    public function set($data){
        $data = $this->filterInput($data);
        $this->validateEdit($data);
        $providerGame = $this->getById($data['id']);

        if(isset($data["timezone"]))$providerGame->setTimezone($data['timezone']);
        if(isset($data["name"]))$providerGame->setName($data['name']);
        if(isset($data["status"]))$providerGame->setStatus($data['status']);

        if(!$providerGame->save()){
            throw new \Exception($providerGame->getMessages());
        }
        return true;
    }
}