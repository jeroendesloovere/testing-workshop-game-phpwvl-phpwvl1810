<?php

class Project_Model_Project extends In2it_Model_Model
{
    protected $_projectId;
    protected $_accountId;
    protected $_projectName;
    protected $_created;
    protected $_modified;
    public function __construct($params = null)
    {
        $this->setCreated('now');
        $this->setModified('now');
        parent::__construct($params);
    }
    public function setId($projectId)
    {
        $this->_projectId = (int) $projectId;
        return $this;
    }
    public function getId()
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
    public function setProjectName($projectName)
    {
        $this->_projectName = (string) $projectName;
        return $this;
    }
    public function getProjectName()
    {
        return $this->_projectName;
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
        if (isset ($row->projectId)) $this->setId($row->projectId);
        if (isset ($row->accountId)) $this->setAccountId($row->accountId);
        if (isset ($row->projectName)) $this->setProjectName($row->projectName);
        if (isset ($row->created)) $this->setCreated($row->created);
        if (isset ($row->modified)) $this->setModified($row->modified);
    }
    public function toArray()
    {
        return array (
            'projectId' => $this->getId(),
            'accountId' => $this->getAccountId(),
            'projectName' => $this->getProjectName(),
            'created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'modified' => $this->getModified()->format('Y-m-d H:i:s'),
        );
    }
}