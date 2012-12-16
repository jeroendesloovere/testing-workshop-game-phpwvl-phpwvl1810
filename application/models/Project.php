<?php

class Application_Model_Project extends In2it_Model_Model
{
    protected $_id;
    protected $_accountId;
    protected $_title;
    protected $_description;
    protected $_created;
    protected $_modified;
    
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    public function getId()
    {
        return $this->_id;
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
    /**
     * Sets the creation time for this Account
     * 
     * @param string|DateTime $timestamp
     * @return Application_Model_Account 
     */
    public function setCreated($timestamp)
    {
        if (!$timestamp instanceof DateTime) {
            $timestamp = new DateTime($timestamp);
        }
        $this->_created = $timestamp;
        return $this;
    }
    /**
     * Retrieves the creation time from this Account
     * 
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->_created;
    }
    /**
     * Sets the modification time for this Account
     * 
     * @param string|DateTime $timestamp
     * @return Application_Model_Account 
     */
    public function setModified($timestamp)
    {
        if (!$timestamp instanceof DateTime) {
            $timestamp = new DateTime($timestamp);
        }
        $this->_modified = $timestamp;
        return $this;
    }
    /**
     * Retrieves the modification time from this Account
     * 
     * @return DateTime
     */
    public function getModified()
    {
        return $this->_modified;
    }
    public function populate($row)
    {
        if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
        
        $timestamp = date('Y-m-d H:i:s');
        if (!isset ($row->id)) $row->id = 0;
        if (!isset ($row->created)) $row->created = $timestamp;
        if (!isset ($row->modified)) $row->modified = $timestamp;
        
        $this->setId($row->id)
             ->setAccountId($row->accountId)
             ->setTitle($row->title)
             ->setDescription($row->description)
             ->setCreated($row->created)
             ->setModified($row->modified);
    }
    public function toArray()
    {
        return array (
            'id' => $this->getId(),
            'accountId' => $this->getAccountId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'created' => $this->getCreated(),
            'modified' => $this->getModified(),
        );
    }
}

