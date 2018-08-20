<?php

namespace System\Model;

class ProviderGameWebserviceResponse extends \Phalcon\Mvc\Model
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
    protected $provider_game_webservice_request;

    /**
     *
     * @var string
     */
    protected $endpoint;

    /**
     *
     * @var string
     */
    protected $response;

    /**
     *
     * @var string
     */
    protected $response_date;

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
     * Method to set the value of field provider_game_webservice_request
     *
     * @param integer $provider_game_webservice_request
     * @return $this
     */
    public function setProviderGameWebserviceRequest($provider_game_webservice_request)
    {
        $this->provider_game_webservice_request = $provider_game_webservice_request;

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
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Method to set the value of field response
     *
     * @param string $response
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Method to set the value of field response_date
     *
     * @param string $response_date
     * @return $this
     */
    public function setResponseDate($response_date)
    {
        $this->response_date = $response_date;

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
     * Returns the value of field provider_game_webservice_request
     *
     * @return integer
     */
    public function getProviderGameWebserviceRequest()
    {
        return $this->provider_game_webservice_request;
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
     * Returns the value of field response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Returns the value of field response_date
     *
     * @return string
     */
    public function getResponseDate()
    {
        return $this->response_date;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("backoffice");
        $this->setSource("provider_game_webservice_response");
        $this->belongsTo('provider_game', 'System\Model\ProviderGame', 'id', ['alias' => 'ProviderGame']);
        $this->belongsTo('provider_game_webservice_request', 'System\Model\ProviderGameWebserviceRequest', 'id', ['alias' => 'ProviderGameWebserviceRequest']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'provider_game_webservice_response';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProviderGameWebserviceResponse[]|ProviderGameWebserviceResponse|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProviderGameWebserviceResponse|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
