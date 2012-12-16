<?php

class Auth_Service_Account
{
    public function registerNewAccount($data)
    {
        $account = new Application_Model_Account($data);
        $accountMapper = new Application_Model_AccountMapper();
        $success = false;
        try {
            $accountMapper->save($account);
            $success = true;
        } catch (Zend_Db_Exception $exception) {
            throw new $exception;
        }
        return $success;
    }
}
