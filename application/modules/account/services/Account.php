<?php

class Account_Service_Account extends Application_Service_Abstract
{
    public function __construct($mapper = null)
    {
        if (null === $mapper) {
            $this->setMapper(new Account_Model_AccountMapper());
        }
        parent::__construct($mapper);
    }
    public function createAccount($data)
    {
        $data['password'] = Account_Model_Account::generatePasswordHash($data['password']);
        $data['token'] = Account_Model_Account::generateToken();
        $data['created'] = date('Y-m-d H:i:s');
        $data['modified'] = date('Y-m-d H:i:s');
        
        $account = new Account_Model_Account($data);
        $accountMapper = $this->getMapper();
        
        $accountMapper->save($account);
        return $account;
    }
    public function activateAccount($token)
    {
        $account = new Account_Model_Account();
        $accountMapper = $this->getMapper();
        
        $accountMapper->fetchRow($account, array ('token = ?' => $token));
        if (0 === (int) $account->getId()) {
            return false;
        }
        $account->setActive();
        $accountMapper->save($account);
        return true;
    }
}
