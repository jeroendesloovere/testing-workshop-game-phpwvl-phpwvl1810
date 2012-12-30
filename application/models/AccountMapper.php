<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Application_Model_Account
 * 
 * @package Application_Model
 * @category Account
 */
class Application_Model_AccountMapper extends In2it_Model_Mapper
{
    /**
     * Retrieves the dbTable object
     * 
     * @return Zend_Db_Table
     * @see In2it_Model_Mapper::getDbTable()
     */
    public function getDbTable()
    {
        if (!isset ($this->_dbTable)) {
            $this->setDbTable('Application_Model_DbTable_Account');
        }
        return parent::getDbTable();
    }
    /**
     * Stores the account object into a data storage
     * 
     * @param Application_Model_Account $account
     * @see In2it_Model_Mapper::save()
     */
    public function save(Application_Model_Account $account)
    {
        if (0 < $account->getId()) {
            $this->getDbTable()->update($account->toArray(), array ('accountId = ?' => $account->getId()));
        } else {
            $this->getDbTable()->insert($account->toArray());
        }
    }
}

