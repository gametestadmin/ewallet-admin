<?php

namespace System\Model;

class UserGame extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $user;

    /**
     *
     * @var integer
     */
    protected $game;

    /**
     *
     * @var integer
     */
    protected $user_game_historical_position_taking;

    /**
     *
     * @var integer
     */
    protected $parent_status;

    /**
     *
     * @var integer
     */
    protected $status;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field user
     *
     * @param integer $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Method to set the value of field game
     *
     * @param integer $game
     * @return $this
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Method to set the value of field user_game_historical_position_taking
     *
     * @param integer $user_game_historical_position_taking
     * @return $this
     */
    public function setUserGameHistoricalPositionTaking($user_game_historical_position_taking)
    {
        $this->user_game_historical_position_taking = $user_game_historical_position_taking;

        return $this;
    }

    /**
     * Method to set the value of field parent_status
     *
     * @param integer $parent_status
     * @return $this
     */
    public function setParentStatus($parent_status)
    {
        $this->parent_status = $parent_status;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param integer $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Returns the value of field game
     *
     * @return integer
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Returns the value of field user_game_historical_position_taking
     *
     * @return integer
     */
    public function getUserGameHistoricalPositionTaking()
    {
        return $this->user_game_historical_position_taking;
    }

    /**
     * Returns the value of field parent_status
     *
     * @return integer
     */
    public function getParentStatus()
    {
        return $this->parent_status;
    }

    /**
     * Returns the value of field status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("user_game");
        $this->belongsTo('game', 'System\Model\Game', 'id', ['alias' => 'Game']);
        $this->belongsTo('user', 'System\Model\User', 'id', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_game';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserGame[]|UserGame|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserGame|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
