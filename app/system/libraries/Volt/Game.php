<?php
namespace Volt\Libraries;

use System\Library\General\GlobalVariable;

class Game
{
    public static function gameName($data)
    {
        $game = \System\Model\Game::findFirstById($data);

        return $game->getName();
    }

    public static function gameType($data)
    {
        $gameTypeName = new GlobalVariable();
        $name = $gameTypeName->gameType($data);

        return $name;
    }

    public static function gameProvider($data)
    {
        $provider = \System\Model\ProviderGame::findFirstById($data);

        return $provider->getName();
    }
}
