<?php

require_once 'DatabaseTestCase.php';
class Account_Service_AuthTest extends DatabaseTestCase
{
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
    
}