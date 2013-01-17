<?php
/**
 * In2it Framework
 * 
 * Extends Zend Framework with custom functionality or overriding ZF 
 * functionality matching needs of the application
 * 
 * @category    In2it
 * @package     In2it
 * @copyright   Copyright (c) 2004 - 2010 In2IT vof. Some rights reserved.
 * @license     http://www.in2it.be/license/new-bsd New-BSD license.
 */
/**
 * In2it_Auth_Adapter_File
 * 
 * This class provides an additional adapter to provide authentication using
 * a simple file for authentication. It stores usernames with hashed passwords,
 * including a salt.
 * 
 * @category   In2it
 * @package    In2it_Auth
 * @subpackage Adapter
 * @copyright   Copyright (c) 2004 - 2010 In2IT vof. Some rights reserved.
 * @license     http://www.in2it.be/license/new-bsd New-BSD license.
 */
class In2it_Auth_Adapter_File implements Zend_Auth_Adapter_Interface
{
    const SALT = '!The W0rld = enough!';
    /**
     * A username string
     *
     * @var string
     */
    protected $_username;
    /**
     * A password string
     *
     * @var string
     */
    protected $_password;
    /**
     * String containing the path to the password file
     *
     * @var string
     */
    protected $_passwordFile;
    
    /**
     * Constructor for this class takes a username, password and filename
     * 
     * @param string $username
     * @param string $password
     * @param string $passwordFile 
     */
    public function __construct ($username, $password, $passwordFile)
    {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setPasswordFile($passwordFile);
    }
    /**
     * Sets the username for this Adapter
     * 
     * @param string $username
     * @return In2it_Auth_Adapter_File 
     */
    public function setUsername ($username)
    {
        $this->_username = (string) $username;
        return $this;
    }
    /**
     * Retrieves the username from this Adapter
     * @return string 
     */
    public function getUsername ()
    {
        return $this->_username;
    }
    /**
     * Sets the password and hashes it directly for this Adapter
     * 
     * @param string $password
     * @return In2it_Auth_Adapter_File 
     */
    public function setPassword ($password)
    {
        $this->_password = md5(self::SALT . (string) $password);
        return $this;
    }
    /**
     * Retrieves the hashed password from this Adapter
     * 
     * @return string
     */
    public function getPassword ()
    {
        return $this->_password;
    }
    /**
     * Sets the password file as backend for this Adapter
     * 
     * @param string $passwordFile
     * @return In2it_Auth_Adapter_File 
     * @throws Zend_Auth_Adapter_Exception
     */
    public function setPasswordFile ($passwordFile)
    {
        if (!file_exists($passwordFile)) {
            throw new Zend_Auth_Adapter_Exception('Password resource not found');
        }
        $this->_passwordFile = (string) $passwordFile;
        return $this;
    }
    /**
     * Retrieves the password file from this Adapter
     * 
     * @return string
     */
    public function getPasswordFile ()
    {
        return $this->_passwordFile;
    }
    /**
     * Performs an authentication using this Adapter
     * 
     * @see Zend_Auth_Adapter_Interface::authenticate()
     * @return Zend_Auth_Result
     * @throws Zend_Auth_Adapter_Exception
     */
    public function authenticate ()
    {
        if (null === $this->getPasswordFile()) {
            throw new Zend_Auth_Adapter_Exception('Password file not provided!');
        }
        $file = file_get_contents($this->getPasswordFile());
        $file = str_replace(array ("\r\n", "\r", "\n"), PHP_EOL, $file);
        $names = explode(PHP_EOL, $file);
        foreach ($names as $identity) {
            if (substr($identity, 0, strlen($this->getUsername())) === $this->getUsername()) {
                $combo = explode(':', $identity);
                if ($combo[1] === $this->getPassword()) {
                    return new Zend_Auth_Result(
                        Zend_Auth_Result::SUCCESS,
                        $this->getUsername(),
                        array ('Authentication successful')
                    );
                }
            }
        }
        return new Zend_Auth_Result(
            Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
            $this->getUsername(),
            array ('Authentication failed')
        );
    }
}