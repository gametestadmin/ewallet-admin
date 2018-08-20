<?php

namespace System\Model;

class UserAuthWebserviceResponse extends \Phalcon\Mvc\Model
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
    protected $user_auth;

    /**
     *
     * @var integer
     */
    protected $user_auth_webservice_request;

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
     * Method to set the value of field user_auth
     *
     * @param integer $user_auth
     * @return $this
     */
    public function setUserAuth($user_auth)
    {
        $this->user_auth = $user_auth;

        return $this;
    }

    /**
     * Method to set the value of field user_auth_webservice_request
     *
     * @param integer $user_auth_webservice_request
     * @return $this
     */
    public function setUserAuthWebserviceRequest($user_auth_webservice_request)
    {
        $this->user_auth_webservice_request = $user_auth_webservice_request;

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
     * Returns the value of field user_auth
     *
     * @return integer
     */
    public function getUserAuth()
    {
        return $this->user_auth;
    }

    /**
     * Returns the value of field user_auth_webservice_request
     *
     * @return integer
     */
    public function getUserAuthWebserviceRequest()
    {
        return $this->user_auth_webservice_request;
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
        $this->setSource("user_auth_webservice_response");
        $this->belongsTo('user_auth', 'System\Model\UserAuth', 'id', ['alias' => 'UserAuth']);
        $this->belongsTo('user_auth_webservice_request', 'System\Model\UserAuthWebserviceRequest', 'id', ['alias' => 'UserAuthWebserviceRequest']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_auth_webservice_response';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserAuthWebserviceResponse[]|UserAuthWebserviceResponse|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserAuthWebserviceResponse|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
