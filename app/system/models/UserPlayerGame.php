<?php

namespace System\Model;

class UserPlayerGame extends \Phalcon\Mvc\Model
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
    protected $user_player;

    /**
     *
     * @var integer
     */
    protected $agent_id;

    /**
     *
     * @var integer
     */
    protected $game;

    /**
     *
     * @var double
     */
    protected $position_taking;

    /**
     *
     * @var double
     */
    protected $commission;

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
     * Method to set the value of field user_player
     *
     * @param integer $user_player
     * @return $this
     */
    public function setUserPlayer($user_player)
    {
        $this->user_player = $user_player;

        return $this;
    }

    /**
     * Method to set the value of field agent_id
     *
     * @param integer $agent_id
     * @return $this
     */
    public function setAgentId($agent_id)
    {
        $this->agent_id = $agent_id;

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
     * Method to set the value of field position_taking
     *
     * @param double $position_taking
     * @return $this
     */
    public function setPositionTaking($position_taking)
    {
        $this->position_taking = $position_taking;

        return $this;
    }

    /**
     * Method to set the value of field commission
     *
     * @param double $commission
     * @return $this
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

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
     * Returns the value of field user_player
     *
     * @return integer
     */
    public function getUserPlayer()
    {
        return $this->user_player;
    }

    /**
     * Returns the value of field agent_id
     *
     * @return integer
     */
    public function getAgentId()
    {
        return $this->agent_id;
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
     * Returns the value of field position_taking
     *
     * @return double
     */
    public function getPositionTaking()
    {
        return $this->position_taking;
    }

    /**
     * Returns the value of field commission
     *
     * @return double
     */
    public function getCommission()
    {
        return $this->commission;
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
        $this->setSource("user_player_game");
        $this->belongsTo('game', 'System\Model\Game', 'id', ['alias' => 'Game']);
        $this->belongsTo('user_player', 'System\Model\UserPlayer', 'id', ['alias' => 'UserPlayer']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_player_game';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserPlayerGame[]|UserPlayerGame|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserPlayerGame|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
