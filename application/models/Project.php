<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Application_Model_Project
 * 
 * @package Application_Model
 * @category Project
 */
class Application_Model_Project extends Application_Model_Abstract
{
    /**
     * @var int The sequence ID for this Project
     */
    protected $_projectId;
    /**
     * @var string The name for this Project
     */
    protected $_projectName;
    /**
     * @var DateTime The creation date for this Project
     */
    protected $_created;
    /**
     * @var DateTime The last modification date for this Project
     */
    protected $_modified;
    /**
     * Sets the sequence ID for this Project
     * 
     * @param int $projectId
     * @return Application_Model_Project 
     */
    public function setId($projectId)
    {
        $this->_projectId = (int) $projectId;
        return $this;
    }
    /**
     * Retrieves the sequence ID from this Project
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_projectId;
    }
    /**
     * Sets the name for this Project
     * 
     * @param string $projectName
     * @return Application_Model_Project 
     */
    public function setProjectName($projectName)
    {
        $this->_projectName = (string) $projectName;
        return $this;
    }
    /**
     * Retrieves the name from this Project
     * 
     * @return string
     */
    public function getProjectName()
    {
        return $this->_projectName;
    }
    /**
     * Sets the create date for this Project
     * 
     * @param string|DateTime $created
     * @return Application_Model_Project 
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
     * Retrieves the creation date from this Project
     * 
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->_created;
    }
    /**
     * Sets the last modification date for this Project
     * 
     * @param string|DateTime $modified
     * @return Application_Model_Project 
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
     * Retrieves the last modification date from this Project
     * 
     * @return DateTime
     */
    public function getModified()
    {
        return $this->_modified;
    }
    /**
     * Populates this Project with data
     * 
     * @param array|Zend_Db_Row $row
     * @return Application_Model_Project
     * @see In2it_Model_Model::populate()
     */
    public function populate($row)
    {
        if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
        
        $this->_defaultTimeStamp($row, 'created');
        $this->_defaultTimeStamp($row, 'modified');
        
        $this->_defaultValue($row, 'projectId', 0);
        
        $this->setId($row->projectId)
             ->setProjectName($row->projectName)
             ->setCreated($row->created)
             ->setModified($row->modified);
        return $this;
    }
    /**
     * Converts this Project into an array
     * 
     * @return array
     * @see In2it_Model_Model::toArray()
     */
    public function toArray()
    {
        return array (
            'projectId' => $this->getId(),
            'projectName' => $this->getProjectName(),
            'created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'modified' => $this->getModified()->format('Y-m-d H:i:s'),
        );
    }
}