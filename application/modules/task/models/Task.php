<?php

class Task_Model_Task extends In2it_Model_Model
{
    protected $_taskId;
    protected $_projectId;
    protected $_accountId;
    protected $_title;
    protected $_description;
    protected $_dueDate;
    protected $_created;
    protected $_modified;
    public function __construct($params = null)
    {
        $this->setCreated('now');
        $this->setModified('now');
        parent::__construct($params);
    }
    public function setId($taskId)
    {
        $this->_taskId = (int) $taskId;
        return $this;
    }
    public function getId()
    {
        return $this->_taskId;
    }
    public function setProjectId($projectId)
    {
        $this->_projectId = (int) $projectId;
        return $this;
    }
    public function getProjectId()
    {
        return $this->_projectId;
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
    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }
    public function getTitle()
    {
        return $this->_title;
    }
    public function setDescription($description)
    {
        $this->_description = (string) $description;
        return $this;
    }
    public function getDescription()
    {
        return $this->_description;
    }
    public function setDueDate($dueDate)
    {
        if (!$dueDate instanceof DateTime) {
            $dueDate = new DateTime($dueDate);
        }
        $this->_dueDate = $dueDate;
        return $this;
    }
    public function getDueDate()
    {
        return $this->_dueDate;
    }
    public function setCreated($created)
    {
        if (!$created instanceof DateTime) {
            $created = new DateTime($created);
        }
        $this->_created = $created;
        return $this;
    }
    public function getCreated()
    {
        return $this->_created;
    }
    public function setModified($modified)
    {
        if (!$modified instanceof DateTime) {
            $modified = new DateTime($modified);
        }
        $this->_modified = $modified;
        return $this;
    }
    public function getModified()
    {
        return $this->_modified;
    }
    public function populate($row)
    {
        if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
        if (isset ($row->taskId)) $this->setId($row->taskId);
        if (isset ($row->projectId)) $this->setProjectId($row->projectId);
        if (isset ($row->accountId)) $this->setAccountId($row->accountId);
        if (isset ($row->title)) $this->setTitle($row->title);
        if (isset ($row->description)) $this->setDescription($row->description);
        if (isset ($row->dueDate)) $this->setDueDate($row->dueDate);
        if (isset ($row->created)) $this->setCreated($row->created);
        if (isset ($row->modified)) $this->setModified($row->modified);
        return $this;
    }
    public function toArray()
    {
        return array (
            'taskId' => $this->getId(),
            'projectId' => $this->getProjectId(),
            'accountId' => $this->getAccountId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'dueDate' => $this->getDueDate()->format('Y-m-d H:i:s'),
            'created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'modified' => $this->getModified()->format('Y-m-d H:i:s'),
        );
    }
}