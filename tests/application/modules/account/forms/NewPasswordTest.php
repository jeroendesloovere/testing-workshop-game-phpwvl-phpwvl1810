<?php

class Account_Form_NewPasswordTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array ('test1234', 'test1234'),
            array ('nygy1rawi2zuth1lart5zo8xu','nygy1rawi2zuth1lart5zo8xu'),
            array ('The world is not enough! ', 'The world is not enough! '),
        );
    }
    public function badDataProvider()
    {
        return array (
            array ('',''),
            array ('test123', 'test123'),
            array ('The world is not enough! ', 'The world is not enough!'),
        );
    }
    /**
     * @dataProvider goodDataProvider
     */
    public function testGoodPasswordsAreExcepted($password, $verify)
    {
        $data = array (
            'password' => $password,
            'verify' => $verify,
        );
        $form = new Account_Form_NewPassword();
        $this->assertTrue($form->isValidPartial($data));
    }
    /**
     * @dataProvider badDataProvider
     */
    public function testBadPasswordsAreRejected($password, $verify)
    {
        $data = array (
            'password' => $password,
            'verify' => $verify,
        );
        $form = new Account_Form_NewPassword();
        $this->assertFalse($form->isValidPartial($data));
    }
}