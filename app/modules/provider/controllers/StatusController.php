<?php
namespace Backoffice\Provider\Controllers;

use System\Datalayer\DLGame;
use System\Datalayer\DLProviderGame;
use System\Datalayer\DLUserGame;
use System\Library\General\GlobalVariable;

class StatusController extends \Backoffice\Controllers\ProtectedController
{
    protected $_limit = 10;
    protected $_pages = 1;

    public function indexAction()
    {
        $previousPage = new GlobalVariable();
        $currentId = $this->dispatcher->getParam("id");

        $currentId = explode("|",$currentId);
        $id = $currentId[0];
        $status = $currentId[1];

        $dlProviderGame = new DLProviderGame();
        $providerGame = $dlProviderGame->findFirstById($id);

        if(!isset($currentId) || !$providerGame){
            $this->flash->error("undefined_provider_id");
            $this->response->redirect($previousPage->previousPage())->send();
        }

        try {
            $this->db->begin();

            $data['id'] = $id;
            $data['status'] = $status;

            $filterData = $dlProviderGame->filterData($data);
            $dlProviderGame->set($filterData);

            $dlGame = new DLGame();
            $games = $dlGame->findByProvider($id);

            $providerStatus = $gameStatus = 1;
            if($status == 0 || $status == 2){
                $providerStatus = $gameStatus = 0;
            }

            $dlUserGame = new DLUserGame();

            $userGames = array();
            // get all game based on selected provider id
            foreach ($games as $game){
                $gameData = array(
                    'id' => $game['id'],
                    'pvst' => $providerStatus
                );
                // set game provider_status [0/1] based on game ID
                $dlGame->set($gameData);
                $gameData = $dlGame->findFirstById($game['id']);
                if($gameData['st'] == 1 && ($gameData['pvst'] == 1)){
                    $gameStatus = 1;
                }else{
                    $gameStatus = 0;
                }

                // get user_game id based on game(id)
                $userGameRecords = $dlUserGame->findByGame($game['id']);
                foreach ($userGameRecords as $userGameRecord){
                    $userGames[] = $userGameRecord;
                }
            }

            foreach ($userGames as $userGame){
                $userGameData = array(
                    "id" => $userGame['id'],
                    'gmst' => $gameStatus
                );
                // set user_game game_status [0/1] based on user_game ID
                $dlUserGame->set($userGameData);
            }

            $this->db->commit();
            $this->flash->success("status_changed");
            $this->response->redirect($previousPage->previousPage())->send();
        } catch (\Exception $e) {
            $this->db->rollback();
            $this->flash->error($e->getMessage());
        }
    }
}
