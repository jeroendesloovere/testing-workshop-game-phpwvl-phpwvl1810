<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Application_Model_Account
 * 
 * @package Application_Model
 * @category Account
 */
class Application_Model_Account extends In2it_Model_Model
{
    /**
     * @var The Salt for hashing password
     */
    const ACCOUNT_SALT = 'You can do it, Ice Cube';
    /**
     * @var int The sequence ID for this Account
     */
    protected $_accountId;
    /**
     * @var string The first name for this Account
     */
    protected $_firstName;
    /**
     * @var string The last name for this Account
     */
    protected $_lastName;
    /**
     * @var string The email address for this Account
     */
    protected $_email;
    /**
     * @var string The password for this Account
     */
    protected $_password;
    /**
     * @var string The token for this Account
     */
    protected $_token;
    /**
     * @var string The creation date for this Account
     */
    protected $_created;
    /**
     * @var string The modification date for this Account
     */
    protected $_modified;
    /**
     * @var bool The flag indicating active status for this Account
     */
    protected $_active;
    /**
     * Sets the account ID for this Account
     * 
     * @param int $accountId
     * @return Application_Model_Account 
     */
    public function setId($accountId)
    {
        $this->_accountId = (int) $accountId;
        return $this;
    }
    /**
     * Retrieves the account ID from this Account
     * 
     * @return int
     */
    public function getId()
    {
        return $this->_accountId;
    }
    /**
     * Sets the first name for this Account
     * 
     * @param string $firstName
     * @return Application_Model_Account 
     */
    public function setFirstName($firstName)
    {
        $this->_firstName = (string) $firstName;
        return $this;
    }
    /**
     * Retrieves the first name from this Account
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }
    /**
     * Sets the last name for this Account
     * 
     * @param string $lastName
     * @return Application_Model_Account 
     */
    public function setLastName($lastName)
    {
        $this->_lastName = (string) $lastName;
        return $this;
    }
    /**
     * Retrieves the last name from this Account
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->_lastName;
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
     * Retrieves the email address from this Account
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }
    /**
     * Sets the password for this Account
     * 
     * @param string $password
     * @return Application_Model_Account 
     */
    public function setPassword($password)
    {
        $this->_password = self::generatePasswordHash($password);
        return $this;
    }
    /**
     * Retrieves the password from this Account
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }
    /**
     * Sets the token for this Account
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
     * Sets the creation date for this Account
     * 
     * @param string|DateTime $created
     * @return Application_Model_Account
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
     * Retrieves the creation date from this Account
     * 
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->_created;
    }
    /**
     * Sets the modification date for this Account
     * 
     * @param string|DateTime $modified
     * @return Application_Model_Account
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
     * Retrieves the modification date from this Account
     * 
     * @return DateTime
     */
    public function getModified()
    {
        return $this->_modified;
    }
    /**
     * Sets the current Account active
     * 
     * @param int $flag
     * @return Application_Model_Account 
     */
    public function setActive($flag = 1)
    {
        $this->_active = (1 === (int) $flag);
        return $this;
    }
    /**
     * Verifies the Account is active
     * 
     * @return bool
     */
    public function isActive()
    {
        return (bool) $this->_active;
    }
    /**
     * Populates this Account
     * 
     * @param array|Zend_Db_Row $row
     * @return Application_Model_Account 
     * @see In2it_Model_Model::populate()
     */
    public function populate($row)
    {
        if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
        
        $this->_defaultTimeStamp($row, 'created');
        $this->_defaultTimeStamp($row, 'modified');
        
        $this->_defaultValue($row, 'accountId', 0);
        $this->_defaultValue($row, 'token', '');
        $this->_defaultValue($row, 'active', 0);
        
        $this->setId($row->accountId)
             ->setFirstName($row->firstName)
             ->setLastName($row->lastName)
             ->setEmail($row->email)
             ->setPassword($row->password)
             ->setToken($row->token)
             ->setCreated($row->created)
             ->setModified($row->modified)
             ->setActive($row->active);
        return $this;
    }
    /**
     * Converts this Account into an array
     * 
     * @return array
     * @see In2it_Model_Model::toArray()        
     */
    public function toArray()
    {
        return array (
            'accountId' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'token' => $this->getToken(),
            'created' => $this->getCreated()->format('Y-m-d H:i:s'),
            'modified' => $this->getModified()->format('Y-m-d H:i:s'),
            'active' => ($this->isActive() ? 1 : 0),
        );
    }
    /**
     * Creates a default DateTime for a particular field
     * @param mixed $obj
     * @param string $field 
     */
    protected function _defaultTimeStamp($obj, $field)
    {
        if (!isset ($obj->$field)) {
            $obj->$field = new DateTime('now');
        }
    }
    /**
     * Sets a default value for a not set parameter
     * 
     * @param mixed $obj
     * @param string $field
     * @param mixed $value 
     */
    protected function _defaultValue($obj, $field, $value)
    {
        if (!isset ($obj->$field)) {
            $obj->$field = $value;
        }
    }
    /**
     * Generates a one-way password hash
     * 
     * @param string $password
     * @return string
     */
    public static function generatePasswordHash($password)
    {
        return crypt($password, self::ACCOUNT_SALT);
    }
}