<?php
namespace System\Widgets;

use System\Datalayer\DLUserPlayer ;
use System\Datalayer\DLUserPlayerGameTransactionHistory ;
use System\Datalayer\DLGame ;
use System\Library\General\GlobalVariable ;

class ReportTransactionHistoryWidget extends BaseWidget
{
    public function getContent()
    {
        $data = $this->params['data'];
        $realuser = $this->params['realuser'];
        $player_id = $this->params['player_id'];

        $data['date_start'] = date('Y-m-d 00:00:00', strtotime($data['date_start']) );
        $data['date_end'] = date('Y-m-d 23:59:59', strtotime($data['date_end']) );

        $DLUserPlayerGameTransactionHistory = new DLUserPlayerGameTransactionHistory();
        $transactionhistory = $DLUserPlayerGameTransactionHistory->getUserPlayerGamesTransactionHistory($data , $realuser->getType() , $player_id , $realuser->getId() );

        $DLGame = new DLGame();
        $gamelist = $DLGame->getAllinArray();
        $TransactionType = GlobalVariable::$TransactionType;

        $DLUserPlayer= new DLUserPlayer();
        $user_player = $DLUserPlayer->getUserPlayerArrayIdUsername($realuser->getType() , $realuser->getId() , null);

        return $this->setView('report/transactionhistory', [
            'transactionhistory' => $transactionhistory,
            'transactiontype' => $TransactionType,
            'game_list' => $gamelist,
            'playerside' => $player_id,
            'user_player' => $user_player,
        ]);
    }
}