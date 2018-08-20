<?php

namespace System\Model;

class Game extends \Phalcon\Mvc\Model
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
    protected $game_parent;

    /**
     *
     * @var integer
     */
    protected $provider;

    /**
     *
     * @var integer
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $code;

    /**
     *
     * @var string
     */
    protected $name;

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
     * Method to set the value of field game_parent
     *
     * @param integer $game_parent
     * @return $this
     */
    public function setGameParent($game_parent)
    {
        $this->game_parent = $game_parent;

        return $this;
    }

    /**
     * Method to set the value of field provider
     *
     * @param integer $provider
     * @return $this
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

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
     * Method to set the value of field code
     *
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Returns the value of field game_parent
     *
     * @return integer
     */
    public function getGameParent()
    {
        return $this->game_parent;
    }

    /**
     * Returns the value of field provider
     *
     * @return integer
     */
    public function getProvider()
    {
        return $this->provider;
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
     * Returns the value of field code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
        $this->setSchema("backoffice");
        $this->setSource("game");
        $this->hasMany('id', 'System\Model\GameCurrency', 'game', ['alias' => 'GameCurrency']);
        $this->hasMany('id', 'System\Model\StatementGame', 'game', ['alias' => 'StatementGame']);
        $this->hasMany('id', 'System\Model\StatementGame014', 'game', ['alias' => 'StatementGame014']);
        $this->hasMany('id', 'System\Model\StatementGameDaily', 'game', ['alias' => 'StatementGameDaily']);
        $this->hasMany('id', 'System\Model\StatementGameDailyBak', 'game', ['alias' => 'StatementGameDailyBak']);
        $this->hasMany('id', 'System\Model\StatementGameHistory', 'game', ['alias' => 'StatementGameHistory']);
        $this->hasMany('id', 'System\Model\StatementGameHistoryBak', 'game', ['alias' => 'StatementGameHistoryBak']);
        $this->hasMany('id', 'System\Model\UserGame', 'game', ['alias' => 'UserGame']);
        $this->hasMany('id', 'System\Model\UserPlayerGame', 'game', ['alias' => 'UserPlayerGame']);
        $this->belongsTo('provider', 'System\Model\ProviderGame', 'id', ['alias' => 'ProviderGame']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'game';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Game[]|Game|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Game|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
