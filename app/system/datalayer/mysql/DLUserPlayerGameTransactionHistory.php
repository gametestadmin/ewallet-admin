<?php
namespace System\Datalayer;

use Backoffice\Controllers\BaseController;

class DLUserPlayerGameTransactionHistory extends BaseController
{
    public function getUserPlayerGamesTransactionHistory($data , $type , $player_id = null , $agent_id ){
        if ( $data['type'] == 0) $data['type'] = 'type';
        if ( is_null($player_id)) $player_id = 'user_player';
        if($type == 9) {
            $sql = "SELECT * FROM api.user_player_game_transaction_history WHERE user_player = " .$player_id. " 
            AND company = ".$agent_id." AND type = ".$data['type']." AND transaction_date >= ' ".$data['date_start']." ' AND transaction_date <= ' ".$data['date_end']." '
            ORDER BY transaction_date DESC";
        } else {
            $sql = "SELECT * FROM api.user_player_game_transaction_history WHERE user_player = " .$player_id. " 
            AND agent = ".$agent_id." AND type = ".$data['type']."  transaction_date >= ' ".$data['date_start']." ' AND transaction_date <= ' ".$data['date_end']." '
            ORDER BY transaction_date DESC";
        }
        $games_access_list = $this->postgre->query( $sql )->fetchAll();

        return $games_access_list ;
    }









}


