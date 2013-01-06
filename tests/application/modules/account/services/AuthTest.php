<?php

require_once 'DatabaseTestCase.php';
class Account_Service_AuthTest extends DatabaseTestCase
{
    public function testDbAdapterCanBeChanged()
    {
        $dbAdapter = new stdClass();
        $service = new Account_Service_Auth();
        $service->setDbAdapter($dbAdapter);
        
        $this->assertType('stdClass', $service->getDbAdapter());
    }
    public function testValidUserCanAuthenticate()
    {
        $accountMapper = new Application_Model_AccountMapper();
        $dbAdapter = $accountMapper->getDbTable()->getAdapter();
        
        $username = 'john.doe@example.com';
        $password = 'test1234';
        
        $service = new Account_Service_Auth($dbAdapter);
        $this->assertTrue($service->authenticate($username, $password));
    }
    public function testInvalidUserCannotAuthenticate()
    {
        $accountMapper = new Application_Model_AccountMapper();
        $dbAdapter = $accountMapper->getDbTable()->getAdapter();
        
        $username = 'jane.doe@example.com';
        $password = 'abcd1234';
        
        $service = new Account_Service_Auth($dbAdapter);
        $this->assertFalse($service->authenticate($username, $password));
    }
    public function testNewAccountCanRegister()
    {
        $data = array (
            'firstName' => 'Jonny',
            'lastName' => 'Test',
            'email' => 'jonny.test@example.com',
            'password' => 'Test4Fun',
        );
        
        $service = new Account_Service_Auth();
        $service->registerAccount($data);
        
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('account', 
            'SELECT accountId, firstName, lastName, email, password, active FROM account');
        
        $this->assertDataSetsEqual($this->createFlatXMLDataSet(
            TEST_PATH . '/_files/newAccountDataset.xml'), $ds);
    }
    
    public function testVerifyTokenOnlyChangesActiveFlag()
    {
        $token = 'e896b31e7ea87a0cf38d329e444afe0ff1af7ca7';
        $service = new Account_Service_Auth();
        $service->verifyAccountByToken($token);
        
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('account', 
            'SELECT accountId, firstName, lastName, email, password, token, active FROM account');
        
        $this->assertDataSetsEqual($this->createFlatXMLDataSet(
            TEST_PATH . '/_files/verifyTokenDataset.xml'), $ds);
    }
    
    public function testVerifyTokenExists()
    {
        $token = 'e896b31e7ea87a0cf38d329e444afe0ff1af7ca7';
        $service = new Account_Service_Auth();
        $this->assertTrue($service->tokenExists($token));
        $this->assertFalse($service->tokenExists('blabla'));
    }
    
    public function testVerifyAccountByEmail()
    {
        $email = 'john.doe@example.com';
        $service = new Account_Service_Auth();
        $actual = $service->findAccountByEmail($email);
        
        $expected = array (
            'accountId' => 1,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'YoOX7hibF4h5.',
            'token' => '',
            'created' => '1999-12-31 23:59:59',
            'modified' => '2000-01-01 00:00:00',
            'active' => 1,
        );
        
        $this->assertSame($expected, $actual->toArray());
    }
    
    public function testAccountCanBeReset()
    {
        $account = new Application_Model_Account();
        $accountMapper = new Application_Model_AccountMapper();
        
        $accountMapper->find($account, 1);
        
        $service = new Account_Service_Auth();
        $service->resetAccount($account);
        
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('account', 
            'SELECT accountId, firstName, lastName, email, password, active FROM account');
        
        $this->assertDataSetsEqual($this->createFlatXMLDataSet(
            TEST_PATH . '/_files/resetAccountDataset.xml'), $ds);
    }
    
    public function testNewPasswordCanBeSetForExistingToken()
    {
        $password = 'testing4fun';
        $token = 'e896b31e7ea87a0cf38d329e444afe0ff1af7ca7';
        
        $service = new Account_Service_Auth();
        $this->assertTrue($service->setNewAccountPassword($password, $token));
        
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('account', 
            'SELECT accountId, firstName, lastName, email, password, token, active FROM account');
        
        $this->assertDataSetsEqual($this->createFlatXMLDataSet(
            TEST_PATH . '/_files/newPasswordDataset.xml'), $ds);
    }
    public function testNewPasswordCannotBeSetForNonexistingToken()
    {
        $password = 'testing4fun';
        $token = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMN';
        
        $service = new Account_Service_Auth();
        $this->assertFalse($service->setNewAccountPassword($password, $token));
        
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('account', 
            'SELECT accountId, firstName, lastName, email, password, token, active FROM account');
        
        $this->assertDataSetsEqual($this->createFlatXMLDataSet(
            TEST_PATH . '/_files/noNewPasswordDataset.xml'), $ds);
    }
}