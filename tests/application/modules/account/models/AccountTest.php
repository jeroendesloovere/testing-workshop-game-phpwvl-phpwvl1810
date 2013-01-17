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
}