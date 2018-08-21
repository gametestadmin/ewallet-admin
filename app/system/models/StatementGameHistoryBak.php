<?php

namespace System\Model;

class StatementGameHistoryBak extends \Phalcon\Mvc\Model
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
    protected $agent;

    /**
     *
     * @var integer
     */
    protected $player;

    /**
     *
     * @var string
     */
    protected $player_code;

    /**
     *
     * @var double
     */
    protected $balance_in;

    /**
     *
     * @var double
     */
    protected $balance_out;

    /**
     *
     * @var double
     */
    protected $bet;

    /**
     *
     * @var double
     */
    protected $win_lose;

    /**
     *
     * @var string
     */
    protected $created_date;

    /**
     *
     * @var string
     */
    protected $last_updated_date;

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
     * Method to set the value of field agent
     *
     * @param integer $agent
     * @return $this
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Method to set the value of field player
     *
     * @param integer $player
     * @return $this
     */
    public function setPlayer($player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Method to set the value of field player_code
     *
     * @param string $player_code
     * @return $this
     */
    public function setPlayerCode($player_code)
    {
        $this->player_code = $player_code;

        return $this;
    }

    /**
     * Method to set the value of field balance_in
     *
     * @param double $balance_in
     * @return $this
     */
    public function setBalanceIn($balance_in)
    {
        $this->balance_in = $balance_in;

        return $this;
    }

    /**
     * Method to set the value of field balance_out
     *
     * @param double $balance_out
     * @return $this
     */
    public function setBalanceOut($balance_out)
    {
        $this->balance_out = $balance_out;

        return $this;
    }

    /**
     * Method to set the value of field bet
     *
     * @param double $bet
     * @return $this
     */
    public function setBet($bet)
    {
        $this->bet = $bet;

        return $this;
    }

    /**
     * Method to set the value of field win_lose
     *
     * @param double $win_lose
     * @return $this
     */
    public function setWinLose($win_lose)
    {
        $this->win_lose = $win_lose;

        return $this;
    }

    /**
     * Method to set the value of field created_date
     *
     * @param string $created_date
     * @return $this
     */
    public function setCreatedDate($created_date)
    {
        $this->created_date = $created_date;

        return $this;
    }

    /**
     * Method to set the value of field last_updated_date
     *
     * @param string $last_updated_date
     * @return $this
     */
    public function setLastUpdatedDate($last_updated_date)
    {
        $this->last_updated_date = $last_updated_date;

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
     * Returns the value of field agent
     *
     * @return integer
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Returns the value of field player
     *
     * @return integer
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Returns the value of field player_code
     *
     * @return string
     */
    public function getPlayerCode()
    {
        return $this->player_code;
    }

    /**
     * Returns the value of field balance_in
     *
     * @return double
     */
    public function getBalanceIn()
    {
        return $this->balance_in;
    }

    /**
     * Returns the value of field balance_out
     *
     * @return double
     */
    public function getBalanceOut()
    {
        return $this->balance_out;
    }

    /**
     * Returns the value of field bet
     *
     * @return double
     */
    public function getBet()
    {
        return $this->bet;
    }

    /**
     * Returns the value of field win_lose
     *
     * @return double
     */
    public function getWinLose()
    {
        return $this->win_lose;
    }

    /**
     * Returns the value of field created_date
     *
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * Returns the value of field last_updated_date
     *
     * @return string
     */
    public function getLastUpdatedDate()
    {
        return $this->last_updated_date;
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
        $this->setSource("statement_game_history_bak");
        $this->belongsTo('agent', 'System\Model\User', 'id', ['alias' => 'User']);
        $this->belongsTo('game', 'System\Model\Game', 'id', ['alias' => 'Game']);
        $this->belongsTo('player', 'System\Model\UserPlayer', 'id', ['alias' => 'UserPlayer']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'statement_game_history_bak';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return StatementGameHistoryBak[]|StatementGameHistoryBak|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return StatementGameHistoryBak|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
