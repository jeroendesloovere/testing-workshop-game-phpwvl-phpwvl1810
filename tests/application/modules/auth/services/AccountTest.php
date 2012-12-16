<?php

class Auth_Service_AccountTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array ('John Doe', 'john.doe@example.com', 'test1234'),
        );
    }

    /**
     * @dataProvider goodDataProvider
     */
    public function testServiceCanRegisterNewUser($name, $email, $password)
    {
        $data = array (
            'name' => $name,
            'email' => $email,
            'password' => $password,
        );
        $account = new Auth_Service_Account();
        $this->assertTrue($account->registerNewAccount($data));
    }
}
