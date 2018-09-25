<?php

namespace System\Model;

class ProviderGameEndpointAuth extends \Phalcon\Mvc\Model
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
     * @var string
     */
    protected $app_id;

    /**
     *
     * @var string
     */
    protected $app_secret;

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
     * Method to set the value of field app_id
     *
     * @param string $app_id
     * @return $this
     */
    public function setAppId($app_id)
    {
        $this->app_id = $app_id;

        return $this;
    }

    /**
     * Method to set the value of field app_secret
     *
     * @param string $app_secret
     * @return $this
     */
    public function setAppSecret($app_secret)
    {
        $this->app_secret = $app_secret;

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
     * Returns the value of field app_id
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     * Returns the value of field app_secret
     *
     * @return string
     */
    public function getAppSecret()
    {
        return $this->app_secret;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("provider_game_endpoint_auth");
        $this->hasMany('id', 'System\Model\ProviderGameEndpoint', 'provider_game_endpoint_auth', ['alias' => 'ProviderGameEndpoint']);
        $this->belongsTo('provider_game', 'System\Model\ProviderGame', 'id', ['alias' => 'ProviderGame']);
        $this->belongsTo('game', 'System\Model\Game', 'id', ['alias' => 'Game']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'provider_game_endpoint_auth';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProviderGameEndpointAuth[]|ProviderGameEndpointAuth|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProviderGameEndpointAuth|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
