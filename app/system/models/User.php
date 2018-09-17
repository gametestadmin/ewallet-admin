<?php

namespace System\Model;

class User extends \Phalcon\Mvc\Model
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
    protected $parent;

    /**
     *
     * @var integer
     */
    protected $timezone;

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
    protected $username;

    /**
     *
     * @var string
     */
    protected $nickname;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @var integer
     */
    protected $reset_nickname;

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
     * Method to set the value of field parent
     *
     * @param integer $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Method to set the value of field timezone
     *
     * @param integer $timezone
     * @return $this
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

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
     * Method to set the value of field username
     *
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Method to set the value of field nickname
     *
     * @param string $nickname
     * @return $this
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Method to set the value of field reset_nickname
     *
     * @param integer $reset_nickname
     * @return $this
     */
    public function setResetNickname($reset_nickname)
    {
        $this->reset_nickname = $reset_nickname;

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
     * Returns the value of field parent
     *
     * @return integer
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Returns the value of field timezone
     *
     * @return integer
     */
    public function getTimezone()
    {
        return $this->timezone;
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
     * Returns the value of field username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Returns the value of field nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the value of field reset_nickname
     *
     * @return integer
     */
    public function getResetNickname()
    {
        return $this->reset_nickname;
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
        $this->setSource("user");
        $this->hasMany('id', 'System\Model\StatementGame', 'agent', ['alias' => 'StatementGame']);
        $this->hasMany('id', 'System\Model\StatementGame014', 'agent', ['alias' => 'StatementGame014']);
        $this->hasMany('id', 'System\Model\StatementGameDaily', 'agent', ['alias' => 'StatementGameDaily']);
        $this->hasMany('id', 'System\Model\StatementGameDailyBak', 'agent', ['alias' => 'StatementGameDailyBak']);
        $this->hasMany('id', 'System\Model\StatementGameHistory', 'agent', ['alias' => 'StatementGameHistory']);
        $this->hasMany('id', 'System\Model\StatementGameHistoryBak', 'agent', ['alias' => 'StatementGameHistoryBak']);
        $this->hasMany('id', 'System\Model\User', 'parent', ['alias' => 'User']);
        $this->hasMany('id', 'System\Model\UserAcl', 'user', ['alias' => 'UserAcl']);
        $this->hasMany('id', 'System\Model\UserAuth', 'user', ['alias' => 'UserAuth']);
        $this->hasMany('id', 'System\Model\UserCurrency', 'user', ['alias' => 'UserCurrency']);
        $this->hasMany('id', 'System\Model\UserGame', 'user', ['alias' => 'UserGame']);
        $this->hasMany('id', 'System\Model\UserPlayer', 'agent_id', ['alias' => 'UserPlayer']);
        $this->hasMany('code', 'System\Model\UserPlayer', 'agent_code', ['alias' => 'UserPlayer']);
        $this->hasMany('id', 'System\Model\UserPlayer', 'company_id', ['alias' => 'UserPlayer']);
        $this->hasMany('code', 'System\Model\UserPlayer', 'company_code', ['alias' => 'UserPlayer']);
        $this->hasMany('id', 'System\Model\UserWhitelistIp', 'user', ['alias' => 'UserWhitelistIp']);
        $this->belongsTo('parent', 'System\Model\User', 'id', ['alias' => 'User']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

}
