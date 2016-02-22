<?php

class Account_Model_AccountTest extends PHPUnit_Framework_TestCase
{
    public function badDataProvider()
    {
        return array (
            array (array('accountId' => 'foo')),
            array (array('accountId' => -1)),
            array (array('firstName' => 123)),
            array (array('lastName' => 123)),
            array (array('email' => 123)),
            array (array('email' => 'foo')),
            array (array('email' => 'John Doe')),
            array (array('password' => 'test')),
            array (array('password' => 1234)),
        );
    }

    /**
     * @dataProvider badDataProvider
     */
    public function testAccountRejectsBadInput($data)
    {
        $account = new Account_Model_Account($data);
        $this->assertFalse($account->getInputFilter()->isValid());
    }
}