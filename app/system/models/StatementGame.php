<?php

namespace System\Model;

class StatementGame extends \Phalcon\Mvc\Model
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
    protected $agent;

    /**
     *
     * @var integer
     */
    protected $game;

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
    protected $balance_before;

    /**
     *
     * @var double
     */
    protected $bet;

    /**
     *
     * @var double
     */
    protected $commission;

    /**
     *
     * @var double
     */
    protected $amount;

    /**
     *
     * @var string
     */
    protected $transaction_id;

    /**
     *
     * @var integer
     */
    protected $user_game_historical_position_taking;

    /**
     *
     * @var string
     */
    protected $game_data;

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
     * Method to set the value of field balance_before
     *
     * @param double $balance_before
     * @return $this
     */
    public function setBalanceBefore($balance_before)
    {
        $this->balance_before = $balance_before;

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
     * Method to set the value of field amount
     *
     * @param double $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Method to set the value of field transaction_id
     *
     * @param string $transaction_id
     * @return $this
     */
    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;

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
     * Method to set the value of field game_data
     *
     * @param string $game_data
     * @return $this
     */
    public function setGameData($game_data)
    {
        $this->game_data = $game_data;

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
     * Returns the value of field type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
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
     * Returns the value of field game
     *
     * @return integer
     */
    public function getGame()
    {
        return $this->game;
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
     * Returns the value of field balance_before
     *
     * @return double
     */
    public function getBalanceBefore()
    {
        return $this->balance_before;
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
     * Returns the value of field commission
     *
     * @return double
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Returns the value of field amount
     *
     * @return double
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Returns the value of field transaction_id
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
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
     * Returns the value of field game_data
     *
     * @return string
     */
    public function getGameData()
    {
        return $this->game_data;
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
        $this->setSource("statement_game");
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
        return 'statement_game';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return StatementGame[]|StatementGame|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return StatementGame|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
