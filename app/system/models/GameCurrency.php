<?php

namespace System\Model;

class GameCurrency extends \Phalcon\Mvc\Model
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
    protected $game;

    /**
     *
     * @var integer
     */
    protected $currency;

    /**
     *
     * @var integer
     */
    protected $default;

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
     * Method to set the value of field currency
     *
     * @param integer $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Method to set the value of field default
     *
     * @param integer $default
     * @return $this
     */
    public function setDefault($default)
    {
        $this->default = $default;

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
     * Returns the value of field game
     *
     * @return integer
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Returns the value of field currency
     *
     * @return integer
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Returns the value of field default
     *
     * @return integer
     */
    public function getDefault()
    {
        return $this->default;
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
        $this->setSource("game_currency");
        $this->belongsTo('currency', 'System\Model\Currency', 'id', ['alias' => 'Currency']);
        $this->belongsTo('game', 'System\Model\Game', 'id', ['alias' => 'Game']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'game_currency';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GameCurrency[]|GameCurrency|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GameCurrency|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
