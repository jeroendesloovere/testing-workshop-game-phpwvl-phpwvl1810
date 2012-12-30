<?php
/**
 * TheiaLive
 * 
 * @copyright In2it vof (c) 2012. All rights reserved
 * @link http://in2it.be
 */
/**
 * Application_Model_Auth
 * 
 * @package Application_Model
 * @category Auth
 */
class Application_Model_Auth implements Zend_Auth_Adapter_Interface
{
    /**
     * @var string The email account to authenticate
     */
    protected $_email;
    /**
     * @var string The password to authenticate
     */
    protected $_password;
    /**
     * @var Zend_DB_Adapter_Abstract
     */
    protected $_dbAdapter;
    
    protected $_resultRowObject;
    /**
     * Constructor for this authenctication class
     * 
     * @param string $email
     * @param string $password 
     */
    public function __construct($email, $password)
    {
        $this->_email = (string) $email;
        $this->_password = Application_Model_Account::generatePasswordHash($password);
    }
    /**
     * Sets the database adapter to authenticate against a DB back end
     * 
     * @param Zend_Db_Adapter_Abstract $adapter
     * @return Application_Model_Auth
     */
    public function setDbAdapter(Zend_Db_Adapter_Abstract $adapter)
    {
        $this->_dbAdapter = $adapter;
        return $this;
    }
    /**
     * Retrieves the database adapter
     * 
     * @return Zend_Db_Adapter_Abstract
     */
    public function getDbAdapter()
    {
        return $this->_dbAdapter;
    }
    /**
     * Perform the authentication
     * 
     * @see Zend_Auth_Adapter_Interface::authenticate()
     */
    public function authenticate()
    {
        if (!isset ($this->_dbAdapter)) {
            throw new ErrorException('Database adapter not set');
        }
        
        $this->_dbAdapter->getProfiler()->setEnabled(true);
        
        $authAdapter = new Zend_Auth_Adapter_DbTable(
                $this->_dbAdapter,
                'account',
                'email',
                'password');
        
        $authAdapter->setIdentity($this->_email)
                    ->setCredential($this->_password);
        
        $authAdapter->setCredentialTreatment('? AND `active` = 1');
        
        $result = $authAdapter->authenticate();
        
        // Only when we have a valid authentication, the result row object is
        // of importance
        if ($result->isValid()) {
            $this->_resultRowObject = $authAdapter->getResultRowObject();
        }
        return $result;
    }
    
    public function getResultRowObject()
    {
        return $this->_resultRowObject;
    }

}
