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
}