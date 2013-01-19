<?php

class Account_Service_AccountTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array ('John', 'Doe', 'john.doe@example.com', 'test1234'),
            array ('Matthew', "Weier O'Phinney", 'matthew@zend.com', 'zf2Power'),
            array ('Keith', 'Casey, Jr.', 'keith@caseysoftware.com', 'monkeyBusiness!'),
        );
    }
    public function badDataProvider()
    {
        return array (
            array ('test', 'test', 'test', 'test', 'test', 'Invalid arguments provided for account ID'),
            array (0, '', '', '', '', 'Invalid arguments provided for first name'),
            array (1, 'firstName1234', 'lastName', 'first.last@example.com', 'test1234', 'Invalid arguments provided for first name'),
            array (2, 'firstName', 'lastName 1234', 'first.last@example.com', 'thisIs@V3ryStrongPwd', 'Invalid arguments provided for last name'),
            array (3, 'firstName', 'lastName', 'first.last @ example.com', 'thisIs@V3ryStrongPwd', 'Invalid arguments provided for email'),
        );
    }
    /**
     * @dataProvider goodDataProvider
     */
    public function testRegisterNewAccountSucceedsWithValidData($firstName, $lastName, $email, $password)
    {
        $data = array (
            'firstName' => $firstName,
            'lastName'  => $lastName,
            'email'     => $email,
            'password'  => $password,
        );
        
        // we need to mock out our mapper model otherwise DB will be hammered!
        $account = new Account_Model_Account($data);
        $account->setId(1);
        $account->setPassword(Account_Model_Account::generatePasswordHash($data['password']));
        $accountMapper = $this->getMock('Account_Model_AccountMapper');
        $accountMapper->expects($this->once())
                      ->method('save')
                      ->will($this->returnValue($account));
        
        // Ok let's check if it's all working now
        $service = new Account_Service_Account($accountMapper);
        $result = $service->createAccount($data);
        $this->assertType('Account_Model_Account', $result);
        $this->assertSame(1, $account->getId());
        $this->assertSame($data['firstName'], $account->getFirstName());
        $this->assertSame($data['lastName'], $account->getLastName());
        $this->assertSame($data['email'], $account->getEmail());
        $this->assertSame(Account_Model_Account::generatePasswordHash($data['password']), $account->getPassword());
    }
    /**
     * @dataProvider badDataProvider
     * @expectedException InvalidArgumentException
     */
    public function testRegisterNewAccountFailsWithInvalidData($accountId, $firstName, $lastName, $email, $password, $message)
    {
        $data = array (
            'accountId' => $accountId,
            'firstName' => $firstName,
            'lastName'  => $lastName,
            'email'     => $email,
            'password'  => $password,
        );
        $service = new Account_Service_Account();
        try {
            $service->createAccount($data);
        } catch (InvalidArgumentException $exception) {
            $this->assertEquals($message, $exception->getMessage());
            throw $exception;
        }
        $this->fail('Expected InvalidArgumentException was not thrown');
    }
    public function testActivateNewAccountWithValidToken()
    {
        $token = Account_Model_Account::generateToken();
        $dataObj = new ArrayIterator(array (
            array (
                'accountId' => 1,
                'firstName' => 'John',
                'lastName'  => 'Doe',
                'email'     => 'john.doe@example.com',
                'password'  => 'password',
                'token'     => $token,
            ),
            array (
                'accountId' => 2,
                'firstName' => 'Jane',
                'lastName'  => 'Doe',
                'email'     => 'jane.doe@example.com',
                'password'  => 'password',
                'token'     => 'Abljdljdjdlkjdaljfdljaldjfjajjelqjre',
            ),
        ));
        
        $accountDb = $this->getMock('Account_Model_DbTable_Account');
        $accountDb->expects($this->once())
                  ->method('fetchRow')
                  ->will($this->returnValue($dataObj[0]));
        $accountDb->expects($this->any())
                  ->method('save')
                  ->will($this->returnValue(true));
        
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->setDbTable($accountDb);
        
        // Ok let's check if it's all working now
        $service = new Account_Service_Account($accountMapper);
        $result = $service->activateAccount($token);
        $this->assertTrue($result);
    }
    public function testActivateNewAccountFailsWithFalseToken()
    {
        $token = Account_Model_Account::generateToken();
        
        $accountDb = $this->getMock('Account_Model_DbTable_Account');
        $accountDb->expects($this->once())
                  ->method('fetchRow')
                  ->will($this->returnValue(null));
        
        $accountMapper = new Account_Model_AccountMapper();
        $accountMapper->setDbTable($accountDb);
        
        // Ok let's check if it's all working now
        $service = new Account_Service_Account($accountMapper);
        $result = $service->activateAccount($token);
        $this->assertFalse($result);
    }
    public function testSigninAccount()
    {
        $username = 'test@example.com';
        $password = 'test1234';
        
        $accountDb->expects($this->once())
                  ->method('fetchRow')
                  ->will($this->returnValue());
    }
    public function testResetAccount()
    {
        
    }
    public function testNewPasswordForAccount()
    {
        
    }
    public function testCancelAccount()
    {
        
    }
}