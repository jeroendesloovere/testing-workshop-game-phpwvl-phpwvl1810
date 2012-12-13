<?php

class Application_Model_AccountTest extends PHPUnit_Framework_TestCase
{
    public function testAccountCanBePopulated()
    {
        $data = array (
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'created' => '2000-01-01 10:00:00',
            'modified' => '2012-06-08 20:00:00',
            'active' => 0,
            'token' => '',
        );
        $account = new Application_Model_Account($data);
        $this->assertSame($data, $account->toArray());
    }
}