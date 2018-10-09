<?php

namespace System\Model;

class ProviderGameEndpoint extends \Phalcon\Mvc\Model
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
    protected $provider_game;

    /**
     *
     * @var integer
     */
    protected $game;

    /**
     *
     * @var integer
     */
    protected $game_type;

    /**
     *
     * @var integer
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $endpoint;

    /**
     *
     * @var integer
     */
    protected $provider_game_endpoint_auth;

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
     * Method to set the value of field game_type
     *
     * @param integer $game_type
     * @return $this
     */
    public function setGameType($game_type)
    {
        $this->game_type = $game_type;

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
     * Method to set the value of field endpoint
     *
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint= $endpoint;

        return $this;
    }

    /**
     * Method to set the value of field provider_game_endpoint_auth
     *
     * @param integer $provider_game_endpoint_auth
     * @return $this
     */
    public function setProviderGameEndpointAuth($provider_game_endpoint_auth)
    {
        $this->provider_game_endpoint_auth = $provider_game_endpoint_auth;

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
     * Returns the value of field game_type
     *
     * @return integer
     */
    public function getGameType()
    {
        return $this->game_type;
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
     * Returns the value of field endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Returns the value of field provider_game_endpoint_auth
     *
     * @return integer
     */
    public function getProviderGameEndpointAuth()
    {
        return $this->provider_game_endpoint_auth;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("provider_game_endpoint");
        $this->belongsTo('provider_game', 'System\Model\ProviderGame', 'id', ['alias' => 'ProviderGame']);
        $this->belongsTo('provider_game_endpoint_auth', 'System\Model\ProviderGameEndpointAuth', 'id', ['alias' => 'ProviderGameEndpointAuth']);
        $this->belongsTo('game', 'System\Model\Game', 'id', ['alias' => 'Game']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'provider_game_endpoint';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProviderGameEndpoint[]|ProviderGameEndpoint|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProviderGameEndpoint|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
