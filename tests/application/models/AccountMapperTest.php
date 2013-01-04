<?php

class Application_Model_AccountMapperTest extends PHPUnit_Framework_TestCase
{
    protected $_data = array (
        array (
            'accountId' => 1,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'test1234',
            'token' => '',
            'created' => '1999-12-31 23:59:59',
            'modified' => '2000-01-01 00:00:00',
            'active' => 1,
        ),
        array (
            'accountId' => 2,
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane.doe@example.com',
            'password' => 'abcd1234',
            'token' => '',
            'created' => '2000-02-29 00:00:00',
            'modified' => '2000-10-28 03:00:00',
            'active' => 1,
        ),
    );
    
    public function testAccountCanRetrieveData()
    {
        $dbAdapter = $this->getMock('Application_Model_DbTable_Account');
        $dbAdapter->expects($this->atLeastOnce())
                  ->method('fetchRow')
                  ->will($this->returnValue($this->_data[1]));
        
        $accountMapper = new Application_Model_AccountMapper();
        $accountMapper->setDbTable($dbAdapter);
        
        $account = new Application_Model_Account();
        $accountMapper->fetchRow($account, array ('accountId = ?' => 2));
        $data = $this->_data[1];
        $this->assertEquals($data, $account->toArray());
    }
}