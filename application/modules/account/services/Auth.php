<?php

class Account_Service_Auth
{
    protected $_dbAdapter;
    
    public function __construct($dbAdapter = null)
    {
        if (null !== $dbAdapter) {
            $this->setDbAdapter($dbAdapter);
        }
    }
    public function setDbAdapter($dbAdapter)
    {
        $this->_dbAdapter = $dbAdapter;
    }
    public function getDbAdapter()
    {
        return $this->_dbAdapter;
    }
    public function authenticate($username, $password)
    {
        $auth = Zend_Auth::getInstance();
        $authAdapter = new Application_Model_Auth($username, $password);
        
        $authAdapter->setDbAdapter($this->getDbAdapter());
        $result = $auth->authenticate($authAdapter);
        
        if (!$result->isValid()) {
            return false;
        }
        $storage = $auth->getStorage();
        $account = new Application_Model_Account($authAdapter->getResultRowObject());
        $storage->write(serialize($account));
        return true;
    }
}