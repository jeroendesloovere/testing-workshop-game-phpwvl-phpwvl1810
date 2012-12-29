<?php
/**
 * @group Account_Form
 * @group Form
 */
class Account_Form_LoginTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array ('john.doe@example.com', 'abcd1234'),
        );
    }
    public function badDataProvider()
    {
        return array (
            array ('',''),
            array ('test', 'test'),
            array ('john.doe@example.com', ''),
            array ('', 'abcd1234'),
        );
    }
    
    /**
     * @dataProvider goodDataProvider
     */
    public function testFormAcceptsGoodValues($username, $password)
    {
        $form = new Account_Form_Login();
        
        $data = array (
            'email' => $username,
            'password' => $password,
        );
        $result = $form->isValid($data);
        $this->assertTrue($form->isValidPartial($data));
    }
    /**
     * @dataProvider badDataProvider
     */
    public function testFormRejectsBadValues($username, $password)
    {
        $form = new Account_Form_Login();
        
        $data = array (
            'email' => $username,
            'password' => $password,
        );
        $result = $form->isValid($data);
        $this->assertFalse($form->isValidPartial($data));
    }
}