<?php
namespace System\Datalayer;

use Backoffice\Controllers\BaseController;

class DLUserPlayer extends BaseController
{
    public function getUserPlayerList($type , $id){
        if($type == 9) {
            $sql = 'SELECT * FROM api.user_player WHERE company_id = '.$id.' AND status = 1 ';
        } else {
            $sql = 'SELECT * FROM api.user_player WHERE agent_id = '.$id.' AND status = 1 ';
        }
        $user_player = $this->postgre->query( $sql )->fetchAll();

        return $user_player ;
    }

    public function getUserPlayer($type , $agent_id , $player_id){
        if( $type == 9) {
            $sql = 'SELECT * FROM api.user_player WHERE company_id = '.$agent_id.' AND id = '.$player_id.' AND status = 1 ';
        } else {
            $sql = 'SELECT * FROM api.user_player WHERE agent_id = '.$agent_id.' AND id = '.$player_id.'  AND status = 1 ';
        }
        $user_player = $this->postgre->query( $sql )->fetchArray();


        return $user_player ;
    }







}


