<?php
/**
 * Class Account_Model_AccountMapper
 *
 * @category TheiaLive
 * @package Account
 */
class Account_Model_AccountMapper extends In2it_Model_Mapper
{
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Account_Model_DbTable_Account');
        }
        return parent::getDbTable();
    }
    public function save($account)
    {
        if (0 < $account->getId()) {
            $this->getDbTable()->update($account->toArray(), 
                array ('accountId = ?' => $account->getId()));
        } else {
            $this->getDbTable()->insert($account->toArray());
            $account->setId($this->getDbTable()->getAdapter()->lastInsertId());
        }
    }
}