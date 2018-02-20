<?php

class Task_Model_Task extends In2it_Model_Model
{
    /**
     * @var int The sequence ID for this task
     */
    protected $_taskId;
    /**
     * @var int The sequence ID for the related project
     */
    protected $_projectId;
    /**
     * @var int The sequence ID for the related account
     */
    protected $_accountId;
    /**
     * @var string The title of the task
     */
    protected $_title;
    /**
     * @var string The description of the task
     */
    protected $_description;
    /**
     * @var DateTime The forseen due date for this task
     */
    protected $_dueDate;
    /**
     * @var DateTime The date this task was created
     */
    protected $_created;
    /**
     * @var DateTime The date this task was last modified
     */
    protected $_modified;
    /**
     * @var bool Flag indicating this task is done or not
     */
    protected $_done;

    /**
     * Constructor for this task that allows direct population by
     * providing either an array of key-value fields for this task
     * or by providing directly a result object from the data store.
     *
     * @param null|array|Zend_Db_Row $params
     * @see In2it_Model_Model::__construct()
     */
    public function __construct($params = null)
    {
        $this->setCreated('now');
        $this->setModified('now');
        parent::__construct($params);
    }

    /**
     * Sets the sequence ID for this task
     *
     * @param int $taskId
     * @return $this|In2it_Model_Model
     * @see In2it_Model_Model::setId()
     */
    public function setId($taskId)
    {
        $this->_taskId = (int) $taskId;
        return $this;
    }

    /**
     * Retrieves the sequence ID from this task
     *
     * @return int
     * @see In2it_Model_Model::getId()
     */
    public function getId()
    {
        return $this->_taskId;
    }

    /**
     * Sets the ID for the project this task is part of
     *
     * @param int $projectId
     * @return $this
     */
    public function setProjectId($projectId)
    {
        $this->_projectId = (int) $projectId;
        return $this;
    }

    /**
     * Retrieves the ID for the project this task is part of
     *
     * @return int
     */
    public function getProjectId()
    {
        return $this->_projectId;
    }

    /**
     * Sets the account ID that owns this task
     *
     * @param int $accountId
     * @return $this
     */
    public function setAccountId($accountId)
    {
        $this->_accountId = (int) $accountId;
        return $this;
    }

    /**
     * Retrieves the account ID that owns this task
     *
     * @return int
     */
    public function getAccountId()
    {
        return $this->_accountId;
    }

    /**
     * Set the title for this task
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }

    /**
     * Retrieves the title from this task
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Sets the description for this task
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->_description = (string) $description;
        return $this;
    }

    /**
     * Retrieves the description from this task
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Sets the intended due-date for this task
     *
     * @param string|DateTime $dueDate
     * @return $this
     */
    public function setDueDate($dueDate)
    {
        if (! $dueDate instanceof DateTime) {
            $dueDate = new DateTime($dueDate);
        }
        $this->_dueDate = $dueDate;
        return $this;
    }

    /**
     * Retrieves the due-date from this task
     *
     * @return DateTime
     */
    public function getDueDate()
    {
        return $this->_dueDate;
    }

    /**
     * Sets the creation date of this task
     *
     * @param string|DateTime $created
     * @return $this
     */
    public function setCreated($created)
    {
        if (! $created instanceof DateTime) {
            $created = new DateTime($created);
        }
        $this->_created = $created;
        return $this;
    }

    /**
     * Retrieves the creation date from this task
     *
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->_created;
    }

    /**
     * Sets the last modification date for this task
     *
     * @param string|DateTime $modified
     * @return $this
     */
    public function setModified($modified)
    {
        if (! $modified instanceof DateTime) {
            $modified = new DateTime($modified);
        }
        $this->_modified = $modified;
        return $this;
    }

    /**
     * Retrieves the last modification date from this task
     *
     * @return DateTime
     */
    public function getModified()
    {
        return $this->_modified;
    }

    /**
     * Marks a task as done
     *
     * @param int|bool $done
     * @return $this
     */
    public function setDone($done)
    {
        $this->_done = (bool) $done;
        return $this;
    }

    /**
     * Checks if this task is done
     *
     * @return bool
     */
    public function isDone()
    {
        return $this->_done;
    }

    /**
     * Populates this task with data from an external source
     *
     * @param array|Zend_Db_Row $row
     * @return $this|In2it_Model_Model
     * @see In2it_Model_Model::populate()
     */
    public function populate($row)
    {
        if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
        if (isset($row->taskId)) {
            $this->setId($row->taskId);
        }
        if (isset($row->projectId)) {
            $this->setProjectId($row->projectId);
        }
        if (isset($row->accountId)) {
            $this->setAccountId($row->accountId);
        }
        if (isset($row->title)) {
            $this->setTitle($row->title);
        }
        if (isset($row->description)) {
            $this->setDescription($row->description);
        }
        if (isset($row->dueDate)) {
            $this->setDueDate($row->dueDate);
        }
        if (isset($row->created)) {
            $this->setCreated($row->created);
        }
        if (isset($row->modified)) {
            $this->setModified($row->modified);
        }
        if (isset($row->done)) {
            $this->setDone($row->done);
        }
        return $this;
    }

    /**
     * Converts this task into an array
     *
     * @return array
     * @see In2it_Model_Model::toArray()
     */
    public function toArray()
    {
        return  [
            'taskId' => $this->getId(),
            'projectId' => $this->getProjectId(),
            'accountId' => $this->getAccountId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'dueDate' => $this->getDueDate()->format('Y-m-d H:i:s'),
            'created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'modified' => $this->getModified()->format('Y-m-d H:i:s'),
            'done' => $this->isDone() ? 1 : 0,
        ];
    }
}
