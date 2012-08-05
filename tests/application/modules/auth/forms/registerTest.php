<?php

class Auth_Form_RegisterTest extends PHPUnit_Framework_TestCase
{
    public function goodDataProvider()
    {
        return array (
            array ('John Doe', 'john.doe@example.com', 'verySecret', 'verySecret'),
            array ('John Doe', 'john@i.ua', 'verySecret', 'verySecret'),
            array ('John Doe', 'john+test@gmail.com', 'verySecret', 'verySecret'),
            array ('John Doe', 'john.doe@example.com', 'test1234', 'test1234'),
            array ('Hacker Boy', '<a href="http://evil.example.com">hacker@example.com</a>', 'verySecret', 'verySecret'),
            array ("Matthew Weier O'Phinney", 'matthew@zend.com', 'secretPass', 'secretPass'),
            array ("Dr. Keith Casey, Jr.", 'keith@caseysoftware.com', 'monkeyPong', 'monkeyPong'),
        );
    }
    public function badDataProvider()
    {
        return array (
            array ('', 'john.doe@example.com', 'verySecret', 'verySecret'),
            array ('John Doe', '', 'verySecret', 'verySecret'),
            array ('John Doe', 'john.doe@example.com', '', 'verySecret'),
            array ('John Doe', 'john.doe@example.com', 'verySecret', ''),
            array ('', '', '', ''),
            array ('John Doe', 'john.doe@example.com', 'test123', 'test123'),
            array ('John Doe', 'This is not an email address', 'verySecret', 'verySecret'),
        );
    }
    /**
     * @dataProvider goodDataProvider
     */
    public function testRegistrationAcceptsValidData($name, $email, $password, $password2)
    {
        $form = new Auth_Form_Register();
        $token = $form->getElement('token');
        $token->initCsrfToken();
        $token->initCsrfValidator();
        $this->assertTrue($form->isValid(array (
            'name'          => $name,
            'email'         => $email,
            'password'      => $password,
            'passwordCheck' => $password2,
            'token'         => $token->getHash(),
        )));
    }
    /**
     * @dataProvider badDataProvider
     */
    public function testRegistrationRejectsInvalidData($name, $email, $password, $password2)
    {
        $form = new Auth_Form_Register();
        $token = $form->getElement('token');
        $token->initCsrfToken();
        $token->initCsrfValidator();
        $this->assertFalse($form->isValid(array (
            'name'          => $name,
            'email'         => $email,
            'password'      => $password,
            'passwordCheck' => $password2,
            'token'         => $token->getHash(),
        )));
    }
}