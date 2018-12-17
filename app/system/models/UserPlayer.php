<?php

namespace System\Model;

class UserPlayer extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

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
     * @var integer
     */
    protected $agent_id;

    /**
     *
     * @var string
     */
    protected $agent_code;

    /**
     *
     * @var integer
     */
    protected $company_id;

    /**
     *
     * @var string
     */
    protected $company_code;

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
     * Method to set the value of field agent_id
     *
     * @param integer $agent_id
     * @return $this
     */
    public function setAgentId($agent_id)
    {
        $this->agent_id = $agent_id;

        return $this;
    }

    /**
     * Method to set the value of field agent_code
     *
     * @param string $agent_code
     * @return $this
     */
    public function setAgentCode($agent_code)
    {
        $this->agent_code = $agent_code;

        return $this;
    }

    /**
     * Method to set the value of field company_id
     *
     * @param integer $company_id
     * @return $this
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;

        return $this;
    }

    /**
     * Method to set the value of field company_code
     *
     * @param string $company_code
     * @return $this
     */
    public function setCompanyCode($company_code)
    {
        $this->company_code = $company_code;

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
     * Returns the value of field agent_id
     *
     * @return integer
     */
    public function getAgentId()
    {
        return $this->agent_id;
    }

    /**
     * Returns the value of field agent_code
     *
     * @return string
     */
    public function getAgentCode()
    {
        return $this->agent_code;
    }

    /**
     * Returns the value of field company_id
     *
     * @return integer
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * Returns the value of field company_code
     *
     * @return string
     */
    public function getCompanyCode()
    {
        return $this->company_code;
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
        $this->setSource("user_player");
        $this->hasMany('id', 'System\Model\StatementGame', 'player', ['alias' => 'StatementGame']);
        $this->hasMany('id', 'System\Model\StatementGame014', 'player', ['alias' => 'StatementGame014']);
        $this->hasMany('id', 'System\Model\StatementGameDaily', 'player', ['alias' => 'StatementGameDaily']);
        $this->hasMany('id', 'System\Model\StatementGameDailyBak', 'player', ['alias' => 'StatementGameDailyBak']);
        $this->hasMany('id', 'System\Model\StatementGameHistory', 'player', ['alias' => 'StatementGameHistory']);
        $this->hasMany('id', 'System\Model\StatementGameHistoryBak', 'player', ['alias' => 'StatementGameHistoryBak']);
        $this->hasMany('id', 'System\Model\UserPlayerGame', 'user_player', ['alias' => 'UserPlayerGame']);
        $this->belongsTo('agent_id', 'System\Model\User', 'id', ['alias' => 'User']);
        $this->belongsTo('agent_code', 'System\Model\User', 'code', ['alias' => 'User']);
        $this->belongsTo('company_id', 'System\Model\User', 'id', ['alias' => 'User']);
        $this->belongsTo('company_code', 'System\Model\User', 'code', ['alias' => 'User']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_player';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserPlayer[]|UserPlayer|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserPlayer|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
