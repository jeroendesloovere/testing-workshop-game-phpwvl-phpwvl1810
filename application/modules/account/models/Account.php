<?php
/**
 * Class Account_Model_Account
 *
 * @category TheiaLive
 * @package Account
 */
class Account_Model_Account extends In2it_Model_Model
{
    const ACCOUNT_SALT = 'You can do it, Ice Cube';
    /**
     * @var int Sequence ID of the Account
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
     * @var string The token used to reset and activate this Account
     */
    protected $_token;
    /**
     * @var bool Flag for active status of this Account
     */
    protected $_active;
    /**
     * @var bool Flag for reset status of this Account
     */
    protected $_reset;
    /**
     * @var DateTime The creation date of this Account
     */
    protected $_created;
    /**
     * @var DateTime The modification date of this Account
     */
    protected $_modified;

    /**
     * Constructor for this account
     *
     * @param null|array|Zend_Db_Row $params
     */
    public function __construct($params = null)
    {
        $this->setActive(false);
        $this->setReset(false);
        $this->setCreated(new DateTime('now'));
        $this->setModified(new DateTime('now'));
        parent::__construct($params);
    }
    public function setId($accountId)
    {
        $this->_accountId = (int) $accountId;
        return $this;
    }
    public function getId()
    {
        return $this->_accountId;
    }
    public function setFirstName($firstName)
    {
        $this->_firstName = (string) $firstName;
        return $this;
    }
    public function getFirstName()
    {
        return $this->_firstName;
    }
    public function setLastName($lastName)
    {
        $this->_lastName = (string) $lastName;
        return $this;
    }
    public function getLastName()
    {
        return $this->_lastName;
    }
    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }
    public function getEmail()
    {
        return $this->_email;
    }
    public function setPassword($password)
    {
        $this->_password = (string) $password;
        return $this;
    }
    public function getPassword()
    {
        return $this->_password;
    }
    public function setToken($token)
    {
        $this->_token = (string) $token;
        return $this;
    }
    public function getToken()
    {
        return $this->_token;
    }
    public function setActive($active)
    {
        $this->_active = (bool) $active;
        return $this;
    }
    public function isActive()
    {
        return $this->_active;
    }
    public function setReset($reset)
    {
        $this->_reset = (bool) $reset;
        return $this;
    }
    public function isReset()
    {
        return $this->_reset;
    }
    public function setCreated($created)
    {
        if (! $created instanceof DateTime) {
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
        if (! $modified instanceof DateTime) {
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

        if (isset($row->accountId)) {
            $this->setId($row->accountId);
        }
        if (isset($row->firstName)) {
            $this->setFirstName($row->firstName);
        }
        if (isset($row->lastName)) {
            $this->setLastName($row->lastName);
        }
        if (isset($row->email)) {
            $this->setEmail($row->email);
        }
        if (isset($row->password)) {
            $this->setPassword($row->password);
        }
        if (isset($row->token)) {
            $this->setToken($row->token);
        }
        if (isset($row->active)) {
            $this->setActive($row->active);
        }
        if (isset($row->reset)) {
            $this->setReset($row->reset);
        }
        if (isset($row->created)) {
            $this->setCreated($row->created);
        }
        if (isset($row->modified)) {
            $this->setModified($row->modified);
        }
        return $this;
    }
    public function toArray()
    {
        return  [
            'accountId' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName'  => $this->getLastName(),
            'email'     => $this->getEmail(),
            'password'  => $this->getPassword(),
            'token'     => $this->getToken(),
            'active'    => $this->isActive() ? 1 : 0,
            'reset'     => $this->isReset() ? 1 : 0,
            'created'   => $this->getCreated()->format('Y-m-d H:i:s'),
            'modified'  => $this->getModified()->format('Y-m-d H:i:s'),
        ];
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
    /**
     * Generates a 40-character random string
     *
     * @return string
     */
    public static function generateToken()
    {
        return sha1(md5(uniqid(null, true)));
    }
}
