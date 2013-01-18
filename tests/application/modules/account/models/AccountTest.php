<?php

class Account_Model_AccountTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array ('John', 'Doe', 'john.doe@example.com', 'test1234'),
            array ('Matthew', "Weier O'Phinney", 'matthew@zend.com', 'goZendFramework2'),
        );
    }
    public function badDataProvider()
    {
        return array (
            array ('', '', '', ''),
        );
    }
    /**
     * @dataProvider goodDataProvider
     */
    public function testCreateNewAccountWithValidDataSucceeds(
            $firstName, $lastName, $email, $password)
    {
        $data = array (
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $password,
        );
        $account = new Account_Model_Account($data);
        $this->assertEquals($data['firstName'], $account->getFirstName());
        $this->assertSame($data['lastName'], $account->getLastName());
        $this->assertSame($data['email'], $account->getEmail());
        $this->assertSame($data['password'], $account->getPassword());
    }
    /**
     * @dataProvider badDataProvider
     * @expectedException InvalidArgumentException
     */
    public function testCreateNewAccountWithInvalidDataFails(
            $firstName, $lastName, $email, $password)
    {
        $data = array (
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $password,
        );
        $account = new Account_Model_Account($data);
    }
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid arguments provided for account ID
     */
    public function testCreateAccountFailsWhenProvidingBadId()
    {
        $data = array (
            'accountId' => 'foo',
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'email' => 'email@example.com',
            'password' => '$password',
        );
        $account = new Account_Model_Account($data);
    }
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid arguments provided for first name
     */
    public function testCreateAccountFailsWhenProvidingBadFirstName()
    {
        $data = array (
            'accountId' => 'foo',
            'firstName' => 'firstName12345',
            'lastName' => 'lastName',
            'email' => 'email@example.com',
            'password' => '$password',
        );
        $account = new Account_Model_Account($data);
    }
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid arguments provided for last name
     */
    public function testCreateAccountFailsWhenProvidingBadLastName()
    {
        $data = array (
            'accountId' => 1,
            'firstName' => 'firstName',
            'lastName' => 12345,
            'email' => 'email@example.com',
            'password' => '$password',
        );
        $account = new Account_Model_Account($data);
        Zend_Debug::dump($account->toArray());
    }
}