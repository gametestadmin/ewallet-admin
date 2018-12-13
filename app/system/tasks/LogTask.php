<?php

class LogTask extends \Phalcon\Cli\Task
{

    public function GameaccessAction()
    {
        $sql = "SELECT * FROM api.user_player_game_access_log where game_category is null " ;
        $games_access_list = $this->postgre->query( $sql )->fetchAll();

//        $this->postgre->query( $sql )->execute($sql);
        echo "here it is" ;
        var_dump($games_access_list);


    }
}
