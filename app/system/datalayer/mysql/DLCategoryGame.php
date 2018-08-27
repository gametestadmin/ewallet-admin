<?php
namespace System\Datalayer;

use System\Model\Game;

class DLCategoryGame{
//    public function getGameByCode($code){
//        $gameCategory = Game::find(
//            array(
//                "conditions" => "code LIKE '%$code%' AND type != 1",
//            )
//        );
//
//        $array = array(
//            "slot-monkeymadness",
//            "slot-oceanking3"
//        );
//        echo "<pre>";
//        foreach ($array as $key => $value){
//            $query = $this->modelsManager->createQuery("UPDATE System\Model\Game SET code = REPLACE('".$value."','slot','slot2') WHERE code = '".$value."' AND type != 1");
//            $query->execute();
//        }
//        die;
//
//        return $gameCategory;
//    }

    public function getById($id){
        $gameCategory = Game::findFirstById($id);

        return $gameCategory;
    }

    public function getByCode($code){
        $gameCategory = Game::findFirstByCode($code);

        return $gameCategory;
    }

    public function checkByName($name){
        $gameCategory = Game::findFirstByName($name);
        if(!$gameCategory){
            return false;
        }

        return true;
    }

//    public function checkByCodeName($code,$name){
//        $gameCategory = Game::findFirst(
//            array(
//                "conditions" => "code != :code: AND name = :name:",
//                "bind" => array(
//                    "code" => $code,
//                    "name" => $name,
//                )
//            )
//        );
//        if(!$gameCategory){
//            return false;
//        }
//
//        return true;
//    }

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
        if($this->checkByName($data['name'])){
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
        if(isset($data["name"]))$providerGame->setName(ucfirst($data['name']));
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
        $gameCategory = $this->getById($data['id']);

//        if(isset($data["code"]))$gameCategory->setCode(strtolower($data['code']));
        if(isset($data["name"]))$gameCategory->setName($data['name']);
        if(isset($data["status"]))$gameCategory->setStatus($data['status']);


        if(!$gameCategory->save()){
            throw new \Exception($gameCategory->getMessages());
        }
        return $gameCategory;
    }
}