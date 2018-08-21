<?php

namespace System\Model;

class UserAuth extends \Phalcon\Mvc\Model
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
    protected $user;

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
     *
     * @var string
     */
    protected $valid_until;

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
     * Method to set the value of field user
     *
     * @param integer $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

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
     * Method to set the value of field valid_until
     *
     * @param string $valid_until
     * @return $this
     */
    public function setValidUntil($valid_until)
    {
        $this->valid_until = $valid_until;

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
     * Returns the value of field user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
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
     * Returns the value of field valid_until
     *
     * @return string
     */
    public function getValidUntil()
    {
        return $this->valid_until;
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
        $this->setSource("user_auth");
        $this->hasMany('id', 'System\Model\UserAuthWebserviceRequest', 'user_auth', ['alias' => 'UserAuthWebserviceRequest']);
        $this->hasMany('id', 'System\Model\UserAuthWebserviceResponse', 'user_auth', ['alias' => 'UserAuthWebserviceResponse']);
        $this->belongsTo('user', 'System\Model\User', 'id', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_auth';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserAuth[]|UserAuth|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserAuth|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
