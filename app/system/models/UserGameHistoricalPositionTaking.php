<?php

namespace System\Model;

class UserGameHistoricalPositionTaking extends \Phalcon\Mvc\Model
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
    protected $type;

    /**
     *
     * @var integer
     */
    protected $user_game;

    /**
     *
     * @var integer
     */
    protected $provider_game;

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
     * @var string
     */
    protected $date;

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
     * Method to set the value of field type
     *
     * @param integer $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Method to set the value of field user_game
     *
     * @param integer $user_game
     * @return $this
     */
    public function setUserGame($user_game)
    {
        $this->user_game = $user_game;

        return $this;
    }

    /**
     * Method to set the value of field provider_game
     *
     * @param integer $provider_game
     * @return $this
     */
    public function setProviderGame($provider_game)
    {
        $this->provider_game = $provider_game;

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
     * Method to set the value of field date
     *
     * @param string $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

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
     * Returns the value of field type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the value of field user_game
     *
     * @return integer
     */
    public function getUserGame()
    {
        return $this->user_game;
    }

    /**
     * Returns the value of field provider_game
     *
     * @return integer
     */
    public function getProviderGame()
    {
        return $this->provider_game;
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
     * Returns the value of field date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("user_game_historical_position_taking");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_game_historical_position_taking';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserGameHistoricalPositionTaking[]|UserGameHistoricalPositionTaking|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserGameHistoricalPositionTaking|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
