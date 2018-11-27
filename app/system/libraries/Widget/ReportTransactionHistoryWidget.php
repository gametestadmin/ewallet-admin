<?php
namespace System\Widgets;

use System\Datalayer\DLUserPlayerGameAccessLog ;
use System\Datalayer\DLGame ;

class ReportTransactionHistoryWidget extends BaseWidget
{
    public function getContent()
    {
        $data = $this->params['data'];
        $realuser = $this->params['realuser'];
        $player_id = $this->params['player_id'];

        $data['date_start'] = date('Y-m-d 00:00:00', strtotime($data['date_start']) );
        $data['date_end'] = date('Y-m-d 23:59:59', strtotime($data['date_end']) );

        $DLUserPlayerGameAccessLog = new DLUserPlayerGameAccessLog();
        $game_access_log = $DLUserPlayerGameAccessLog->getUserPlayerGamesAccessList($data , $realuser->getType() , $player_id , $realuser->getId() );

        $DLGame = new DLGame();
        $gamelist = $DLGame->getAllinArray();


        return $this->setView('report/transactionhistory', [
            'game_access_log' => $game_access_log,
            'game_list' => $gamelist
        ]);
    }
}