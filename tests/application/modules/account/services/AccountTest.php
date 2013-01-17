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
            array ('', '', '', ''),
            array ('test', 'test', 'test', 'test'),
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
     * @expectedExceptionMessage Invalid arguments provided for creating an account
     */
    public function testRegisterNewAccountFailsWithInvalidData($firstName, $lastName, $email, $password)
    {
        $data = array (
            'firstName' => $firstName,
            'lastName'  => $lastName,
            'email'     => $email,
            'password'  => $password,
        );
        $service = new Account_Service_Account();
        $service->createAccount($data);
    }
    public function testActivateNewAccount()
    {
        
    }
    public function testSigninAccount()
    {
        
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