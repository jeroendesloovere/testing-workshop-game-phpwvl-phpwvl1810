<?php

class Project_Model_ProjectMapper extends In2it_Model_Mapper
{
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Project_Model_DbTable_Project');
        }
        return parent::getDbTable();
    }
    public function save($project)
    {
        if (0 < $project->getId()) {
            $this->getDbTable()->update($project->toArray(), array ('projectId = ?' => $project->getId()));
        } else {
            $this->getDbTable()->insert($project->toArray());
            $project->setId($this->getDbTable()->getAdapter()->lastInsertId());
        }
    }
}