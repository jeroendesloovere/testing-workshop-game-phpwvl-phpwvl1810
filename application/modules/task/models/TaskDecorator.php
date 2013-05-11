<?php

class Task_Model_TaskDecorator extends Task_Model_Task
{
    /**
     * Assigns an Account model to the task
     *
     * @var Account_Model_Account
     */
    protected $_assigned;

    /**
     * Constructor method to allow direct population of this decorator
     * class
     *
     * @param null|array|Zend_Db_Row $params
     * @see Task_Model_Task::__construct()
     */
    public function __construct($params = null)
    {
        parent::__construct($params);
        $this->setAssigned(new Account_Model_Account());
    }

    /**
     * Assigns an assigned account object to a task
     *
     * @param Account_Model_Account $account
     * @return $this
     */
    public function setAssigned(Account_Model_Account $account)
    {
        $this->_assigned = $account;
        return $this;
    }

    /**
     * Retrieves the assigned account object from this task
     *
     * @return Account_Model_Account
     */
    public function getAssigned()
    {
        return $this->_assigned;
    }
}