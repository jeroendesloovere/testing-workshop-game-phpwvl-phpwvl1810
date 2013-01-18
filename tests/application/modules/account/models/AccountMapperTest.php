<?php

class Account_Model_AccountMapperTest extends PHPUnit_Framework_TestCase
{
    protected $_dataObj;
    protected function setUp()
    {
        $this->_dataObj = new ArrayIterator(array (
            array (
                'accountId' => 1,
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'john.doe@example.com',
                'password' => Account_Model_Account::generatePasswordHash('test1234'),
            ),
            array (
                'accountId' => 2,
                'firstName' => 'Jane',
                'lastName' => 'Doe',
                'email' => 'jane.doe@example.com',
                'password' => Account_Model_Account::generatePasswordHash('abcd1234'),
            ),
            array (
                'accountId' => 3,
                'firstName' => 'Matthew',
                'lastName' => 'Weier O\'Phinney',
                'email' => 'matthew@zend.com',
                'password' => 'goZendFramework2!',
            ),
            array (
                'accountId' => 4,
                'firstName' => 'Sebastian',
                'lastName' => 'Bergmann',
                'email' => 'sebastian@php.net',
                'password' => 'Te$t4Fun!',
            )
        ));
    }
    public function testFindAccountById()
    {
        $accountDb = $this->getMock('Account_Model_DbTable_Account');
        $accountDb->expects($this->atLeastOnce())
                  ->method('find')
                  ->will($this->returnValue($this->_dataObj));
        
        $account = new Account_Model_Account();
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->setDbTable($accountDb);
        
        $accountMapper->find($account, 1);
        $this->assertEquals(1, $account->getId());
        $this->assertEquals($this->_dataObj[0]['firstName'], $account->getFirstName());
        $this->assertEquals($this->_dataObj[0]['lastName'], $account->getLastName());
        $this->assertEquals($this->_dataObj[0]['email'], $account->getEmail());
        $this->assertEquals($this->_dataObj[0]['password'], $account->getPassword());
    }
    public function testFindAccountByEmail()
    {
        $accountDb = $this->getMock('Account_Model_DbTable_Account');
        $accountDb->expects($this->atLeastOnce())
                  ->method('fetchRow')
                  ->will($this->returnValue($this->_dataObj[1]));
        
        $account = new Account_Model_Account();
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->setDbTable($accountDb);
        
        $accountMapper->fetchRow($account, array ('email => ?' => 'jane.doe@example.com'));
        $this->assertEquals($this->_dataObj[1]['accountId'], $account->getId());
    }
    public function testInsertNewAccount()
    {
        $nextId = count($this->_dataObj) + 1;
        $accountDbAdapter = $this->getMock(
            'Zend_Db_Adapter_Mysqli', array ('lastInsertId'), array (array (
                'dbname' => 'test',
                'username' => 'foo',
                'password' => 'bar',
            ),
        ));
        $accountDbAdapter->expects($this->atLeastOnce())
                         ->method('lastInsertId')
                         ->will($this->returnValue($nextId));
        
        $accountDb = $this->getMock('Account_Model_DbTable_Account', array ('insert', 'getAdapter'));
        $accountDb->expects($this->atLeastOnce())
                  ->method('insert')
                  ->will($this->returnValue($nextId));
        $accountDb->expects($this->atLeastOnce())
                  ->method('getAdapter')
                  ->will($this->returnValue($accountDbAdapter));
        
        $data = array (
            'firstName' => 'Test',
            'lastName' => 'User',
            'email' => 'test@example.com',
            'password' => 'v3rRy$eCr3t',
        );
        
        $account = new Account_Model_Account($data);
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->setDbTable($accountDb);
        
        $accountMapper->save($account);
        $this->assertSame($nextId, $account->getId());
    }
    public function testUpdateExistingAccount()
    {
        $accountDb = $this->getMock('Account_Model_DbTable_Account', array ('update'));
        $accountDb->expects($this->atLeastOnce())
                  ->method('update')
                  ->will($this->returnValue(null));
        
        $data = array (
            'accountId' => 2,
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane.doe@example.com',
            'password' => 'v3rRy$eCr3t',
        );
        
        $account = new Account_Model_Account($data);
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->setDbTable($accountDb);
        
        $accountMapper->save($account);
        $this->assertSame(2, $account->getId());
        $this->assertSame($data['firstName'], $account->getFirstName());
        $this->assertSame($data['lastName'], $account->getLastName());
        $this->assertSame($data['email'], $account->getEmail());
        $this->assertSame($data['password'], $account->getPassword());
    }
    public function testRetrieveAllAccounts()
    {
        $accountDb = $this->getMock('Account_Model_DbTable_Account');
        $accountDb->expects($this->atLeastOnce())
                  ->method('fetchAll')
                  ->will($this->returnValue($this->_dataObj));
        
        $accountCollection = new Account_Model_AccountCollection();
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->setDbTable($accountDb);
        
        $accountMapper->fetchAll($accountCollection, 'Account_Model_Account');
        $this->assertSame(count($this->_dataObj), count($accountCollection));
        for ($i = 0; $i < count($accountCollection); $i++) {
            $this->assertSame('Account_Model_Account', get_class($accountCollection->seek($i)->current()));
            $this->assertSame($this->_dataObj[$i]['firstName'], $accountCollection->seek($i)->current()->getFirstName());
            $this->assertSame($this->_dataObj[$i]['lastName'], $accountCollection->seek($i)->current()->getLastName());
            $this->assertSame($this->_dataObj[$i]['email'], $accountCollection->seek($i)->current()->getEmail());
            $this->assertSame($this->_dataObj[$i]['password'], $accountCollection->seek($i)->current()->getPassword());
        }
    }
}