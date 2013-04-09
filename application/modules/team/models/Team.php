<?php

class Team_Model_Team extends In2it_Model_Model
{
    protected $_teamId;
    protected $_name;
    protected $_description;
    protected $_created;
    protected $_modified;
    
    public function __construct($params = null)
    {
        parent::__construct($params);
        $this->setCreated(new DateTime('now'));
        $this->setModified(new DateTime('now'));
    }
    public function setId($teamId)
    {
        $this->_teamId = (int) $teamId;
        return $this;
    }
    public function getId()
    {
        return $this->_teamId;
    }
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }
    public function getName()
    {
        return $this->_name;
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
    public function setCreated($created)
    {
        if (!$created instanceof DateTime) {
            $created = new DateTime($created);
        }
        $this->_created = $created;
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
        $this->_safeSetValues($row, 'teamId', 'setId')
             ->_safeSetValues($row, 'name', 'setName')
             ->_safeSetValues($row, 'description', 'setDescription')
             ->_safeSetValues($row, 'created', 'setCreated')
             ->_safeSetValues($row, 'modified', 'setModified');
        return $this;
    }
    public function toArray()
    {
        return array (
            'teamId' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'created' => $this->getCreated(),
            'modified' => $this->getModified(),
        );
    }
}