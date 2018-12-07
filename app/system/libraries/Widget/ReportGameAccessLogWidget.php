<?php
namespace System\Widgets;

use System\Datalayer\DLUserPlayer ;
use System\Datalayer\DLUserPlayerGameAccessLog ;
use System\Datalayer\DLGame ;

class ReportGameAccessLogWidget extends BaseWidget
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

        $DLUserPlayer= new DLUserPlayer();
        $user_player = $DLUserPlayer->getUserPlayerArrayIdUsername($realuser->getType() , $realuser->getId() , null);

        $DLGame = new DLGame();
        $gamelist = $DLGame->getAllinArray();

        return $this->setView('report/gamesaccesslog', [
            'game_access_log' => $game_access_log,
            'game_list' => $gamelist,
            'playerside' => $player_id,
            'user_player' => $user_player,
        ]);
    }
}