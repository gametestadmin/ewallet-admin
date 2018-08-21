<?php

namespace System\Model;

class UserAuthWebserviceRequest extends \Phalcon\Mvc\Model
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
     * @var string
     */
    protected $endpoint;

    /**
     *
     * @var string
     */
    protected $request;

    /**
     *
     * @var string
     */
    protected $request_date;

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
     * Method to set the value of field request
     *
     * @param string $request
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Method to set the value of field request_date
     *
     * @param string $request_date
     * @return $this
     */
    public function setRequestDate($request_date)
    {
        $this->request_date = $request_date;

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
     * Returns the value of field endpoint
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Returns the value of field request
     *
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Returns the value of field request_date
     *
     * @return string
     */
    public function getRequestDate()
    {
        return $this->request_date;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("user_auth_webservice_request");
        $this->hasMany('id', 'System\Model\UserAuthWebserviceResponse', 'user_auth_webservice_request', ['alias' => 'UserAuthWebserviceResponse']);
        $this->belongsTo('user_auth', 'System\Model\UserAuth', 'id', ['alias' => 'UserAuth']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_auth_webservice_request';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserAuthWebserviceRequest[]|UserAuthWebserviceRequest|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserAuthWebserviceRequest|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
