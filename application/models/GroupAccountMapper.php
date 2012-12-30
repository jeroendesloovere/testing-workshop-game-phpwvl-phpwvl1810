<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Application_Model_GroupAccountMapper
 * 
 * @package Application_Model
 * @category GroupAccount
 */
class Application_Model_GroupAccountMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Sets the Data Gateway object
     * 
     * @param string|Zend_Db_Table_Abstract $dbTable
     * @return Application_Model_GroupAccountMapper
     * @throws In2it_Model_Exception
     */
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            if (!class_exists($dbTable)) {
                throw new In2it_Model_Exception('Non-existing data gateway provided');
            }
            $dbTable = new $dbTable;
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new In2it_Model_Exception('Invalid data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    /**
     * Retrieves the Data Gateway object
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (!isset ($this->_dbTable)) {
            $this->setDbTable('Application_Model_DbTable_GroupAccount');
        }
        return $this->_dbTable;
    }
    /**
     * Finds a single instance of a model by providing primary keys
     * 
     * @param Application_Model_GroupAccount $groupAccount
     * @param int $groupId
     * @param int $accountId 
     */
    public function find(Application_Model_GroupAccount $groupAccount, $groupId, $accountId)
    {
        $resultSet = $this->getDbTable()->find($groupdId, $accountId);
        if (!empty ($resultSet)) {
            $groupAccount->populate($resultSet->current());
        }
    }
    public function fetchRow(Application_Model_GroupAccount $groupAccount, $where = null, $order = null)
    {
        
    }
}

