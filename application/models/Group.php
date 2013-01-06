<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Application_Model_Group
 * 
 * @package Application_Model
 * @category Group
 */
class Application_Model_Group extends Application_Model_Abstract
{
    /**
     * @var int The sequence ID for this Group
     */
    protected $_groupId;
    /**
     * @var string The name for this Group
     */
    protected $_groupName;
    /**
     * @var DateTime The date this Group was created
     */
    protected $_created;
    /**
     * @var DateTime The date this Group was modified
     */
    protected $_modified;
    /**
     * Constructor for this class
     * 
     * @param null|array|Zend_Db_Row $params
     * @see In2it_Model_Model::__construct()
     */
    public function __construct($params = null)
    {
        $this->setCreated(new DateTime('now'));
        $this->setModified(new DateTime('now'));
        parent::__construct($params);
    }
    /**
     * Sets the sequence ID for this Group
     * 
     * @param int $groupId
     * @return Application_Model_Group
     */
    public function setId($groupId)
    {
        $this->_groupId = (int) $groupId;
        return $this;
    }
    /**
     * Retrieves the sequence ID from this Group
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_groupId;
    }
    /**
     * Sets the name for this Group
     * 
     * @param string $groupName
     * @return Application_Model_Group
     */
    public function setGroupName($groupName)
    {
        $this->_groupName = (string) $groupName;
        return $this;
    }
    /**
     * Retrieves the name from this Group
     * 
     * @return string
     */
    public function getGroupName()
    {
        return $this->_groupName;
    }
    /**
     * Sets the creation date for this Group
     * 
     * @param string|DateTime $created
     * @return Application_Model_Group
     */
    public function setCreated($created)
    {
        if (!$created instanceof DateTime) {
            $created = new DateTime($created);
        }
        $this->_created = $created;
        return $this;
    }
    /**
     * Retrieves the creation date from this Group
     * 
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->_created;
    }
    /**
     * Sets the last modification date for this Group
     * 
     * @param string|DateTime $modified
     * @return Application_Model_Group
     */
    public function setModified($modified)
    {
        if (!$modified instanceof DateTime) {
            $modified = new DateTime($modified);
        }
        $this->_modified = $modified;
        return $this;
    }
    /**
     * Retrieves the last modification date from this Group
     * 
     * @return DateTime
     */
    public function getModified()
    {
        return $this->_modified;
    }
    /**
     * Populates this group with data
     * 
     * @param array|Zend_Db_Row $row
     * @return Application_Model_Group
     */
    public function populate($row)
    {
        if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
        
        $this->_defaultTimeStamp($row, 'created');
        $this->_defaultTimeStamp($row, 'modified');
        
        $this->_defaultValue($row, 'groupId', 0);
        
        $this->setId($row->groupId)
             ->setGroupName($row->groupName)
             ->setCreated($row->created)
             ->setModified($row->modified);
        return $this;
    }
    /**
     * Converts this Group into an array
     * 
     * @return array
     */
    public function toArray()
    {
        return array (
            'groupId' => $this->getId(),
            'groupName' => $this->getGroupName(),
            'created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'modified' => $this->getModified()->format('Y-m-d H:i:s'),
        );
    }

}

