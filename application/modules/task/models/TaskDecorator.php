<?php

class Task_Model_TaskDecorator extends Task_Model_Task
{
    protected $_assigned;
    
    public function __construct($params = null)
    {
        parent::__construct($params);
        $this->setAssigned(new Account_Model_Account());
    }
    public function setAssigned(Account_Model_Account $account)
    {
        $this->_assigned = $account;
        return $this;
    }
    public function getAssigned()
    {
        return $this->_assigned;
    }
}