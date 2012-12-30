<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Application_Model_GroupAccount
 * 
 * @package Application_Model
 * @category GroupAccount
 */
class Application_Model_GroupAccount
{
    protected $_groupId;
    protected $_accountId;
    
    public function setGroupId($groupId)
    {
        $this->_groupId = (int) $groupId;
        return $this;
    }
    public function getGroupId()
    {
        return $this->_groupId;
    }
    public function setAccountId($accountId)
    {
        $this->_accountId = (int) $accountId;
        return $this;
    }
    public function getAccountId()
    {
        return $this->_accountId;
    }
    public function populate($row)
    {
        if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
        $this->setGroupId($row->groupId)
             ->setAccountId($row->accountId);
        return $this;
    }
    public function toArray()
    {
        return array (
            'groupId' => $this->getGroupId(),
            'accountId' => $this->getAccountId(),
        );
    }
}

