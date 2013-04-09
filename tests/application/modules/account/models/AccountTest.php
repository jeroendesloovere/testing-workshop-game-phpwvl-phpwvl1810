<?php
/**
 * Class Account_Model_AccountTest
 *
 * @group Account_Model_AccountTest
 * @group Account
 */
class Account_Model_AccountTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array (array (
                'accountId' => 1,
                'firstName' => 'John',
                'lastName'  => 'Doe',
                'email'     => 'john.doe@example.com',
                'password'  => 'test1234',
                'token'     => '',
                'active'    => 1,
                'reset'     => 0,
                'created'   => '2013-01-01 00:00:00',
                'modified'  => '2013-01-01 00:00:00',
            )),
            array (array (
                'accountId' => 2,
                'firstName' => 'Jane',
                'lastName'  => 'Doe',
                'email'     => 'jane.doe+example@example.com',
                'password'  => 'Тестирование для удовольствия',
                'token'     => '0a117502f3f357e4f139930d1402f74e91f73002',
                'active'    => 0,
                'reset'     => 1,
                'created'   => '2013-01-01 00:00:00',
                'modified'  => '2013-01-01 00:00:00',
            )),
        );
    }

    /**
     * @dataProvider goodDataProvider
     */
    public function testAccountCanBeProvided($data)
    {
        $account = new Account_Model_Account($data);
        $this->assertEquals($data, $account->toArray());
    }
}