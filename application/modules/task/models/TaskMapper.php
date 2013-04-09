<?php

class Task_Model_TaskMapper extends In2it_Model_Mapper
{
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Task_Model_DbTable_Task');
        }
        return parent::getDbTable();
    }
    public function save(In2it_Model_Model $task)
    {
        if (0 < $task->getId()) {
            $this->getDbTable()->update($task->toArray(), array (
                'taskId = ?' => $task->getId(),
                'projectId = ?' => $task->getProjectId(),
            ));
        } else {
            $this->getDbTable()->insert($task->toArray());
            $task->setId($this->getDbTable()->getAdapter()->lastInsertId());
        }
    }
}