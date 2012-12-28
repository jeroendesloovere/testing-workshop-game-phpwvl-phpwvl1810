<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Application_Model_TaskMapper
 * 
 * @package Application_Model
 * @category Task
 */
class Application_Model_TaskMapper extends In2it_Model_Mapper
{
    /**
     * Retrieves the dbTable gateway
     * 
     * @return Zend_Db_Table_Abstract
     * @see In2it_Model_Mapper::getDbTable()
     */
    public function getDbTable()
    {
        if (!isset ($this->_dbTable)) {
            $this->setDbTable('Application_Model_DbTable_Task');
        }
        return parent::getDbTable();
    }
}