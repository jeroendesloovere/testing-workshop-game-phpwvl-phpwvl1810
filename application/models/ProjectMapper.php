<?php

class Application_Model_ProjectMapper extends In2it_Model_Mapper
{
    public function getDbTable()
    {
        if (!isset ($this->_dbTable)) {
            $this->setDbTable('Application_Model_DbTable_Project');
        }
        return parent::getDbTable();
    }

}

