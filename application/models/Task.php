<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Application_Model_Task
 * 
 * @package Application_Model
 * @category Task
 */
class Application_Model_Task extends Application_Model_Abstract
{
    /**
     * @var int The sequence ID for this Task
     */
    protected $_taskId;
    /**
     * @var string The label for this task
     */
    protected $_taskLabel;
    /**
     * @var DatTime The creation date for this Task
     */
    protected $_created;
    /**
     * @var DateTime The last modification date for this Task
     */
    protected $_modified;
    /**
     * Sets the sequence ID for this Task
     * 
     * @param int $taskId
     * @return Application_Model_Task
     */
    public function setId($taskId)
    {
        $this->_taskId = (int) $taskId;
        return $this;
    }
    /**
     * Retrieves the sequence ID from this Task
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_taskId;
    }
    /**
     * Sets the label for this Task
     * 
     * @param string $taskLabel
     * @return Application_Model_Task 
     */
    public function setTaskLabel($taskLabel)
    {
        $this->_taskLabel = (string) $taskLabel;
        return $this;
    }
    /**
     * Retrieves the label from this Task
     * 
     * @return string
     */
    public function getTaskLabel()
    {
        return $this->_taskLabel;
    }
    /**
     * Sets the creation date for this Task
     * 
     * @param string|DateTime $created
     * @return Application_Model_Task 
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
     * Retrieves the creation date from this Task
     * 
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->_created;
    }
    /**
     * Sets the last modification date for this Task
     * 
     * @param string|DateTime $modified
     * @return Application_Model_Task 
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
     * Retrieves the last modification date from this Task
     * 
     * @return DateTime
     */
    public function getModified()
    {
        return $this->_modified;
    }
    /**
     * Populates this Task with data
     * 
     * @param array|Zend_Db_Row $row
     * @return Application_Model_Task 
     * @see In2it_Model_Model::populate()
     */
    public function populate($row)
    {
        if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
        
        $this->_defaultTimeStamp($row, 'created');
        $this->_defaultTimeStamp($row, 'modified');
        
        $this->_defaultValue($row, 'taskId', 0);
        
        $this->setId($row->taskId)
             ->setTaskLabel($row->taskLabel)
             ->setCreated($row->created)
             ->setModified($row->modified);
        return $this;
    }
    /**
     * Converts this Task into an array
     * 
     * @return array
     * @see In2it_Model_Model::toArray()
     */
    public function toArray()
    {
        return array (
            'taskId' => $this->getId(),
            'taskLabel' => $this->getTaskLabel(),
            'created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'modified' => $this->getModified()->format('Y-m-d H:i:s'),
        );
    }
}