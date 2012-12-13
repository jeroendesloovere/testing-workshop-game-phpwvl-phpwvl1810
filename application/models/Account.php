<?php

class Application_Model_Account extends In2it_Model_Model
{
    /**
     * @var int The primary key for this Account
     */
    protected $_id;
    /**
     * @var string The full name for this Account
     */
    protected $_name;
    /**
     * @var string The email for this Account
     */
    protected $_email;
    /**
     * @var string The password for this Account
     */
    protected $_password;
    /**
     * @var DateTime The creation date of this Account
     */
    protected $_created;
    /**
     * @var DateTime The modification date of this Account
     */
    protected $_modified;
    /**
     * @var bool Flag indicating this Account is active or not
     */
    protected $_active;
    /**
     * @var string A token to use for activating this Account
     */
    protected $_token;
    /**
     * Sets the sequence ID for this Account
     * 
     * @param int $id
     * @return Application_Model_Account 
     */
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    /**
     * Retrieves the sequence ID from this Account
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }
    /**
     * Sets the full name for this Account
     * 
     * @param string $name
     * @return Application_Model_Account 
     */
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }
    /**
     * Retrieves the name from this Account
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
    /**
     * Sets the email address for this Account
     * 
     * @param string $email
     * @return Application_Model_Account 
     */
    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }
    /**
     * Retrieves the email from this Account
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
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
    /**
     * Sets a flag to indicat this Account is active or not
     * 
     * @param int|bool $flag
     * @return Application_Model_Account 
     */
    public function setActive($flag)
    {
        $this->_active = (bool) $flag;
        return $this;
    }
    /**
     * Checks if this Account is active or not
     * 
     * @return bool
     */
    public function isActive()
    {
        return $this->_active;
    }
    /**
     * Sets a token for activation or resetting this Account
     * 
     * @param string $token
     * @return Application_Model_Account 
     */
    public function setToken($token)
    {
        $this->_token = (string) $token;
        return $this;
    }
    /**
     * Retrieves the token from this Account
     * 
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }
    /**
     * Populates this Account with data
     * 
     * @param array|ArrayObject $row
     * @see In2it_Model_Model
     */
    public function populate($row)
    {
        if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
        $this->setId($row->id)
             ->setName($row->name)
             ->setEmail($row->email)
             ->setCreated($row->created)
             ->setModified($row->modified)
             ->setActive($row->active)
             ->setToken($row->token);
        
    }
    /**
     * Converts this Account model into an array
     * 
     * @return array
     */
    public function toArray()
    {
        return array (
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'modified' => $this->getModified()->format('Y-m-d H:i:s'),
            'active' => (int) $this->isActive(),
            'token' => $this->getToken(),
        );
    }
}