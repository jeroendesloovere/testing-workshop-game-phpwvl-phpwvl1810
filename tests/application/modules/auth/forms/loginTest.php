<?php

class Auth_Form_LoginTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array ('john.doe@example.com', 'verySecret'),
            array ('john@i.ua', 'verySecret'),
            array ('john+test@gmail.com', 'verySecret'),
            array ('john.doe@example.com', 'test1234'),
            array ('<a href="http://evil.example.com">hacker@example.com</a>', 'verySecret'),
        );
    }
    public function badDataProvider()
    {
        return array (
            array ('', 'verySecret'),
            array ('john.doe@example.com', ''),
            array ('', ''),
            array ('john.doe@example.com', 'test123'),
            array ('This is not an email address', 'verySecret'),
        );
    }
    /**
     * @dataProvider goodDataProvider
     */
    public function testLoginFormAcceptsValidAccounts($email, $password)
    {
        $form = new Auth_Form_Login();
        $token = $form->getElement('token');
        $token->initCsrfToken();
        $token->initCsrfValidator();
        $this->assertTrue($form->isValid(array (
            'email'    => $email,
            'password' => $password,
            'token'    => $token->getHash(),
        )));
    }
    /**
     * @dataProvider badDataProvider
     */
    public function testLoginFormRejectsInvalidAccounts($email, $password)
    {
        $form = new Auth_Form_Login();
        $token = $form->getElement('token');
        $token->initCsrfToken();
        $token->initCsrfValidator();
        $this->assertFalse($form->isValid(array (
            'email'    => $email,
            'password' => $password,
            'token'    => $token->getHash(),
        )));
    }
}