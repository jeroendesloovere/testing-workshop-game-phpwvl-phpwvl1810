<?php

class Account_Form_ForgotTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array ('john@example.com'),
            array ('josh.holmes@microsoft.com'),
            array ('jane+friends@gmail.com'),
        );
    }
    public function badDataProvider()
    {
        return array (
            array (''),
            array ('john'),
            array ('@twitter'),
            array (str_repeat('x', 139) . '@example.com'),
        );
    }
    /**
     * @dataProvider goodDataProvider
     */
    public function testGoodEmailGetsProcessed($email)
    {
        $data = array ('email' => $email);
        $form = new Account_Form_Forgot();
        $this->assertTrue($form->isValidPartial($data));
    }
    /**
     * @dataProvider badDataProvider
     */
    public function testBadEmailGetsRejected($email)
    {
        $data = array ('email' => $email);
        $form = new Account_Form_Forgot();
        $this->assertFalse($form->isValidPartial($data));
    }
}