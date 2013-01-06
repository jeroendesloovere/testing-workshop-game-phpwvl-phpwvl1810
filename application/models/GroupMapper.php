<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Application_Model_GroupMapper
 * 
 * @package Application_Model
 * @category Group
 */
class Application_Model_GroupMapper extends In2it_Model_Mapper
{
    /**
     * Retrieves the dbTable object
     * 
     * @return Zend_Db_Table_Abstract
     * @see In2it_Model_Mapper::getDbTable()
     */
    public function getDbTable()
    {
        if (!isset ($this->_dbTable)) {
            $this->setDbTable('Application_Model_DbTable_Group');
        }
        return parent::getDbTable();
    }
    /**
     * Inserts or updates a group object when modified
     * 
     * @param Application_Model_Group $group
     * @see In2it_Model_Mapper::save()
     */
    public function save(Application_Model_Group $group)
    {
        if (0 < $group->getId()) {
            $this->getDbTable()->update($group->toArray(), array ('groupId = ?' => $group->getId()));
        } else {
            $this->getDbTable()->insert($group->toArray());
            $group->setId($this->getDbTable()->getAdapter()->lastInsertId());
        }
    }
}