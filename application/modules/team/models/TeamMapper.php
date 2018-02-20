<?php

class Team_Model_TeamMapper extends In2it_Model_Mapper
{
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Team_Model_DbTable_Team');
        }
        return parent::getDbTable();
    }
    public function save(Team_Model_Team $team)
    {
        $id = (int) $team->getId();
        if (0 < $id) {
            $this->getDbTable()->update($team->toArray(), ['teamId = ?' => $team->getId()]);
        } else {
            $this->getDbTable()->insert($team->toArray());
            $id = $this->getDbTable()->getAdapter()->lastInsertId();
        }
        return $id;
    }
}
