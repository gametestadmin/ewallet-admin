<?php
namespace System\Datalayer;

use Backoffice\Controllers\BaseController;

class DLUserPlayerGameAccessLog extends BaseController
{
    public function getUserPlayerGamesAccessList($data , $type , $player_id = null , $agent_id ){
        if ( $data['game'] == 0) $data['game'] = 'game_category';
        if (is_null($player_id)) $player_id = 'user_player';
        if($type == 9) {
            $sql = "SELECT * FROM api.user_player_game_access_log WHERE user_player = " .$player_id. " 
            AND company = ".$agent_id." AND game_category = ".$data['game']." AND access_time >= ' ".$data['date_start']." ' AND access_time <= ' ".$data['date_end']." '
            ORDER BY access_time DESC";
        } else {
            $sql = "SELECT * FROM api.user_player_game_access_log WHERE user_player = " .$player_id. " 
            AND agent = ".$agent_id." AND game_category = ".$data['game']."  access_time >= ' ".$data['date_start']." ' AND access_time <= ' ".$data['date_end']." '
            ORDER BY access_time DESC";
        }
        $games_access_list = $this->postgre->query( $sql )->fetchAll();

        return $games_access_list ;
    }









}


